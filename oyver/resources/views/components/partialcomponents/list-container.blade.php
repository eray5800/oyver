@props(['listarray', 'extrastyle' => '','action','placeholder','title','categories' => '']) 



<div class="container py-4 py-xl-5">
    <x-partialcomponents.search :action="$action"  :placeholder="$placeholder" :categories="$categories"  />
    @if($title=="GRUPLAR")
    <div class="mb-3 d-flex justify-content-between" >
    <h2 class="text-uppercase fw-bold  ">{{$title}}</h2>
    <a href="/group/create">
    <button class="btn btn-success btn-lg rounded" type="button" style="background: rgb(34, 34, 34);margin-right:-2px">Grup Oluştur</button>
    </a>
    
    </div>
    @else
    <h2 class="text-uppercase fw-bold mb-3 ">{{$title}}</h2>
    @endif
    <div class="row gy-4 {{ $extrastyle }}">
        {{ $slot }}
    </div>
    <div class="mt-3">{{ $listarray->links() }}</div>
</div>