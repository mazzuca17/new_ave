<?php

namespace App\Http\Controllers;

use App\Models\Emails;
use App\Models\EmailsAttachments;
use App\Models\EmailsRecipient;
use App\Models\Messages;
use App\Models\User;
use App\Notifications\AnnouncementNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Str;


class EmailController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->get('q');

        $messages = EmailsRecipient::with('email.sender', 'email.attachments')
            ->where('recipient_id', $user->id)
            ->whereNull('deleted_at')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('email', function ($q2) use ($search) {
                        $q2->where('subject', 'like', "%$search%");
                    })->orWhereHas('email.sender', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%");
                    });
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10);


        Log::debug($messages);

        $count_no_read = EmailsRecipient::where('is_read', false)->where('recipient_id', Auth::user()->id)->count();

        return view('messages.index', compact('messages', 'count_no_read'));
    }

    public function create()
    {
        $users = User::with('roles')
            ->where('school_id',  Auth::user()->school->id)
            ->where('id', '!=', Auth::user()->id)
            ->get()
            ->sortBy([
                fn($a, $b) => strcmp($a->roles->first()->name, $b->roles->first()->name),
                fn($a, $b) => strcmp($a->last_name, $b->last_name),
            ]);


        $count_no_read = EmailsRecipient::where('is_read', false)->where('recipient_id', Auth::user()->id)->count();
        return view('messages.create', compact('users', 'count_no_read'));
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'subject'       => 'required|string|max:1000',
            'message'       => 'required',
            'attachments.*' => 'file|max:2048|mimes:jpg,jpeg,png,pdf,doc,docx'
        ]);

        DB::beginTransaction();

        try {
            $recipients = $this->getRecipients($request->input('to'));

            $message = $this->saveSenderEmailData($request);

            if ($request->hasFile('attachments')) {
                $this->saveAttachments($request->file('attachments'), $message->id);
            }

            foreach ($recipients as $recipient) {
                EmailsRecipient::create([
                    'email_id'     => $message->id,
                    'recipient_id' => $recipient->id,
                    'is_read'      => false,
                    'created_at'   => now(),
                    'updated_at'   => now()
                ]);
            }

            // Envío de notificaciones
            if ($recipients->count() > 1) {
                Notification::send($recipients, new AnnouncementNotification($message));
            } elseif ($recipients->count() === 1) {
                $recipients->first()->notify(new AnnouncementNotification($message));
            }

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Error al enviar mensaje: {$e->getMessage()}");

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    private function getRecipients($to)
    {
        if (Str::startsWith($to, 'role:')) {
            $role = Str::after($to, 'role:');
            return User::whereHas('roles', fn($q) => $q->where('name', $role))->get();
        }

        if ($to == '0') {
            return User::where('id', '!=', Auth::id())->get();
        }


        return User::where('id', $to)->get();
    }

    private function saveSenderEmailData(Request $request)
    {
        return Emails::create([
            'school_id'       => Auth::user()->school->id,
            'sender_id'       => Auth::id(),
            'subject'         => $request->input('subject'),
            'body'            => $request->input('message'),
            'has_attachments' => $request->hasFile('attachments'),
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }

    private function saveAttachments(array $files, int $emailId)
    {
        foreach ($files as $file) {
            $path = $file->store('attachments', 'public');

            EmailsAttachments::create([
                'email_id'     => $emailId,
                'file_path'    => $path,
                'file_name'    => '', // Puedes capturar el nombre original si deseas
                'mime_type'    => $file->getClientMimeType(),
            ]);
        }
    }

    public function show(int $message_id)
    {
        $data_message = EmailsRecipient::with('email.sender', 'email.attachments')
            ->where('recipient_id', Auth::id())
            ->where('id', $message_id)
            ->firstOrFail();
        Log::debug($data_message);
        $count_no_read = EmailsRecipient::where('is_read', false)->where('recipient_id', Auth::user()->id)->count();
        return view('messages.detail_message', compact('data_message', 'count_no_read'));
    }
}
