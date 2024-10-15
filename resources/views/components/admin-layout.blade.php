@extends('main-layout')
@props(['css' => '', 'script' => ''])
@section('styles')
<link rel="stylesheet" href="{{asset('css/admin-style.css')}}">
@endsection
@section('content')
    <x-aside :titles="['Dashboard', 'Usuarios', 'Pontos', 'Turnos']" :links="['dashboard', 'usuarios', 'pontos','turnos']" :icons="['fa-solid fa-chart-line', 'fa-solid fa-user-group', 'fa-solid fa-clock', 'fa-solid fa-calendar-alt']"/>
    <x-navbar/>
    <main>
        {{$slot}}
    </main>
@endsection
@section('scripts')
    <script type="module" src="{{asset($script)}}"></script>
@endsection