<x-layout :css="asset('css/admin-style.css')">
    <x-aside :titles="['Home', 'Meus Pontos']" :icons="['fa-solid fa-house','fa-solid fa-clock']" :links="['home','meus-pontos']"/>
    <x-navbar />
    <main>
      {{$slot}}
    </main>
</x-layout>