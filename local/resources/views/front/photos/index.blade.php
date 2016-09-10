@extends('layouts.front')
@section('css')
<link rel="stylesheet" href="{{asset('dist/css/style.css')}}">
@endsection
@section('title')
All photos | The Public Post
@endsection
@section('content')
    <!-- Page Content -->
    <div class="container">
        <div class="row myid" data-photo="{{$photo->id}}">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 col-lg-offset-0 col-mds-offset-0 col-xs-offset-0 post">
                <!-- Blog Post -->

                <!-- Banner_ad -->
                <img class="img-responsive center-block banner-ad2 m-t20" width="728" height="90" src="{{asset('img/banner_ad.png')}}" alt="banner_ad">

                <div class="col-lg-12 nopadding m-b30">
                    <a href="#" class="astyl13">
                        <h3>সমস্ত ফটো</h3>
                    </a>

                </div>
                    <div class="col-lg-9 col-md-12 view2" style="padding:0">
                        <img src="{{asset('img/photos/slider_'.$photo->images()->first()->name)}}" alt="">
                        <div class="mask2">
                            <p><a href="#">{{strip_tags(str_limit($photo->content, 100))}}</a></p>
                        </div>
                    </div>
                    <div class="ad-up col-lg-3 col-md-3">
                        <img class="center-block img-responsive m-tb50" src="https://placeholdit.imgix.net/~text?txtsize=19&txt=150%C3%97300&w=150&h=200">
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 nopadding m-b20">
                        <a href="#" class="astyl4">
                            <h3>{{$photo->title}}</h3>
                        </a>
                        <a href="#" class="pull-left m-r5">
                        @if($photo->user()->first()->profile_image && $photo->user()->first()->facebook_id == null && $photo->user()->first()->twitter_id == null)
                        <img src="{{asset('img/users/profile/profile_'.$photo->user()->first()->profile_image)}}" class="img-responsive" width="20px" height="20px" alt=""></a>
                        @elseif($photo->user()->first()->facebook_id != null || $photo->user()->first()->twitter_id != null)
                        <img src="{{$photo->user()->first()->profile_image}}" class="img-responsive" width="20px" height="20px" alt=""></a>
                        @endif
                       	 {{$photo->user()->first()->name}} 
                        <span class="glyphicon glyphicon-time m-lr10">{{$photo->created_at}}</span><span class="icon icon-eye"> {{$photo->views()->count()}} মতামত</span><br><br>
                        <a class="btn btn-primary" href="{{url('photos/'.$photo->id)}}">আরো দেখুন <span class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>
                    <div class="ad-bottom col-lg-12">
                        <img class="center-block img-responsive" src="https://placeholdit.imgix.net/~text?txtsize=19&txt=150%C3%97300&w=150&h=300" alt="">
                    </div>
                    <div class="col-lg-12 nopadding h60">
                        <hr class="divstyl3 nopadding">
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-3 hidden-xs categorias nopadding">
                    <ul class="list-group">
                    @foreach($sidebars as $sidebar)
                        <li class="list-group-item"><a href="#" class="astyl4 fw-b">- {{$sidebar->category()->first()->name}}</a></li>
                    @endforeach
                    </ul>
                </div>
                <div class="col-xs-12 visible-xs categories nopadding m-b20">
                    <button class="btn btn-primary dropdown-toggle w100porcent bc-0061d8" type="button" id="dropdownenu1" data-toggle="dropdown" aria-extended="true">
                        Categories
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu divstyl4" role="menu" aria-labellebdy="dropdownmenu1">
                    @foreach($sidebars as $sidebar)
                        <li class="list-group-item"><a href="#" class="astyl4 fw-b">- {{$sidebar->category()->first()->name}}</a></li>
                    @endforeach
                    </ul>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 portafolio-content">
                    <!-- Projects Row -->
        <div class="row portafolios">
        @foreach($related_photos as $photo)
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 portafolio-item">

                <a href="{{url('photos/'.$photo->id)}}" class="td-n">
                    <img class="img-responsive" src="{{asset('img/photos/slider_'.$photo->images()->first()->name)}}" alt="{{$photo->title}}">
                    <p class="astyl16">{{$photo->title}}</p>
                </a>
            </div>
        @endforeach
        </div>
            <div class="row text-center">
            <div class="col-lg-12">
            {{$related_photos->render()}}
            </div>
        </div>
                </div>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 sidebar">
            <div class="sidebar_ad col-center">
            <img class="img-responsive center-block" src="{{asset('img/Sidebar_ad.png')}}" alt="">
            </div>
                <!-- Side Widget Well -->
                <div class="col-lg-12 col-md-8 col-sm-8 col-xs-10 col-lg-offset-0 col-md-offset-2 col-sm-offset-2 col-xs-offset-1 first">
                    <h4 align="center"><a href="#" class="astyl6 td-n">Link#1</a><a href="#" class="astyl2 fw-b td-n">Link #2</a><a href="#" class="td-n astyl3">Link #3</a></h4>
                    <a href="#"><img class="img-responsive center-block m-b20" src="{{asset('img/girl.jpg')}}" alt=""></a>
                </div>

                <!-- Blog Search Well -->
                <div class="well col-lg-12 col-md-8 col-sm-8 col-xs-10 col-lg-offset-0 col-md-offset-2 col-sm-offset-2 col-xs-offset-1 first">
                    <div class="input-group">
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->
                <div class="well categories col-lg-12 col-md-8 col-sm-8 col-xs-10 col-lg-offset-0 col-md-offset-2 col-sm-offset-2 col-xs-offset-1">
                    <h4 class="ta-c">Lorem Itsum</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <h5>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat.</h5><br>
                            <h6>Lorem ipsum dolor sit amet</h6>
                            <hr />
                            <h4 class="c-blue">Lorem ipsum dolor sit amet</h4>
                            <div class="col-lg-12 col-md-10 col-sm-10 col-xs-12 col-lg-offset-0 col-md-offset-1 col-sm-offset-1 col-xs-offset-0 nopadding w100porcent">
                                <div class="facebook col-lg-2 col-md-2 col-sm-2 col-xs-2 nopadding m-r10">
                                <a href="#"><img src="{{asset('img/social_fb.png')}}" class="img-responsive center-block w100porcent" alt="social"></a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 nopadding m-r10">
                                <a href="#"><img src="{{asset('img/social_tw.png')}}" class="img-responsive center-block w100porcent" alt="social"></a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 nopadding m-r10">
                                <a href="#"><img src="{{asset('img/social_gl.png')}}" class="img-responsive center-block w100porcent" alt="social"></a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 nopadding m-r10">
                                <a href="#"><img src="{{asset('img/social_in.png')}}" class="img-responsive center-block w100porcent" alt="social"></a>
                                </div>
                                <div class="youtube col-lg-2 col-md-2 col-sm-2 col-xs-2 nopadding m-r10">
                                <a href="#"><img src="{{asset('img/social_yt.png')}}" class="img-responsive center-block w100porcent" alt="social"></a>
                                </div>
                                </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <img src="{{asset('img/ebook.png')}}"  class="p-b50 img-responsive center-block">
                <img src="https://placeholdit.imgix.net/~text?txtsize=33&txt=300%C3%97600&w=300&h=600"  class="p-b50 img-responsive center-block">
            </div>
        </div>
        </div>
        <!-- /.row -->
    <!-- /.container -->
@endsection
@section('front-js')
<script>
$(".captcha-error").hide();
$(".captcha-correct").hide();
$('#submit').prop('disabled', true);
    $("#resolve").click(function(e){
    e.preventDefault();     
        var resultInput = $('.result').val();
        var resultOriginal = $('.nums').data('result');
        //check if the result is okey
        if(resultInput == resultOriginal){
            $('#submit').prop('disabled', false);
            $(".captcha-correct").show();
            $(".captcha-error").hide();
            $('#submit').unbind('click');
        }else{
            $('#submit').prop('disabled', true);
            $(".captcha-error").show();
            $(".captcha-correct").hide();
        }
    });

</script>
@endsection