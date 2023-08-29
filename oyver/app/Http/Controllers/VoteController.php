<?php

namespace App\Http\Controllers;

use App\Models\Pool;
use App\Models\User;
use App\Models\Vote;
use App\Models\Option;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function saveVote(Request $request){
        
        $pool = Pool::find(Option::find($request->option)->pool_id);
        if($request->option == null){
            return redirect()->back()->withErrors(['vote' => 'Oyunuzu seçiniz.']);
        }
        
        if (!User::hasUserVoted(auth()->id(),Option::find($request->option)->pool_id)){
            if(strtotime($pool->poolEndTime) == ""  ? true : strtotime($pool->poolEndTime ) > time()){
            $vote = new Vote();
            $vote->user_id = auth()->id();
            $vote->option_id = $request->option;
            $vote->pool_id = $pool->id;
            $vote->save();
        
            return  back()->with('message','Başarıyla oy kullandınız.');
            } else {
                return redirect()->back()->withErrors(['vote' => 'Anket zamanı dolmuştur oy kullanamazsınız.']);
            }
        }
        else {
            return redirect()->back()->withErrors(['vote' => 'Kullanıcılar sadece bir ankete 1 kez oy verebilir.']);
        }
        
    }
}
