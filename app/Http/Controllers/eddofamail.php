<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;
use App\Http\Response;

class eddofamail extends Controller
{

    public function register(Request $request){
    	 $data = array('name'=> $request->input('name'),'email'=>  $request->input('email'),'link'=>$request->input('link'));
        Mail::send('register', $data, function($message)  use ($data)
        {
         $message->to($data['email'])->subject
            ('Register Successfull');
         $message->from('riteshanhad@gmail.com','support');
        });
      return response("Successfull");
    }


    public function forgetpwd($name,$email,$id){
       $data = array('name'=> $name,'email'=> $email,'id'=> $id);
        Mail::send('forget', $data, function($message)  use ($data)
        {
         $message->to($data['email'])->subject
            ('Forget password');
         $message->from('riteshanhad@gmail.com','support');
        });
      return response("Successfull");
    }
}
