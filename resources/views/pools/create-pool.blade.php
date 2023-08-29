<x-partialcomponents.layout title="Anket Oluştur - OyVer" >

<x-pools.create-pool-form :categories="$categories" :groups="$groups" />


</x-partialcomponents.layout>

<script type="text/javascript" src={{asset("assets/js/polls/createPollForm/addOption.js")}}></script>

<script type="text/javascript" src={{asset("assets/js/polls/createPollForm/endTimeHandler.js")}}></script>
<script type="text/javascript" src={{asset("assets/js/global/buttonDisabler.js")}}></script>

@if($groups != null)
<script type="text/javascript" src={{asset("assets/js/polls/createPollForm/groupPollHandler.js")}}></script>

@endif
