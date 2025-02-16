<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AnnouncementFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Notifications\AnnouncementNotification;
use Illuminate\Support\Facades\Notification;

class MessageController extends Controller
{
    // Muestra la lista de mensajes para el usuario actual
    public function index()
    {
        // Obtener los mensajes del usuario autenticado
        $users         = $this->getListUser();
        $messages      = Announcement::where('to_user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $count_no_read = Announcement::where('to_user_id', Auth::user()->id)->where('is_read', false)->count();

        return view('announcements.index', compact('users', 'messages', 'count_no_read'));
    }

    // Muestra el formulario para crear un nuevo mensaje
    public function create()
    {
        $users = $this->getListUser();
        $count_no_read = Announcement::where('to_user_id', Auth::user()->id)->where('is_read', false)->count();

        return view('announcements.create', compact('users', 'count_no_read'));
    }

    protected function getListUser()
    {
        return DB::table('users')
            ->leftJoin('profesors', function ($join) {
                $join->on('profesors.user_id', '=', 'users.id')
                    ->where('profesors.school_id', '=', Auth::user()->school->id);
            })
            ->leftJoin('students', function ($join) {
                $join->on('students.user_id', '=', 'users.id')
                    ->where('students.school_id', '=', Auth::user()->school->id);
            })
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id') // Para obtener los roles
            ->whereNotNull('profesors.id')
            ->orWhereNotNull('students.id')
            ->distinct()
            ->select(
                'users.*',
                'profesors.image_profile as profesor_image',
                'students.image_profile as student_image',
                'roles.name as role_name' // Para obtener el nombre del rol
            )
            ->get();
    }

    // Enviar un nuevo mensaje
    public function send(Request $request)
    {
        Log::debug($request->all());

        // Validar los datos del formulario
        $validated = $request->validate([
            'subject'       => 'required|string|max:1000', // Asunto del mensaje
            'message'       => 'required', // Contenido del mensaje
            'attachments.*' => 'file|max:2048|mimes:jpg,jpeg,png,pdf,doc,docx' // Adjuntos permitidos
        ]);

        DB::beginTransaction();

        try {
            // Crear el mensaje
            $message = new Announcement();
            $message->school_id      = Auth::user()->school->id;
            $message->sender_user_id = Auth::id();
            $message->to_user_id     = $request->get('to') == 0 ? null : $request->get('to');
            $message->subject        = $validated['subject'];
            $message->content        = $validated['message'];
            $message->save();

            // Procesar los archivos adjuntos si existen
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('attachments', 'public'); // Guarda en storage/app/public/attachments

                    // Guardar el archivo en la tabla announcements_files
                    AnnouncementFile::create([
                        'announcement_id' => $message->id, // Relacionar con el mensaje
                        'file_path'       => $path,
                        'file_type'       => $file->getClientMimeType(),
                    ]);
                }
            }

            if (is_null($message->to_user_id)) {
                $users = User::where('school_id', Auth::user()->school->id)->get();
                Notification::send($users, new AnnouncementNotification($message));
            } else {
                $user = User::find($message->to_user_id);
                if ($user) {
                    $user->notify(new AnnouncementNotification($message));
                }
            }

            DB::commit();

            // Mensaje de éxito para SweetAlert
            return response()->json([
                'success' => true,
                'message' => 'Mensaje enviado correctamente'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error al enviar mensaje: " . $e->getMessage());

            // Mensaje de error para SweetAlert
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // Muestra el contenido de un mensaje específico
    public function show($id)
    {
        $message = Announcement::findOrFail($id);

        // Verifica si el mensaje pertenece al usuario autenticado
        if ($message->sender_id != Auth::id() && $message->recipient_id != Auth::id()) {
            return abort(403, 'No tienes permisos para ver este mensaje.');
        }

        return view('announcements.show', compact('message'));
    }

    // Elimina un mensaje específico
    public function destroy($id)
    {
        $message = Announcement::findOrFail($id);

        // Verifica si el mensaje pertenece al usuario autenticado
        if ($message->sender_id != Auth::id() && $message->recipient_id != Auth::id()) {
            return abort(403, 'No tienes permisos para eliminar este mensaje.');
        }

        $message->delete();

        return redirect()->route('school.mensajes.index')->with('success', 'Mensaje eliminado correctamente');
    }

    // 📌 Enviar a papelera
    public function trash($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete(); // Soft delete

        return redirect()->route('school.mensajes.index')->with('success', 'Mensaje enviado a la papelera.');
    }

    // 📌 Restaurar desde papelera
    public function restore($id)
    {
        $announcement = Announcement::onlyTrashed()->findOrFail($id);
        $announcement->restore(); // Restaurar

        return redirect()->route('school.mensajes.index')->with('success', 'Mensaje restaurado correctamente.');
    }

    public function viewTrash()
    {
        $messages = Announcement::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        $count_no_read = Announcement::where('to_user_id', Auth::user()->id)->where('is_read', false)->count();

        return view('announcements.trash', compact('messages', 'count_no_read'));
    }
}
