<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Groupuser;
use Illuminate\Http\Request;
use App\Models\Groupapplication;

class GroupApplicationController extends Controller
{
    public function showApplications(Group $group,Request $request){
        
        
        return view("groups.groupapplications",["applications" => Groupapplication::countApplicationsByGroupId($group->id,$request->input("search"))->appends($request->all()) ,"groupId" => $group->id]);
    }

    public function saveApplication(Group $group , Request $request){
        try {
            $formFields = $request->validate([
                'description' => ['required', 'max:500'],
            ], [
                'description.required' => 'Açıklama alanı zorunludur.',
                'description.max' => 'Açıklama en fazla :max karakter olabilir.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->getMessageBag();

            return redirect()->back()->with('danger', "danger")->with('message',$errors->getMessages()["description"][0]);
        }
    
        $groupApplication = new Groupapplication();
        $groupApplication->user_id = auth()->id();
        $groupApplication->group_id = $group->id;
        $groupApplication->description = $formFields['description'];

        $groupApplication->save();

        

        return redirect("/group/$group->id")->with('message','Başvuru başarıyla iletildi.'); 
    }

    public function acceptApplication(Group $group, User $user,Request $request)
{

    $application = Groupapplication::checkApplication($user->id, $group->id);
    $application->delete();
    
    $groupuser = new Groupuser();
    $groupuser->user_id = $user->id;
    $groupuser->group_id = $group->id;
    $groupuser->authoritylevel = 1;
    $groupuser->save();
    
    $paginator = Groupapplication::countApplicationsByGroupId($group->id);

    if(isset(parse_url(url()->previous())["query"])){
        parse_str(parse_url(url()->previous())["query"], $queries);
    }



    if($paginator->lastPage() == 1) {
    $search = isset($queries["search"]) ? ["search" => $queries["search"]] : [];
    $requestUrl = Request::create(config('app.url')."/group/application/$group->id", 'GET', $search )->fullUrl();
     return redirect($requestUrl);
    } else {
        $url = url()->previous();             
        $currentQueries = [
            "page" => $request->page <= $paginator->lastPage() ? $request->page : $paginator->lastPage(),
        ];
        if(isset($queries["search"])){
            $currentQueries["search"] = $queries["search"];
        }
        $requestUrl = Request::create($url, 'GET', $currentQueries)->fullUrl();
    
     return redirect($requestUrl);
    }
   
}


    public function declineApplication(GroupApplication $application,Request $request){
        $application->delete();

        $paginator = Groupapplication::countApplicationsByGroupId($application->group_id);

        if(isset(parse_url(url()->previous())["query"])){
            parse_str(parse_url(url()->previous())["query"], $queries);
        }
        
    if($paginator->lastPage() == 1) {
        $search = isset($queries["search"]) ? ["search" => $queries["search"]] : [];
    $requestUrl = Request::create(config('app.url')."/group/application/$application->group_id", 'GET', $search )->fullUrl();
     return redirect($requestUrl);
    } else {
        $url = url()->previous();             
        $currentQueries = [
            "page" => $request->page <= $paginator->lastPage() ? $request->page : $paginator->lastPage(),
        ];
        if(isset($queries["search"])){
            $currentQueries["search"] = $queries["search"];
        }
        $requestUrl = Request::create($url, 'GET', $currentQueries)->fullUrl();
    
     return redirect($requestUrl);
    }
    }
}
