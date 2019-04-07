@extends('layouts.app')
@php
    $url = route('get.home.posts.single', [$type, $post->id]);
    $image_url = url('/') . \App\Posts::$uploadPath . $post->image;
    $title = $post->title .' - ' . $post_type_name . ' | ' . $s['site_name'];
    $description = $post->title . ' - ' . strip_tags(htmlspecialchars_decode($post->description))  . ' - ' . $post_type_name . ' on ' . $s['site_name'] . ', Latest ' . $post_type_name . ' on ' . $s['site_name'] . ' | ' .  $s['site_name'];
@endphp

@section('g_description'){!! $description  !!}
@stop
@section('g_keywords'){{$post->title}}, {{ $post_type_name }},  {{ $post_type_name }} on {{ $s['site_name'] }}, Latest {{ $post_type_name }}
@stop
@section('meta_search')
    <link rel="canonical" href="{{ urldecode( $url) }}">
    <meta property="og:url" content="{{ urldecode( $url) }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{ $title }}"/>
    <meta property="og:description" content="{!! $description  !!}"/>
    <meta property="og:image" content="{{$image_url}}"/>
    <meta property="og:site_name" content="{{ $s['site_name'] }}">
    <meta property="og:image:height" content="630">
    <meta property="og:image:width" content="1200">

    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{!! $description  !!}">
    <meta name="twitter:image:src" content="{{$image_url}}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ $s['site_name'] }}">
    <meta name="twitter:creator" content="{{$post->user->name}} - {{ $s['site_name'] }}">
    <meta name="twitter:image" content="{{$image_url}}">
    <meta name="twitter:domain" content="{{ $url }}">

    <meta itemprop="name" content="{{ $title }}">
    <meta itemprop="description" content="{!! $description  !!}">
    <meta itemprop="image" content="{{$image_url}}">

@stop

@section('title'){{ $title }}
@stop
@section('scripts_header')
    <link rel="stylesheet" href="{{url('/')}}/css/general.css{{$s["fresh_version"]}}">
    <link rel="stylesheet" href="{{url('/')}}/css/style.css{{$s["fresh_version"]}}">
@endsection
@section('scripts_footer')
    @include('main.general.defaultData')
    <script src="{{ asset('/js') }}/general.bundle.js{{$s["fresh_version"]}}" type="text/javascript"
            charset="utf-8"></script>
@endsection

