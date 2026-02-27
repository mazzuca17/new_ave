<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\ForumComment;
use App\Models\ForumMessage;
use App\Models\ForumMessageAttachment;
use App\Models\Materias;
use App\Models\User;
use App\Notifications\ForumMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ForumController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $subjectIds = $this->getUserSubjectIds($user);

        $materias = Materias::query()
            ->where('school_id', $user->school_id)
            ->whereIn('id', $subjectIds)
            ->with(['cursos', 'forums' => function ($query) {
                $query->withCount('messages')->orderByDesc('updated_at');
            }])
            ->orderBy('nombre')
            ->get();

        return view('forums.index', compact('materias'));
    }

    public function create()
    {
        $this->authorizeManagement();

        $materias = Materias::query()
            ->where('school_id', Auth::user()->school_id)
            ->orderBy('nombre')
            ->get();

        return view('forums.form', [
            'forum' => new Forum(),
            'materias' => $materias,
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeManagement();

        $validated = $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'title' => 'required|string|max:150',
            'description' => 'nullable|string|max:2000',
        ]);

        Forum::create([
            'school_id' => Auth::user()->school_id,
            'materia_id' => $validated['materia_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
            'is_active' => true,
        ]);

        return redirect()->route('forums.index')->with('success', 'Foro creado correctamente.');
    }

    public function show($id)
    {
        $forum = Forum::with(['materia.cursos', 'messages.user', 'messages.attachments', 'messages.comments.user'])
            ->findOrFail($id);

        $this->authorizeForumAccess($forum);

        return view('forums.show', compact('forum'));
    }

    public function edit($id)
    {
        $this->authorizeManagement();
        $forum = Forum::findOrFail($id);

        $materias = Materias::query()
            ->where('school_id', Auth::user()->school_id)
            ->orderBy('nombre')
            ->get();

        return view('forums.form', [
            'forum' => $forum,
            'materias' => $materias,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorizeManagement();
        $forum = Forum::findOrFail($id);

        $validated = $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'title' => 'required|string|max:150',
            'description' => 'nullable|string|max:2000',
        ]);

        $forum->update([
            'materia_id' => $validated['materia_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('forums.show', $forum->id)->with('success', 'Foro actualizado correctamente.');
    }

    public function toggleStatus($id)
    {
        $this->authorizeManagement();
        $forum = Forum::findOrFail($id);

        $forum->is_active = !$forum->is_active;
        $forum->disabled_at = $forum->is_active ? null : now();
        $forum->updated_by = Auth::id();
        $forum->save();

        return redirect()->route('forums.show', $forum->id)->with('success', 'Estado del foro actualizado.');
    }

    public function storeMessage(Request $request, $forumId)
    {
        $forum = Forum::findOrFail($forumId);
        $this->authorizeForumAccess($forum);

        if (!$forum->is_active) {
            return back()->with('error', 'No se pueden publicar mensajes en foros inactivos.');
        }

        $validated = $request->validate([
            'body' => 'required|string|max:5000',
            'attachments.*' => 'file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip',
        ]);

        DB::transaction(function () use ($validated, $request, $forum) {
            $message = ForumMessage::create([
                'forum_id' => $forum->id,
                'user_id' => Auth::id(),
                'body' => $validated['body'],
            ]);

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('forum_attachments', 'public');
                    ForumMessageAttachment::create([
                        'forum_message_id' => $message->id,
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getClientMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }

            $recipients = $this->getForumUsers($forum)->where('id', '!=', Auth::id());
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new ForumMessageNotification($forum, $message));
            }
        });

        return redirect()->route('forums.show', $forum->id)->with('success', 'Mensaje publicado correctamente.');
    }

    public function storeComment(Request $request, $forumId, $messageId)
    {
        $forum = Forum::findOrFail($forumId);
        $this->authorizeForumAccess($forum);

        if (!$forum->is_active) {
            return back()->with('error', 'No se pueden comentar foros inactivos.');
        }

        $request->validate([
            'body' => 'required|string|max:1500',
        ]);

        $message = ForumMessage::where('forum_id', $forum->id)->findOrFail($messageId);

        ForumComment::create([
            'forum_message_id' => $message->id,
            'user_id' => Auth::id(),
            'body' => $request->input('body'),
        ]);

        return redirect()->route('forums.show', $forum->id)->with('success', 'Comentario agregado correctamente.');
    }

    private function authorizeManagement()
    {
        if (!Auth::user()->hasAnyRole(['Colegio', 'Docente'])) {
            abort(403);
        }
    }

    private function authorizeForumAccess(Forum $forum)
    {
        $user = Auth::user();
        if ((int) $forum->school_id !== (int) $user->school_id) {
            abort(403);
        }

        $subjectIds = $this->getUserSubjectIds($user);
        if (!$subjectIds->contains((int) $forum->materia_id)) {
            abort(403);
        }
    }

    private function getUserSubjectIds(User $user)
    {
        if ($user->hasRole('Colegio')) {
            return Materias::where('school_id', $user->school_id)->pluck('id');
        }

        if ($user->hasRole('Docente')) {
            return DB::table('subject_teacher as st')
                ->join('profesors as p', 'p.id', '=', 'st.teacher_id')
                ->where('p.user_id', $user->id)
                ->pluck('st.subject_courses_id')
                ->unique()
                ->values();
        }

        if ($user->hasAnyRole(['Alumno', 'Estudiante'])) {
            return DB::table('students')
                ->join('materias', 'materias.curso_id', '=', 'students.curso_id')
                ->where('students.user_id', $user->id)
                ->pluck('materias.id')
                ->unique()
                ->values();
        }

        return collect();
    }

    private function getForumUsers(Forum $forum)
    {
        $teacherUserIds = DB::table('subject_teacher as st')
            ->join('profesors as p', 'p.id', '=', 'st.teacher_id')
            ->where('st.subject_courses_id', $forum->materia_id)
            ->pluck('p.user_id');

        $studentUserIds = DB::table('materias')
            ->join('students', 'students.curso_id', '=', 'materias.curso_id')
            ->where('materias.id', $forum->materia_id)
            ->pluck('students.user_id');

        $schoolUsers = User::role('Colegio')
            ->where('school_id', $forum->school_id)
            ->pluck('id');

        $userIds = $teacherUserIds
            ->merge($studentUserIds)
            ->merge($schoolUsers)
            ->unique()
            ->values();

        return User::whereIn('id', $userIds)->get();
    }
}
