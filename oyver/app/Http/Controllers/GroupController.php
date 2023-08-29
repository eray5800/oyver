<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Groupuser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Groupapplication;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class GroupController extends Controller
{
    public function index(Request $request){

    return view('groups.groupindex',['groups' => Group::latest()->filter(["search" => $request->input('search')  ])->paginate(15)->appends($request->all())]);
    
    }

    public function show(Group $group, Request $request) {
        $data = [
            "group" => $group,
            "count" => Groupapplication::countApplicationsByGroupId($group->id)->total(),
            "groupCheck"=> Groupuser::checkUserBelongsToGroup(auth()->id(),$group->id),
            "leaderCheck" => Groupuser::isLeader(auth()->id(),$group->id)
        ];
    
        if ($group->userprivacy == 1 || ($group->userprivacy==0 && Groupuser::checkUserBelongsToGroup(auth()->id(),$group->id))) {
            $data["groupusers"] = Groupuser::getUsersByGroupId($group->id, $request->input('search'))->appends($request->all());
        }
    
        return view("groups.groupshow", $data);
    }

    public function create(){
        return view('groups.groupcreate');
    }

    public function leave(Group $group){
        $groupuser = Groupuser::checkUserBelongsToGroup(auth()->id(),$group->id);
        if(Groupuser::checkUserBelongsToGroup(auth()->id(),$group->id)){

            if(Groupuser::isLeader(auth()->id(),$group->id)){
                if(Groupuser::getUsersByGroupId($group->id)->total() == 1){
                    $group->delete();
                    return redirect("/groups")->with('message','Grup başarıyla silindi.');
                }
                else {
                    return redirect("/group/$group->id")->with('message','Gruptan ayrılabilmeniz(Grup beraberinde silinir) için gruptaki tek kullanıcı olmanız gerekmekte.')->with('danger','danger');
                }
            } 
            else {
                $groupuser->delete();
                return redirect('/groups')->with('message','Gruptan başarıyla çıkış yapıldı.');
            }
        }
    }

    public function kick(Groupuser $groupuser, Request $request){
        if(isset(parse_url(url()->previous())["query"])){
            parse_str(parse_url(url()->previous())["query"], $queries);
        }

        if(auth()->id() != $groupuser->user_id){
            $groupuser->delete();
            $paginator = Groupuser::getUsersByGroupId($groupuser->group_id,isset($queries["search"]) ? $queries["search"] : null);
    
            if($paginator->lastPage() == 1) {
                
                $search = isset($queries["search"]) ? ["search" => $queries["search"]] : [];
                $requestUrl = Request::create(config('app.url')."/group/$groupuser->group_id", 'GET', $search )->fullUrl();
                return redirect($requestUrl)->with('message','Kullanıcı başarıyla atıldı.');
            } else {
                $url = url()->previous();             
                $currentQueries = [
                    "page" => $request->page <= $paginator->lastPage() ? $request->page : $paginator->lastPage(),
                ];
                if(isset($queries["search"])){
                    $currentQueries["search"] = $queries["search"];
                }
                $requestUrl = Request::create($url, 'GET', $currentQueries)->fullUrl();
                return redirect($requestUrl)->with('message' , 'Kullanıcı başarıyla atıldı.');
            }
        } else {
            return redirect()->back();
        }
    }
    

    public function leaderChange(Groupuser $groupuser){
        $leader = Groupuser::checkUserBelongsToGroup(auth()->id(),$groupuser->group_id);
        if(auth()->id() != $groupuser->user_id and $leader->group_id == $groupuser->group_id){
            
            $groupuser->authoritylevel = 2;
            
           
           $leader->authoritylevel = 1;
            $leader->save();
            $groupuser->save();

           return back()->with('message','Lider başarıyla değiştirildi.');
        }else {
            return redirect()->back();
        }
    }

    public function save(Request $request){
        $formFields = $request->validate([
            'title' => [
                'required',
                'unique:groups,title',
                'max:100'

            ],
            'description' => ['required','max:500'],
            'userprivacy' => [
                'required',
                'integer',
                'in:0,1',
            ]
        ], [
            'title.required' => 'Grup Adı girmek zorunludur.',
            'title.unique' => 'Bu grup ismine sahip bir grup bulunmaktadır.',
            'title.max' =>   'Grup ismi en fazla :max karakter uzunluğunda olabilir.',
            'description.required' => 'Açıklama alanı zorunludur.',
            'description.max' => 'Açıklama en fazla :max karakter olabilir',
            'userprivacy.required' => 'Üye Gizliliğini belirlemek zorunludur.',
            'userprivacy.in' => 'Üye Gizliliği sadece 0 veya 1 değerini alabilir.',
            'userprivacy.integer' => 'Üye Gizliliği sadece tamsayı verisi kabul eder.'
        ]);
        
        
        
        
        
        

        $group= Group::create($formFields);
        $groupLeader = new Groupuser();
        $groupLeader->group_id = $group->id;
        $groupLeader->user_id = auth()->id();
        $groupLeader->authoritylevel = 2;
        $groupLeader->save();

        return redirect("/group/$group->id")->with('message','Grup başarıyla oluşturuldu.'); 

    }


}
