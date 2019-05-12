@extends('layouts.app')
@section('title', 'Home')
@section('g_description')ເວບໄຊເກັບກຳ ແລະຈັດການຂໍ້ມູນ ປະກັນຄຸນນະພາບການສຶກສາລາວ@stop
@section('g_keywords')Lao Education Quality, Assurance, Collection and Management Website, ເວບໄຊເກັບກຳ ແລະຈັດການຂໍ້ມູນ ປະກັນຄຸນນະພາບການສຶກສາລາວ
@stop
@section('meta_search')
    <link rel="canonical" href="{{ urldecode(url()->full()) }}">
    <meta property="og:url" content="{{ urldecode(url()->full()) }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title"
          content="Home | {{ $s['site_name'] }}"/>
    <meta property="og:description"
          content="{{ $s['site_name'] }} ເວບໄຊເກັບກຳ ແລະຈັດການຂໍ້ມູນ ປະກັນຄຸນນະພາບການສຶກສາລາວ"/>
    <meta property="og:image" content="{{ url('/') }}/assets/images/{{ $s['website_logo']  }}"/>

    <meta property="og:site_name" content="{{ $s['site_name'] }}">
    <meta property="og:image:height" content="630">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:type" content="image/png">

    <meta name="twitter:title"
          content="Home | {{ $s['site_name'] }}">
    <meta name="twitter:description"
          content="{{ $s['site_name'] }} ເວບໄຊເກັບກຳ ແລະຈັດການຂໍ້ມູນ ປະກັນຄຸນນະພາບການສຶກສາລາວ">
    <meta name="twitter:image:src" content="{{ url('/') }}/assets/images/{{ $s['website_logo']  }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ $s['site_name'] }}">
    <meta name="twitter:creator" content="{{ $s['site_name'] }}">
    <meta name="twitter:image" content="{{ url('/') }}/assets/images/{{ $s['website_logo']  }}">
    <meta name="twitter:domain" content="{{ url('/') }}">

    <meta itemprop="name" content="Home | {{ $s['site_name'] }}">
    <meta itemprop="description"
          content="{{ $s['site_name'] }} ເວບໄຊເກັບກຳ ແລະຈັດການຂໍ້ມູນ ປະກັນຄຸນນະພາບການສຶກສາລາວ">
    <meta itemprop="image" content="{{ url('/') }}/assets/images/{{ $s['website_logo']  }}">
@stop
@section('scripts_header')
    <link rel="stylesheet" href="{{url('/')}}/css/general.css{{$s['fresh_version']}}">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/css/bootstrap.min.css">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/css/animate.css">
    {{--<!--Template CSS-->--}}
    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/css/slick.css">
    <!--====== Animate css ======-->
    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/css/animate.css">
    <!--====== Nice Select css ======-->
    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/css/nice-select.css">
    <!--====== Nice Number css ======-->
    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/css/jquery.nice-number.min.css">
    <!--====== Magnific Popup css ======-->
    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/css/magnific-popup.css">
    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/css/bootstrap.min.css">
    <!--====== Default css ======-->
    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/css/default.css">
    <!--====== Style css ======-->
    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/css/style.css">
    <!--====== Responsive css ======-->
    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/css/responsive.css">
    {{--<!--Template CSS-->--}}
    {{-- @GeneratedResourcesTop--}}
    {{-- @GeneratedResourcesTop--}}
@endsection
@section('scripts_footer')
    @include('main.general.defaultData')
    {{--<!--Template JS-->--}}
    <!--====== jquery js ======-->
    <script type="text/javascript" src="{{url('/')}}/bundles/general/assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <script type="text/javascript" src="{{url('/')}}/bundles/general/assets/js/vendor/jquery-1.12.4.min.js"></script>
    <!--====== Bootstrap js ======-->
    <script type="text/javascript" src="{{url('/')}}/bundles/general/assets/js/bootstrap.min.js"></script>
    <!--====== Slick js ======-->
    <script type="text/javascript" src="{{url('/')}}/bundles/general/assets/js/slick.min.js"></script>
    <!--====== Magnific Popup js ======-->
    <script type="text/javascript" src="{{url('/')}}/bundles/general/assets/js/jquery.magnific-popup.min.js"></script>
    <!--====== Counter Up js ======-->
    <script type="text/javascript" src="{{url('/')}}/bundles/general/assets/js/waypoints.min.js"></script>
    <script type="text/javascript" src="{{url('/')}}/bundles/general/assets/js/jquery.counterup.min.js"></script>
    <!--====== Nice Select js ======-->
    <script type="text/javascript" src="{{url('/')}}/bundles/general/assets/js/jquery.nice-select.min.js"></script>
    <!--====== Nice Number js ======-->
    <script type="text/javascript" src="{{url('/')}}/bundles/general/assets/js/jquery.nice-number.min.js"></script>
    <!--====== Count Down js ======-->
    <script type="text/javascript" src="{{url('/')}}/bundles/general/assets/js/jquery.countdown.min.js"></script>
    <!--====== Validator js ======-->
    <script type="text/javascript" src="{{url('/')}}/bundles/general/assets/js/validator.min.js"></script>
    <!--====== Ajax Contact js ======-->
    <script type="text/javascript" src="{{url('/')}}/bundles/general/assets/js/ajax-contact.js"></script>
    <!--====== Main js ======-->
    <script type="text/javascript" src="{{url('/')}}/bundles/general/assets/js/main.js"></script>
    <!--====== Map js ======-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC3Ip9iVC0nIxC6V14CKLQ1HZNF_65qEQ"></script>
    <script type="text/javascript" src="{{url('/')}}/bundles/general/assets/js/map-script.js"></script>
    <script src="{{url('/')}}/bundles/general/assets/js/bootstrap.min.js"></script>
    <script src="{{url('/')}}/bundles/general/assets/js/bootstrap.min.js"></script>
    {{--<!--Template JS-->--}}
    <script>
        var baseRes = "/bundles/general/";
        window.$ = jQuery;
    </script>
    {{-- @GeneratedResourcesBottom--}}
    <script type="text/javascript" src="{{url('/bundles/generated')}}/general/general.600e39253d6bad9ed0f2.bundle.js"></script>
    {{-- @GeneratedResourcesBottom--}}
@endsection