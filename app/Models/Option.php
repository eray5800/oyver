<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
        protected $fillable = ['name'];
    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }
    public static function getOptions($poolId) {
        $options = Option::where('pool_id', $poolId)->get();
        return $options;
    }
    
}
