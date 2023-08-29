@props(['pool'])


<div class="col">
    <div class="card h-100">
        <div class="card-body p-4">

           <a  href="/pool/{{$pool->id}}" style="text-align:center ;text-decoration: none;color:inherit" class="me-2"> <h4 class="card-title d-inline">{{$pool->title}}</h4> <a style="display: inline" href="/?category={{$pool->category_id}}"><button class="btn btn-primary rounded" type="submit" style="background: rgb(34, 34, 34);padding-top: 4px;padding-bottom: 4px;padding-right: 4px;padding-left: 4px;">{{$pool->category_name}}</button></a>  </a> 
            <p class="card-text line-"  style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">{{$pool->description}}</p>
            <p id="pool-{{$pool->id}}" class="card-text line- poll" style="color: rgba(181,175,175,0.9);" data-poll-id="{{$pool->id}}" data-poll-end-time="{{ $pool->poolEndTime }}"></p>

        </div>
    </div>
</div>


  