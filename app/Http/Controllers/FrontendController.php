<?php

namespace App\Http\Controllers;

use App\Mail\ContactForm;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Mail;

class FrontendController extends Controller
{
    public function index()
    {
        flash()->success('Welcome to Laraspace');
        return view('front.index');
    }

    public function contatoPost(Request $request)
    {
        $this->validate($request, [
            'sender_name' => 'required|max:255',
            'sender_mail' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $subject = $request->input('subject');
        $sender_mail = $request->input('sender_mail');
        $sender_name = $request->input('sender_name');
        $message = $request->input('message');

        Mail::to(config('mail.contact'))->send(new ContactForm($subject, $sender_mail, $sender_name, $message));
        return redirect()->route('contatoPost')->with('success', 'Sua mensagem foi enviada com sucesso!');
    }

    public function messages()
    {
        return [
            'sender_name.required' => 'A title is required'
        ];
    }

}
