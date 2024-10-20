<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;  
use Illuminate\Support\HtmlString;
class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        Mail::send([], [], function ($message) use ($data) {
            $message->to('byholtman@gmail.com')
                    ->replyTo($data['email'])
                    ->subject('Nuevo mensaje de contacto')
                    ->html("
                        <p><strong>Nombre:</strong> {$data['name']}</p>
                        <p><strong>Correo:</strong> {$data['email']}</p>
                        <p><strong>Mensaje:</strong><br>{$data['message']}</p>
                    ");
        });

        return back()->with('success', 'Mensaje enviado con éxito');
    }
}
