<x-partialcomponents.layout title="Grup Listesi - OyVer">
    <x-partialcomponents.list-container :listarray="$groups" action="/groups" placeholder="Grup Aratın" title="GRUPLAR">
       
       
       @unless(count($groups) == 0)
       @foreach($groups as $group)
       
       <x-groups.group :group="$group" />
      
       @endforeach
      
      
       @else 
       <p>Hiçbir grup bulunamadı.</p>
       @endunless
       
    </x-partialcomponents.list-container>



    

</x-partialcomponents.layout>

<script type="text/javascript" src={{asset("assets/js/group/modal/groupApplicationCreate.js")}}></script>
<script type="text/javascript" src={{asset("assets/js/global/buttonDisabler.js")}}></script>