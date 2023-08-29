<?php

namespace App\Models;

use App\Models\Option;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vote extends Model
{
    use HasFactory;

    public static function getOptionVotes($poolId)
    {
        $options = Option::where('pool_id', $poolId)->get();
    
        $votes = array();
        $totalVotes = 0;
        foreach ($options as $option) {
            $voteCount = Vote::where('pool_id', $poolId)
                            ->where('option_id', $option->id)
                            ->count();
            $totalVotes += $voteCount;
            $votes[] = array($option->name, $voteCount);
        }
    
        if ($totalVotes === 0) {
            $votes = array();
        }
    
        return $votes;
    }

   

    
    
}
