<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Chat;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home(){
        return view('home');
    }

    public function chat()
    {
        $conversations = Chat::conversations(Chat::conversations()->conversation)
          ->setParticipant(auth()->user())
          ->get()
          ->toArray()['data'];

        $conversations = Arr::pluck($conversations, 'conversation_id');

        $data = [
            'conversations' => array_map('intval', $conversations),
            'participant' => [
                'id' => auth()->user()->id,
                'type' => get_class(auth()->user())
            ]
        ];

        return view('chat', $data);
    }

    public function profile(){
        return view('profile');
    }

    public function profilephoto(Request $request){
        if($request->hasFile('photo')){
            $filename = Auth()->user()->id.time().$request->photo->getClientOriginalName();
            $request->photo->storeAs('avatar', $filename, 'public');
            Auth()->user()->update([ 'photo' => $filename ]);
        }
        return redirect()->back();
    }

    public function profileuser(Request $request){
        $validated = $request->validate([
            'name' => 'required',
        ]);
        Auth()->user()->name = $request->name;
        Auth()->user()->school = $request->school;
        Auth()->user()->city = $request->city;
        Auth()->user()->country = $request->country;
        Auth()->user()->biography = $request->biography;
        Auth()->user()->save();
        return redirect()->back()->with('message', 'Your profile has been updated!');;
    }
}
