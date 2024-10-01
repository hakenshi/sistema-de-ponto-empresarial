@extends('main-layout')
@props(['css' => '', 'script' => ''])
@section('styles')
<link rel="stylesheet" href="{{asset('css/login-style.css')}}">
@endsection
@section('content')
    {{$slot}}
@endsection