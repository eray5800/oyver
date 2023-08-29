<div class="mb-3">
  <div class="card">
    <div class="card-body">
      <form action="/post/comment/{{$pool->id}}" method="POST" class="d-flex justify-content-between  align-items-center mb-0">
        @csrf
        <img src="{{ auth()->user()->profilepicture ? asset('storage/'.auth()->user()->profilepicture) : asset('/images/default-profile-picture.png')}}" alt="Profil Resmi" class="rounded-circle me-2 d-none d-sm-block" style="flex: none;width:6.25rem;height:6.25rem;">
        <input class="mb-2 ms-sm-2 w-100 form-control-borderless" type="text" placeholder="Yorum Ekleyin.." name="postComment">
              
        <button class="btn btn-success btn-lg rounded " onclick="submitForm(event)" type="submit" style="background: rgb(34, 34, 34);margin-right:-2px">Yorum Yap</button>
      </form>
      
      @error('postComment')
      <p class="text-danger text-sm mt-1">
       {{$message}}
      </p>
      @enderror
     
     
    </div>
  </div>
</div>

