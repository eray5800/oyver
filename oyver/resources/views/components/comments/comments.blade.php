@props(['pool','comments'])

@php

use App\Models\Like;
@endphp

<div class="container mb-5">
  <h2 class="text-uppercase fw-bold mb-3">YORUMLAR</h2>

  @auth
      <x-comments.post-comment :pool="$pool" />
  @endauth



  <div class="card">
      @if($comments->count() > 0)
      <div class="card-body ">
          @foreach($comments as $comment)
                  <div class="d-flex align-items-center justify-content-center justify-content-md-start flex-wrap  mb-4">
                    <div >
                      <div class="d-flex flex-column flex-md-row  justify-content-center justify-content-md-start align-items-center">
                        <img src="{{ $comment->profilepicture ? asset('storage/'.$comment->profilepicture) : asset('/images/default-profile-picture.png')}}" alt="Profil Resmi" class="rounded-circle me-2 " style="flex: none;width:6.25rem;height:6.25rem;">
                        <div class="d-md-flex" >
                          <h5 class="m-0 me-md-2" style="word-break: break-all;">{{$comment->name}}</h5>
                        <p class="card-text line- mb-0 text-center" style="color: rgba(181, 175, 175, 0.9);">{{$comment->created_date}}</p>
                        </div>
                      </div>
                    </div>                   
                      <div class="d-flex flex-column w-100">  


  
                        <div class="normal-container ">
                          <div class="comment-text mb-3" style="word-break: break-all;">{{$comment->comment}}</div>
                          @error("comment_$comment->id")
                                        <p class="text-danger text-sm mt-1">
                                            {{ $message }}
                                        </p>
                                    @enderror




                        
                          <div class="d-flex  justify-content-between">
                            @csrf
                            @guest
                                <a href="{{ route('login') }}" class="h-100 d-flex justify-content-center align-items-center btn btn-success btn-lg rounded" style="background: rgb(34, 34, 34); margin-right:-2px">
                                    <i style="font-size: 1.5rem;transition: all 1s ease;" class="fas fa-heart me-2"></i>
                                    <span style="font-size: 1rem;">{{number_format(Like::getTotalLikesForComment($pool->id, $comment->id))}} Beğeni</span>
                                </a>
                            @else
                              

                              <button data-user-id={{auth()->id()}} @endphp  data-pool-id="{{ $pool->id }}" data-comment-id="{{ $comment->id }}" class="likebutton h-100 d-flex justify-content-center align-items-center btn btn-success btn-lg rounded @php
                                $like = Like::hasLike(auth()->id(), $pool->id, $comment->id);
                                if($like !== null and $like== true) {
                                    echo "liked";
                                }
                              @endphp"  type="submit" style="background: rgb(34, 34, 34);margin-right:-2px">
                                <i style="font-size: 1.5rem;transition: all 1s ease; @php if($like == true){ echo("color:#dc3545;");} @endphp"  class="fas fa-heart me-2"></i>
                                <span style="font-size: 1rem;" id="likeCount">{{number_format(Like::getTotalLikesForComment($pool->id, $comment->id))}} Beğeni</span>
                              </button>
                            @endguest
                            @if($comment->user_id == auth()->id())
                            <div class="dropdown ms-1">
                              <button class="btn btn-lg dropdown-toggle text-white rounded" style="background: rgb(34, 34, 34);" type="button" id="comment-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v me-1"></i>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="comment-dropdown">
                                <li>
                                  <form action="/comment/delete/{{$comment->id}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="page" value="{{$comments->currentPage() }}">
                                    <button type="submit" onclick="submitForm(event)" class="dropdown-item">
                                      <i class="fas fa-trash-alt me-1"></i> Sil
                                    </button>
                                  </form>
                                </li>
                                <li>
                                  <button class="dropdown-item edit-btn">
                                    <i class="fas fa-edit me-1"></i> Düzenle
                                  </button>
                                </li>
                              </ul>
                            </div>
                            
@endif
                          </div>
                        </div>
                        
   
  @if($comment->user_id == auth()->id())
  <div class="form-container d-none">
    <form action="/comment/update/{{$comment->id}}" style="display: contents" method="POST">
      @csrf
      @method('PUT')
      <textarea class="form-control comment-input w-100 h-100 mb-2" name="comment_@php echo($comment->id) @endphp">{{$comment->comment}}</textarea>

                          
      <div class="comment-actions d-flex">
        <input type="hidden" name="page" value="{{$comments->currentPage() }}">
        <button type="submit" onclick="submitForm(event)" class="h-100 btn rounded btn-success me-1 save-btn " >
          <i class="fas fa-save me-1"></i> Kaydet
        </button>
        <button type="button" class="h-100 btn btn-danger rounded cancel-btn ">
          <i class="fas fa-times me-1"></i> İptal
        </button>
      </div>

    </form>
    
  </div>



    
  

@endif
</div>
                  
              </div>
              
          @endforeach
          <div >
            {{ $comments->links('pagination::bootstrap-5', ['locale' => 'tr']) }}
          </div>
      @else
          <p class="m-1">Hiçbir yorum bulunamadı.</p>
      @endif
  </div>
</div>


