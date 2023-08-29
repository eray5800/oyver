@props(['group'])
@php
use App\Models\Groupuser;
use App\Models\Groupapplication;
@endphp


<div class="col-12">
    

    <div class="card h-100">
        <div class="card-body p-4">
            <div class="buttonwtitle align-items-center justify-content-between mb-3">
                <a href="/group/{{$group->id}}" style="text-decoration:none; color:inherit;">
                    <h4 class="card-title d-inline" style="word-break:break-all" >{{$group->title}}</h4>
                </a>

                    @if(!Groupapplication::checkApplication(auth()->id(),$group->id) and !Groupuser::checkUserBelongsToGroup(auth()->id(),$group->id))
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
                                        <button type="submit"   class="btn btn-primary" onclick="submitForm(event)" id="confirm-btn">Başvuru Gönder</button>
                                       
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    @endif
                
            </div>
           
            <p>{{$group->description}}</p>
        </div>
    </div>
</div>


