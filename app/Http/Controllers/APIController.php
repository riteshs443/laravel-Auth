<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use DB;
use JWTAuth;
use App\Http\Controllers\eddofamail;
use App\Http\Requests;
use App\Http\Response;

class APIController extends Controller
{
    public function register(Request $request)
    {        
    	$input = $request->all();
        $hashemail = Hash::make($request->email);
    	$input['password'] = Hash::make($input['password']);
    	User::create($input);
        return response()->json(['result'=>true,"link"=>$hashemail]);
    }
    
    public function login(Request $request)
    {
    	$input = $request->all();
    	if (!$token = JWTAuth::attempt($input)) {
            return response()->json(['result' => 'wrong email or password.']);
        }
        	return response()->json(['result' => $token]);
    }
    
    public function get_user_details(Request $request)
    {
    	$input = $request->all();
    	$user = JWTAuth::toUser($input['token']);
        return response()->json(['result' => $user]);
    }

    public function changepwd(Request $request)
    {
        $newpwd = Hash::make($request->newpwd);
        $email  = $request->email;
        $user   = DB::table('users')->where('email', $email)->first();
        if (Hash::check($request->oldpwd, $user->password)){
           $ref =DB::table('users')->where('email', $email)->update(['password' => $newpwd]);
           return response()->json(['result' => "password change",'code' => $ref]);
        }else{
           return response()->json(['result' => "password does not match",'code' => 0]);
        }
    }

    public function forgetpwd(Request $request){
        $email = $request->email;
        $name = $request->name;
        $id = uniqid();
        $ref =DB::table('users')->where('email', $email)->update(['emailforgetid' => $id]);
        $mailresult = (new eddofamail)->forgetpwd($name,$email,$id);
        return response()->json(['result' => "mailsent",'code' => $ref]);
    }

    public function forgetpwdupdate(Request $request){
       $email = $request->email;
       $newpwd = Hash::make($request->newpwd);
       $id = $request->id;
       $ref =DB::table('users')->where('email', $email)->where('emailforgetid', $id)->update(['password' => $newpwd]);
        return response()->json(['result' => "password change",'code' => $ref]);  
    }

    public function verifyemail(Request $request){
        $email = $request->email;
        $verifylink =  $request->verifylink;
        if (Hash::check($request->email, $request->verifylink)){
           $ref =DB::table('users')->where('email', $email)->update(['emailverify' => "true"]);
           return response()->json(['result' => "email verify",'code' => $ref]);
        }else{
           return response()->json(['result' => "email not verify",'code' => 0]);
        }
    }
}
