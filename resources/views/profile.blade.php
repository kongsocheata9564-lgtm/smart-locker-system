@extends('layouts.guest')
@section('title', 'Smart Locker System')
@section('page_title', 'Welcome')
@section('content')
@include('partials.guest-header')
@include('partials.guest-footer')
@yield('content')

@endsection