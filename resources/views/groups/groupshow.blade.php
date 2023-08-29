@php
use App\Models\Groupuser;
use App\Models\Groupapplication;
@endphp



<x-partialcomponents.layout title="{{$group->title}} Grubu- OyVer">



  <div class="container py-4 py-xl-5">
    <x-partialcomponents.search action="/groups" placeholder="Grup Aratın"/>
    <div class="row gy-4 ">
        <h2>GRUP</h2>
        <div class="col-12">
            <div class="card h-100">
                <div class="card-body p-4">
                    <div class="buttonwtitle align-items-center justify-content-between">
                        <a href="/group/{{$group->id}}" style="text-decoration:none; color:inherit;">
                            <h4 class="card-title d-inline" style="word-break:break-all" >{{$group->title}}</h4>
                        </a>                       
                        @if(!Groupapplication::checkApplication(auth()->id(),$group->id) and !$groupCheck)
                        <button class="btn ms-2 btn-success btn-lg rounded apply-btn" type="button" style="background: rgb(34, 34, 34);margin-right:-2px" data-bs-toggle="modal"  data-bs-target="#confirm-modal" data-groupid="{{$group->id}}">Başvuru Gönder</button>
                        
                        <div class="modal fade" id="confirm-modal" tabindex="-1" aria-labelledby="confirm-modal-label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                        
                                        <h5 class="modal-title" id="confirm-modal-label">Başvuru açıklaması giriniz.</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="/group/application/create/{{$group->id}}" >
                                        @csrf
                                    <div class="modal-body">
                        
                                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Başvuru Açıklaması"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                                            <button type="submit" class="btn btn-primary" onclick="submitForm(event)" id="confirm-btn">Başvuru Gönder</button>
                                       
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                        @endif


                        <div class="{{$groupCheck || $leaderCheck ? "d-flex" : "d-none"  }}">
                          @if($groupCheck)
                        <form action="/group/leave/{{$group->id}}" method="POST" class="mb-2">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-success btn-lg rounded" onclick="submitForm(event)" type="submit" style="background: rgb(34, 34, 34);margin-right:-2px">Ayrıl</button>
                        </form>
                        @endif
                      
                        @if($leaderCheck)
                        <a href="/group/application/{{$group->id}}" class="ms-2">
                          <button class="btn btn-success btn-lg  rounded" type="button" style="background: rgb(34, 34, 34); position: relative;">
                            Başvurular
                            @if($count > 0)
                            <span class="badge bg-danger   rounded-pill position-absolute top-0 end-0" style="margin-top: -0.7rem; margin-right: -0.7rem;">
                              {{$count}}
                              </span>
                            @endif
                          </button>
                        </a>
                        
                        
                        @endif
                        </div>
                        
                    </div>
                   
                    <p  >{{$group->description}}</p>
                </div>
            </div>
        </div>
        <h2>GRUP ÜYELERİ</h2>
        

        
        
        @if(isset($groupusers))
        <x-partialcomponents.search action="/group/{{$group->id}}" placeholder="Üye Aratın"  />
    @if($groupusers->total() != 0)
        

        <div class="col-12 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table " style="word-break: break-all">
                            <thead>
                                <tr>
                                    <th class="d-none d-md-table-cell">Profil Resmi</th>
                                    <th>Kullanıcı Adı</th>
                                    <th class="@php if(!$leaderCheck){echo("text-end");}else {echo("d-none d-md-block");} @endphp">Yetki Seviyesi</th>
                                    @if($leaderCheck)
                                        <th class="text-end">İşlemler</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody >
                                @foreach($groupusers as $groupuser)
                                    <tr class="align-middle">
                                        <td class="d-none d-md-table-cell "><img src="{{ $groupuser->profilepicture ? asset('storage/'.$groupuser->profilepicture) : asset('/images/default-profile-picture.png')}}" alt="Profil Resmi" class="rounded-circle me-2" style="width:6.25rem;height:6.25rem;"></td>
                                        <td class="d-table-cell" title="{{ $groupuser->name }}" style="text-overflow: ellipsis; overflow: hidden;">{{ $groupuser->name }}</td>
                                        <td class="@php if(!$leaderCheck){echo("text-end");}else {echo("d-none d-md-table-cell");} @endphp">
                                            @if($groupuser->authoritylevel == 2)
                                                Grup Lideri
                                            @else
                                                Grup Üyesi
                                            @endif
                                        </td>
                                        @if($leaderCheck && $groupuser->user_id != auth()->id())
                                            <td class="text-end d-table-cell">
                                                <form action="/group/kick/{{$groupuser->id}}" style="display:contents" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="page" value="{{$groupusers->currentPage() }}">
                                                    <button type="submit" onclick="submitForm(event)" class="group-btn btn mb-1 mb-xl-0  btn-lg btn-danger rounded  ">
                                                        <i class="fas fa-trash-alt"></i> At
                                                    </button>
                                                </form>
                                                <button class="btn btn-success btn-lg rounded text-white edit-btn group-btn"  style="background: rgb(34, 34, 34);word-break: break-word;" data-bs-toggle="modal"  data-bs-target="#confirm-modal"  data-userid="{{$groupuser->id}}"> <i class="fas fa-edit "></i>Liderliği Ver</button>

                                                <div class="modal fade" id="confirm-modal" tabindex="-1" aria-labelledby="confirm-modal-label" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="confirm-modal-label">Liderliği Devretmek İstediğinize Emin Misiniz?</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                                                                <form action="/group/changeleader/{{$groupuser->id}}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="submit" onclick="submitForm(event)" class="btn btn-primary" id="confirm-btn">Evet, Liderliği Devret</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            @else 
                                            <td></td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else 
        <p>Yaptığınız aramaya uygun hiçbir kullanıcı bulunmamaktadır.</p>
    @endif
@else
    <p>Bu grubun üye listesi grup dışı kullanıcılara karşı gizlidir.</p>
    @endif
            </div>
            @if(isset($groupusers) )
        <div class="mt-3 card-body">{{ $groupusers->links() }}</div>
        @endif
        </div>
        
    </div>

            
        </div>
        
    </div>
  </div>
</x-partialcomponents.layout>

<script type="text/javascript" src={{asset("assets/js/group/modal/groupLeaderChange.js")}}></script>
<script type="text/javascript" src={{asset("assets/js/group/modal/groupApplicationCreate.js")}}></script>
<script type="text/javascript" src={{asset("assets/js/global/buttonDisabler.js")}}></script>

    



