@extends('layouts.guest')
@section('title', 'Smart Locker System')
@section('page_title', 'Welcome')
@section('content')
@include('partials.guest-footer')
@include('partials.guest-header')

@yield('content')

@endsection