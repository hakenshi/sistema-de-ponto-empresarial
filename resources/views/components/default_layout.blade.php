@extends('main-layout')
@props(['css' => '', 'script' => ''])
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
@endsection
@section('content')
    <x-aside :titles="['Home', 'Meus Pontos']" :icons="['fa-solid fa-house', 'fa-solid fa-clock']"
             :links="['home', 'meus-pontos']"/>
    <x-navbar/>
    <main>
        {{$slot}}
    </main>
@endsection
@section('scripts')
    <script src="{{ asset($script) }}"></script>
@endsection
