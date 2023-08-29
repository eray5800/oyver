@props(['applications','groupId'])



  <div class="container py-4 py-xl-5">
    <div class="row gy-4">
        <a href="/group/{{$groupId}}">
            <button class="btn text-white btn-lg rounded me-2" type="submit" style="background: rgb(34, 34, 34);">
                <i class="fa-solid fa-arrow-left me-1"></i>Geri Dön
            </button>
        </a>
        <h2>BAŞVURULAR</h2>

        <x-partialcomponents.search action="/group/application/{{$groupId}}" placeholder="Başvuru Aratın"  />
        @if(count($applications) != 0 )

        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    @foreach($applications as $application)
                        <div class="mb-4">
                            
                                <div class="d-flex flex-column flex-md-row  align-items-center" >
                                    <img src="{{ $application->profilepicture ? asset('storage/'.$application->profilepicture) : asset('/images/default-profile-picture.png')}}" alt="Profil Resmi" class="rounded-circle me-2" style="width:6.25rem;height:6.25rem;">

                                        <div class="d-flex flex-wrap flex-column flex-md-row justify-content-center justify-content-md-start" style="word-break: break-all">
                                            <h5 class="m-0 me-md-3">{{$application->name}}</h5> 
                                        <p class="card-text line- mb-0" style="color: rgba(181, 175, 175, 0.9);">{{$application->created_date}}</p>
                                        </div>
    
                                        

                                    
                                </div>
                                
                                

                            <p class="card-text">{{ $application->description }}</p>
                            
                            <div class="d-flex justify-content-center justify-content-md-start align-items-center  flex-shrink-0">
                                <form action="/group/application/accept/{{$application->group_id}}/{{$application->user_id}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="page" value="{{$applications->currentPage() }}">
                                    <button class="btn btn-success btn-lg rounded me-2" onclick="submitForm(event)" type="submit" style="background: rgb(34, 34, 34);">
                                        <i class="fas fa-check me-1"></i>Kabul et
                                    </button>
                                </form>
                                <form action="/group/application/decline/{{$application->id}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="page" value="{{$applications->currentPage() }}">
                                    <button class="btn color-white text-white bg-danger btn-lg rounded" onclick="submitForm(event)" type="submit">
                                        <i class="fas fa-trash-alt me-1"></i> Reddet
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="mt-3" >
                {{ $applications->links() }}
            </div>
        </div>
    @else
        <p>Başvuru bulunmamakta.</p>
    @endif
    

            
        </div>
        
    </div>
  </div>

    
