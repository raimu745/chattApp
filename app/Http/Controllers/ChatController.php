<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChatController extends Controller
{
    function index(){
        // dd('chat');
        $users = User::where('id','!=', Auth::user()->id)->get();
        // dd($users);
        return view('chat',compact('users'));
    }
    function storeMsg(Request $request){
        // dd(auth()->user()->id);
        // dd($request->receiver_id);



      $message = new Message();
      $message->message = $request->message;
      date_default_timezone_set('Asia/Karachi');
      $time = date("h:i:sa");
      $message->time = $time;
      $message->reciever_id = $request->receiver_id;
      $message->sender_id = auth()->user()->id;
      $message->save();
        // dd($message);

       return response()->json([
           'msg'=> 'data inserted into db'
       ]);


    }

    function getMessage(Request $request){
        // dd(123);
        $message = Message::where([['sender_id',$request->sender_id],['reciever_id',$request->receiver_id]])->orWhere([['sender_id',$request->receiver_id],['reciever_id',$request->sender_id]])->get();

        return response()->json([
            'msg'=> $message
        ]);
    }
}
