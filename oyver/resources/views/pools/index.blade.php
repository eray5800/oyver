<x-partialcomponents.layout title="Ana Sayfa - OyVer">
    <x-partialcomponents.hero/>
    
    <x-partialcomponents.list-container :listarray="$pools" extrastyle="row-cols-1 row-cols-md-2 row-cols-xl-3" action="/" :categories="$categories" placeholder="Anket Aratın" title="ANKETLER" >
       
       
       @unless($pools->total() == 0)

   
       @foreach($pools as $pool)

       <x-pools.pool :pool="$pool" />
      
       @endforeach
      
      
       @else 
       <p>Hiçbir anket bulunamadı.</p>
       @endunless
       
    </x-partialcomponents.list-container>
    

</x-partialcomponents.layout>

@if($pools->total() != 0)
<script type="text/javascript" src={{asset("assets/js/polls/pollTimer/pollTimer.js")}}></script>
@endif
