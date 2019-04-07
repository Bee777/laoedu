@extends('layouts.app')
@section('title', 'Home')
@section('scripts_header')
    <link rel="stylesheet" href="{{url('/')}}/css/general.css{{$s["fresh_version"]}}">
    <link rel="stylesheet" href="{{url('/')}}/css/style.css{{$s["fresh_version"]}}">
@endsection
@section('scripts_footer')
    @include('main.general.defaultData')
    <script src="{{ asset('/js') }}/general.bundle.js{{$s["fresh_version"]}}" type="text/javascript"
            charset="utf-8"></script>
@endsection
