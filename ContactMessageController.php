<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    //function for creating and retuning contact form
    public function create()
    {
      return view('contact');
    }

    //function for storing dat recieved from the contact form
    public function store(Request $request)
    {
      //Prints everything to screen: testing use;    dd($request->all());

      //validate email
      $this->validate($request, [
        'name' => 'required|max:50',
        'email' => 'nullable|email|max:250',
        'message' => 'required|max:750'
      ]);

      //send email
      Mail::send('emails.contact-message', [
        'msg' => $request->message
      ], function($mail) use($request){
          $mail->from($request->email, $request->name);

          $mail->to('dustinledbetter9@gmail.com')->subject('Contact Message');

      });

      //return message for user
      return redirect()->back()->with('flash_message', 'Thank you for your message.');
    }
}
