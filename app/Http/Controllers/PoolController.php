<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pool;
use App\Models\Vote;
use App\Models\Group;
use App\Models\Option;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Groupuser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PoolController extends Controller
{
    public function index(Request $request) {
        $user_groups = Groupuser::getUserGroups(auth()->id());

        
    
        $pools = Pool::whereIn('group_id', $user_groups)
        ->orWhere(function($query) {
            $query->whereNull('group_id');
        })
        ->orderBy('group_id', 'desc')
        ->latest()
        ->filter([
            "category_id" => $request->input('category'),
            "search" => $request->input('search')
        ])
        ->paginate(9)
        ->appends($request->all());
        foreach ($pools as $pool) {
            $pool->category_name = Category::find($pool->category_id)->category_name;
            if($pool->group_id){
                $pool->group_name = Group::find($pool->group_id)->title;
                unset($pool->group_id);
            }
        }

        $categories = Category::all();
        return view('pools.index', compact('pools', 'categories'));
    }

    public function show(Pool $pool){
    
     return view("pools.show",["voteCount"=> Vote::getOptionVotes($pool->id),"pool"=>$pool,"comments" => Comment::getCommentsWithUserByPoolId($pool->id) ,"categories" => Category::all() ,"poolCategory" => Category::find($pool->category_id)->category_name ]);
    }

    public function create(){
        
        
        return view('pools.create-pool',["categories" => Category::all() , "groups" => count(Groupuser::getUsersWithAuthorityLevelTwo(auth()->id())) != 0 ? Groupuser::getUsersWithAuthorityLevelTwo(auth()->id()) : null   ]);
    }
    
    public function savePool(Request $request){
        $formFields = $request->validate([
            'title' => [
                'required',
                'max:100',
                Rule::unique('pools')->where(function ($query) {
                    return $query->where('user_id', auth()->id());
                }),
            ],
            'description' => ['required', 'max:500'],
            'category' => ['required', 'integer', 'exists:categories,id'],
            'option' => [
                'required',
                'array',
                'min:2',
                'max:10',
                function ($attribute, $value, $fail) {
                    foreach ($value as $key => $val) {
                        if (!is_string($val)) {
                            $fail("Seçenekler string tipinde olmalıdır.");
                        }
                        if (!is_int($key)) {
                            $fail("Key integer olmalıdır.");
                        }
                    }
                }
            ],
            'option.*' => ['required', 'distinct:ignore_case'],
            'hasEndDate' => 'required|in:0,1',
            'poolEndTime' => ($request->hasEndDate == 1) ? 'required|date_format:Y-m-d\TH:i' : '',
            'groupPoll' => (count(Groupuser::getUsersWithAuthorityLevelTwo(auth()->id()))) != 0 ? 'required|in:0,1' : '',
            'groupId' => ($request->groupPoll == 1 ) ? ['required','integer',function ($attribute, $value, $fail) use($request) {
                if(!Groupuser::isLeader(auth()->id() ,$request->groupId)){
                    $fail("Bu grubun lideri değilsiniz.");
                }
            }] : ''
        ], [
            'title.required' => 'Başlık alanı zorunludur.',
            'title.unique' => 'Aynı başlığa sahip birden fazla anket oluşturamazsınız.',
            'title.max' => 'Başlık en fazla :max karakter uzunluğunda olabilir.',
            'category.required' => 'Kategori alanı zorunludur.',
            'category.integer' => 'Kategori bir tam sayı olmalıdır.',
            'category.exists' => 'Geçersiz kategori.',
            'description.required' => 'Açıklama alanı zorunludur.',
            'description.max' => 'Açıklama en fazla :max karakter uzunluğunda olabilir.',
            'option.required' => 'Seçenekler boş bırakılamaz.',
            'option.min' => 'En az :min seçenek girilmelidir.',
            'option.max' => 'En fazla :max seçenek girebilirsiniz.',
            'option.*.distinct' => "Seçenekler aynı olamaz",
            'option.*.required' => ":position. Seçeneği doldurmanız gerekiyor.",
            'hasEndDate.required' => 'Anket bitiş tarihi belirtilmedi.',
            'hasEndDate.in' => 'Geçersiz bir anket bitiş tarihi belirtildi.',
            'poolEndTime.required' => 'Anket bitiş tarihi belirtilmedi.',
            'poolEndTime.date_format' => 'Geçersiz bir anket bitiş tarihi belirtildi.(Doğru format: Y-m-d\TH:i)',
            'groupPoll.required' => "Anket Tip'i belirtilmedi.",
            'groupPoll.in' => "Geçersiz Anket Tip'i seçildi.",
            'groupId.required' => "Grup seçmeniz gerekmektedir.",
            'groupId.integer' => "GrupID'si tam sayı olmalıdır, " ,
        ]);
        



        
   
        if($request->hasEndDate == 1){
            $now = Carbon::now();
            $poolEndTime = Carbon::createFromFormat('Y-m-d\TH:i', $request->poolEndTime);
            $diffInMinutes = $now->diffInMinutes($poolEndTime, false); // false, zaman farkının negatif olabileceğini gösterir


    
    
    
         if ($diffInMinutes < 5) {
         return redirect()->back()->withErrors(['poolEndTime' => 'Anket süresi minimum 5 dakika sonrasına ayarlanmalıdır.']);
         }
         if ($diffInMinutes > (1000 * 365 * 24 * 60)) {
            return redirect()->back()->withErrors(['poolEndTime' => 'Anket süresi maksimum 1000 yıl sonrasına ayarlanabilir(Sınırsız seçeneğini tercih edebilirsiniz).']);
        }
        
        }
    
        if (($request->input('hasEndDate') == 0 && isset($request->poolEndTime)) || ($request->input('groupPool') && isset($request->groupId)) ) {
        return redirect()->back()->withErrors(['poolEndTime' => 'Siteyi kurcalama.']);
        }
        $pool = Pool::create(['title' => $formFields['title'], 'description' => $formFields['description'],'category_id' => $formFields['category'] ,'poolEndTime' => isset($formFields['poolEndTime']) ? $formFields['poolEndTime'] : null, "user_id" => auth()->id(),'group_id' => $request->groupId ? $formFields["groupId"] : null  ]);
    
        foreach($formFields['option'] as $option){
           $option =  new Option(['name' => $option]);
           $option->pool_id =  $pool->id;
           $option->save();
    
        }
    
        return redirect('/')->with('message','Anket başarıyla oluşturuldu.'); 
        
        
    }
}
