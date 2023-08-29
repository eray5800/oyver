<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pool extends Model
{
   
    use HasFactory;
    protected $fillable = ['title','poolEndTime','description','category_id',"user_id","group_id"];
    public function scopeFilter($query , array $filters){
    
        if($filters['category_id']   ?? false ){
        $query->where('category_id',$filters['category_id']);
        }

        if ($filters['search']   ?? false) {
            
            

            $query->where(function ($query) use ($filters) {
                $category_id = DB::table('categories')->where('category_name', $filters['search'])->value('id');

                $query->where('title', 'like', '%' . $filters['search'] . '%')
                      ->orWhere('description', 'like', '%' . $filters['search'] . '%')
                      ->orWhere('category_id',$category_id);
            });
        }
 
     }
}
