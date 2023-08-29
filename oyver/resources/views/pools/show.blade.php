@php
use App\Models\Option;
use App\Models\User;
@endphp

<x-partialcomponents.layout title="{{$pool->title}} Anketi - OyVer">

  <div class="container py-4 py-xl-5">
    <x-partialcomponents.search action="/" placeholder="Anket Aratın" :categories="$categories"/>
    <h2 class="text-uppercase fw-bold mb-3">ANKET</h2>
    <div class="row gy-4 ">
      <div class="col">
        <div class="card h-100">
          <div class="card-body p-4">
            <a href="/pool/{{$pool->id}}" style="text-align:center ;text-decoration: none;color:inherit" class="me-2">
              <h4 class="card-title d-inline">{{$pool->title}}</h4>
              <a style="display: inline" href="/?category={{$pool->category_id}}">
                <button class="btn btn-primary rounded" type="submit" style="background: rgb(34, 34, 34);padding: 15px;padding-top: 4px;padding-bottom: 4px;padding-right: 4px;padding-left: 4px;">{{$poolCategory}}</button>
              </a>
              <p id="pool-{{$pool->id}}" class="card-text line- poll" style="color: rgba(181,175,175,0.9);"  data-poll-id="{{$pool->id}}" data-poll-end-time="{{ $pool->poolEndTime }}"></p>
            </a>
            <div class="row">
              @if(!empty($voteCount))
              <div id="piechartdiv" data-poll-votes="{{ json_encode($voteCount) }}" class="col-lg-6 order-lg-2 d-md-flex justify-content-center align-items-center" style="max-width: 100%;">
                <div id="piechart" ></div>
              </div>
              @endif
              <div class="{{ empty($voteCount) ? 'col-12' : 'col-lg-6 order-lg-1' }} mb-5">
                <p class="card-text line-">{{ $pool->description }}</p>
              </div>

              
              
            </div>

           
            @if(!User::hasUserVoted(auth()->id(),$pool->id) and strtotime($pool->poolEndTime) == ""  ? true : strtotime($pool->poolEndTime ) > time()  )
            <div class="form-group">
              <div class="mb-3">Oy Seçenekleri</div>
              <form method="POST" action="/vote/save">
                @csrf
              @foreach(Option::getOptions($pool->id) as $option)
              <div class="form-check mw-100  form-check-inline">
                <input class="form-check-input" type="radio" name="option" id="{{$option->name}}" value="{{$option->id}}">
                <label class="form-check-label w-100" for="{{$option->name}}">
                  {{$option->name}}
                </label>
              </div>
              @endforeach 
              @error('vote')
              <p class="text-danger text-sm mt-1">
                {{$message}}
               </p>
              @enderror
              <div>
                <button class="btn btn-success btn-lg rounded mt-3 " onclick="submitForm(event)" type="submit" style="background: rgb(34, 34, 34);margin-right:-2px">Oy Ver</button>
              </div>
            </form>
            </div>
            @endif 
          </div>
        </div>
      </div>
    </div>
  </div>
  <x-comments.comments :pool="$pool" :comments="$comments"/>
</x-partialcomponents.layout>

<script type="text/javascript" src={{asset("assets/js/polls/pollTimer/pollTimer.js")}}></script>
<script type="text/javascript" src={{asset("assets/js/global/buttonDisabler.js")}}></script>
  

@if(!empty($voteCount))
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src={{asset("assets/js/polls/pieChart/pieChart.js")}}></script>


@endif

@auth
@if($comments->count() > 0)

<script type="text/javascript" src={{asset("assets/js/polls/comments/commentEdit.js")}}></script>
<script type="text/javascript" src={{asset("assets/js/polls/comments/commentLike.js")}}></script>
@endif
@endauth







