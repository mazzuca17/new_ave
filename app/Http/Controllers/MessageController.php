<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Announcements as Message; // Modelo de mensaje (asegúrate de crearlo)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Muestra la lista de mensajes para el usuario actual
    public function index()
    {
        // Obtener los mensajes del usuario autenticado
        $user = Auth::user();


        return view('school.announcements.index');
    }

    // Muestra el formulario para crear un nuevo mensaje
    public function create()
    {
        return view('schools.messages.create');
    }

    // Enviar un nuevo mensaje
    public function send(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id', // Asegúrate de que el destinatario existe
            'content' => 'required|string|max:1000', // Contenido del mensaje
        ]);

        // Crear el mensaje
        $message = new Message();
        $message->sender_id = Auth::id();
        $message->recipient_id = $validated['recipient_id'];
        $message->content = $validated['content'];
        $message->save();

        return redirect()->route('school.mensajes.index')->with('success', 'Mensaje enviado correctamente');
    }

    // Muestra el contenido de un mensaje específico
    public function show($id)
    {
        $message = Message::findOrFail($id);

        // Verifica si el mensaje pertenece al usuario autenticado
        if ($message->sender_id != Auth::id() && $message->recipient_id != Auth::id()) {
            return abort(403, 'No tienes permisos para ver este mensaje.');
        }

        return view('schools.messages.show', compact('message'));
    }

    // Elimina un mensaje específico
    public function destroy($id)
    {
        $message = Message::findOrFail($id);

        // Verifica si el mensaje pertenece al usuario autenticado
        if ($message->sender_id != Auth::id() && $message->recipient_id != Auth::id()) {
            return abort(403, 'No tienes permisos para eliminar este mensaje.');
        }

        $message->delete();

        return redirect()->route('school.mensajes.index')->with('success', 'Mensaje eliminado correctamente');
    }
}
