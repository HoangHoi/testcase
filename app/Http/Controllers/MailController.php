<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function send(Request $request)
    {
        $input = $request->all();
        Mail::send('mailTp', array('name'=>$input["name"],'email'=>$input["email"], 'content'=>$input['comment']), function($message){
            $message->to('hoanghoi1310@gmail.com', 'Visitor')->subject('Visitor Feedback!');
        });
        echo 'Send message successfully!';
//        Session::flash('flash_message', 'Send message successfully!');

//        return view('form');
    }
}
