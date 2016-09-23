@extends('layouts.front')
@section('css')
<link rel="stylesheet" href="{{asset('dist/css/home-logged.css')}}">
@endsection
@section('title','Home')
@section('content')
    <!-- Page Content -->
    <!-- Banner_ad -->
    <img class="img-responsive center-block banner-ad2" width="728" height="90" src="{{asset('img/banner_ad.png')}}" alt="banner_ad" style="padding-top:10px;padding-bottom:10px" />
    <div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8 post">

            <div class="col-md-9" style="padding:0;margin-top: 15px;">
            <div id="carousel-1" class="carousel slide" data-ride="corousel">
                <!-- Indicadores -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-1" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-1" data-slide-to="1"></li>
                    <li data-target="#carousel-1" data-slide-to="2"></li>
                    <li data-target="#carousel-1" data-slide-to="3"></li>
                    <li data-target="#carousel-1" data-slide-to="4"></li>
                </ol>
                <!-- Contenedor de los slide -->
                <div class="carousel-inner slider" role="listbox">
                <!-- Slider Posts Interaction -->
                @if(count($slider_posts )>0)
                    @foreach($slider_posts as $key => $slider)                    
                        <div class="item {{$key == 0 ? 'active' : '' }}">
                            <img src="{{asset('img/posts/slider_'.$slider->images->first()->name)}}" class="img-responsive center-block" alt="The Public Post News {{$slider->title}}">
                            <div class="carousel-caption">
                                <h3 style="margin-left: 10px; font-size: 20px; padding: 0px; ">{{$slider->title}}</h3>
                            </div>
                        </div>          
                    @endforeach
                @endif
                </div>
                <!-- Controles -->
                <a href="#carousel-1" class="left carousel-control" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true" style="margin-left:-5px;"></span>
                </a>
                <a href="#carousel-1" class="right carousel-control" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true" style="margin-right:-5px;"></span> 
                </a>
            </div>
        </div>
        <div class="carousel-indicators selector col-lg-4 col-md-12 col-sm-12" style="margin-top:15px">
            <div class="tabs center-block" style="width: 136px">
                <h3>সাম্প্রতিক পোস্ট
</h3>
            </div>
            <div class="titulos col-sm-12" style="text-align:left;padding:0">
                <p style="margin-top:10px">
                <!-- Slider Sidebar Interaction -->
                @if(count($slider_posts )>0)
                    @foreach($slider_posts as $key => $slide_title)
                        <div class="col-lg-12 col-md-12 col-sm-4 col-xs-4 sidebar-title-carousel">
                        <a href="#" data-target="#carousel-1" data-slide-to="{{$key}}" class="active" data-target="#carousel-1" data-slide-to="0"  style="text-decoration:none;font-size:15px;font-weight:bold;color:black;text-align:left">{{$slide_title->title}}</a>
                        </div>            
                    @endforeach
                @endif
                </p> 
            </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0; margin-top:50px">
                @if(count($featured_posts  )>0) 
                @foreach($featured_posts as $featured)
               
                <div class="col-md-4 col-sm-6 col-xs-12 featured-post" style="padding:0;border:1px solid #dcddde">
                    
                    <div class="post-destacados col-lg-6 col-md-4 col-sm-3 col-xs-3" style="padding-top: 20px;padding-bottom: 20px;padding-left: 20px;padding-right: 0;">
                        <a href="{{url('posts/'.$featured->id)}}">
                            <img class="img-responsive center-block" src="{{asset('img/posts/thumbs/thumb_'.$featured->images->first()->name)}}" alt="">
                        </a>
                    </div>
                    
                    <div class="post-destacados-titulo col-lg-6 col-md-8 col-sm-9 col-xs-9" >
                        <br>
                        <p style="text-align:justify"><a href="{{url('posts/'.$featured->id)}}" style="text-decoration:none; color:#55505c; font-weight:bold;text-align:left">{{$featured->title}}</a></p>
                        <p style="font-size:10px"><span class="glyphicon glyphicon-time"></span> {{$featured->created_at}}</p>

                    </div>
                </div>
                @endforeach
                @endif

            </div>
                <div class="tabs col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:20px;padding:0">
                    <h2>সর্বশেষ পোস্ট
</h2>
                </div>
                <hr>
                <!-- Project 1 -->
        @if(count($lastest_posts)>0)
            @foreach($lastest_posts as $post)
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">                   
                        <img class="img-responsive" style="width:300px;height:200px" src="{{asset('img/posts/slider_'.$post->images()->first()->name)}}" alt="The Public Posts {{$post->title}}">                  
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12" style="margin-top: 10px">
                    <h3 style="margin:0">{{$post->title}}</h3>
                    @if($post->user()->first()->profile_image && $post->user()->first()->facebook_id == null && $post->user()->first()->twitter_id == null)

                    <a href="{{url('posts/'.$post->id)}}" class="pull-left" style="margin-right:5px"><img src="{{asset('img/users/profile/profile_'.$post->user()->first()->profile_image)}}" class="img-responsive" width="20px" height="20px" alt=""></a>{{$post->user()->first()->name}} <span class="glyphicon glyphicon-time" style="margin-left:10px;margin-right:10px"> {{$post->created_at}}</span><span class="icon icon-eye">

                    @elseif($post->user()->first()->facebook_id != null && $post->user()->first()->twitter_id != null)
                        <a href="#" class="pull-left" style="margin-right:5px"><img src="{{$post->user()->first()->profile_image}}" class="img-responsive" width="20px" height="20px" alt=""></a>{{$post->user()->first()->name}} <span class="glyphicon glyphicon-time" style="margin-left:10px;margin-right:10px"> {{$post->created_at}}</span><span class="icon icon-eye">
                    @endif
                    {{$post->views()->count()}}  মতামত</span>                
                    <br><br>
                    <p class="post-content">{{ strip_tags(str_limit($post->content, 400))}}</p>
                    <a class="btn btn-primary" href="{{url('posts/'.$post->id)}}">আরো দেখুন <span class="glyphicon glyphicon-chevron-right"></span></a>
                </div>
            </div>
            <!-- /.row -->

            <hr>
            @endforeach
        @endif
        <!-- Pagination -->
     
                <hr>
            <div class="row" style="height:400px">
                <div class="col-md-10">
                <div class="tabs" style="margin-bottom:10px">
                    <h2>সাম্প্রতিক ফটো</h2>
                </div>
                </div>
        <!--SLIDER-->

    <div class="col-lg-12" style="">
        <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12" id="ninja-slider" style="float:left;">
            <div class="slider-inner">
                <ul>
                @if(count($lastest_photos)>0)
                    @foreach($lastest_photos as $photo)                
                    <li><a class="ns-img" href="{{asset('img/photos/slider_'.$photo->images()->first()->name)}}"><p class="caption" style="background-color: rgba(0, 0, 0, 0.6); color: white; position: absolute; bottom: 0px; padding: 10px; margin: 0px;text-align:justify;"><span>{{$photo->title}}</span></p></a></li>
                    @endforeach
                @endif
                </ul>
            </div>
        </div>
        <div class="thumbnail-slider-padre col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding:0;">
        <div class="thumbnail-slider" id="thumbnail-slider">
            <div class="inner" style="padding:0;">
                <ul>
                    @if(count($lastest_photos)>0)
                        @foreach($lastest_photos as $photo)                 
                            <li style="padding:0;margin:0;">
                                <a class="thumb" href="{{asset('img/photos/slider_'.$photo->images()->first()->name)}}">
                                <p class="title"><a href="{{url('photos/'.$photo->id)}}" style="text-decoration:none;color:black"><strong>{{$photo->title}}</strong></a></p>
                                </a>
                            <div class="oculto div-post col-md-8 col-sm-8 col-xs-12">
                                <h3>{{$photo->title}}</h3>
                                @if($photo->user()->first()->profile_image && $photo->user()->first()->facebook_id == null && $photo->user()->first()->twitter_id == null)                                
                                        <a href="#" class="pull-left" style="margin-right:5px"><img src="{{asset('img/users/profile/profile_'.$photo->user()->first()->profile_image)}}" class="img-responsive" width="20px" height="20px" alt=""></a>
                                @elseif($photo->user()->first()->facebook_id != null || $photo->user()->first()->twitter_id != null)
                                        <a href="#" class="pull-left" style="margin-right:5px"><img src="{{$photo->user()->first()->profile_image}}" class="img-responsive" width="20px" height="20px" alt=""></a>
                                @endif

                                {{$photo->user()->first()->name}} <span class="glyphicon glyphicon-time" style="margin-left:10px;margin-right:10px">{{$photo->created_at}}</span><span class="icon icon-eye"> {{$photo->views()->count()}} মতামত</span><br>
                                <a class="btn btn-primary" href="{{url('photos/'.$photo->id)}}" style="margin:10px 0px">আরো দেখুন <span class="glyphicon glyphicon-chevron-right"></span></a>
                            </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
        <div class="contenedor_post col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0"></div> 
    </div>        
                <div class="col-md-12 col-sm-12 col-xs-12 transformar nopadding" style="padding:0">
                    <img class="img-responsive center-block" style="height:150px;" src="{{asset('img/ad.png')}}" alt="">
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
            <img class="img-responsive center-block banner-ad" src="{{asset('img/banner_ad2.png')}}" alt="banner_ad" style="padding-bottom:10px;padding-top:10px;padding-bottom:10px" height="90" width="728">
            </div>

            <div class="col-md-10 col-sm-12 col-xs-12" style="padding:0;margin-bottom:20px">
                <div class="tabs" style="margin-bottom:10px">
                  <h2> সাম্প্রতিক ভিডিও</h2>
                </div>
                
                @if(count($lastest_videos) > 0)
                    <?php 
                        $video1="";
                        $video2="";
                        $video3="";
                        $image1="";
                        $image2="";
                        $image3="";
                        $url1="";
                        $url2="";
                        $url3="";
                    ?>
                    @foreach($lastest_videos as $key => $video)
                    @if($key == 0)
                        <?php 
                            $video1 = $video->title;
                            $url1=$video->id;
                            $user1=$video->user()->first()->name;
                            if($video->user()->first()->profile_image && $video->user()->first()->facebook_id == null && $video->user()->first()->twitter_id == null){
                               $image1='img/users/profile/profile_'.$video->user()->first()->profile_image;      
                            }elseif ($video->user()->first()->facebook_id != null && $video->user()->first()->twitter_id != null) {
                               $image1=$video->user()->first()->profile_image;
                            } 
                            
                        ?>
                    @elseif($key == 1)
                        <?php 
                            $video2 = $video->title;
                            $url2=$video->id;
                            $user2=$video->user()->first()->name;
                            if($video->user()->first()->profile_image && $video->user()->first()->facebook_id == null && $video->user()->first()->twitter_id == null){
                               $image2='img/users/profile/profile_'.$video->user()->first()->profile_image;      
                            }elseif ($video->user()->first()->facebook_id != null && $video->user()->first()->twitter_id != null) {
                               $image2=$video->user()->first()->profile_image;
                            } 
                        ?>
                    @elseif($key == 2)
                        <?php 
                            $video3 = $video->title;
                            $url3=$video->id;
                            $user3=$video->user()->first()->name;
                            if($video->user()->first()->profile_image && $video->user()->first()->facebook_id == null && $video->user()->first()->twitter_id == null){
                               $image3='img/users/profile/profile_'.$video->user()->first()->profile_image;      
                            }elseif ($video->user()->first()->facebook_id != null && $video->user()->first()->twitter_id != null) {
                               $image3=$video->user()->first()->profile_image;
                            } 
                        ?>
                    @endif
                    
                    <div class="col-md-3 col-sm-3 col-xs-3 view video video3" style="margin:0px 7px;padding:0px">
                    <a href="{{url('videos/'.$video->id)}}">
                        <img src="http://img.youtube.com/vi/{{$video->video_link}}/1.jpg" alt="" class="center-block">
                    </a>
                    </div>
                    
                    @endforeach
                    @if($image1)
                    <div class="col-md-3 col-sm-3 col-xs-3 descripcion desc1" style="margin-right:7px;padding:0px">
                       <a href="{{url('videos/'.($url1) ? : $url1)}}" class="pull-left" style="margin-right:5px">
                        <h4>{{($video1) ? : $video1}} #1</h4>
                        
                            <img src="{{$image1}}" class="img-responsive pull-left" style="margin-right:5px" width="20px" height="20px" alt="">
                            {{$user1}}
                        </a>
                    </div>
                    @endif
                    @if($image2)
                    <div class="col-md-3 col-sm-3 col-xs-3 descripcion desc2" style="margin:0px 7px;padding:0px">
                        <a href="{{url('videos/'.($url2) ? : $url2)}}" class="pull-left" style="margin-right:5px">
                        <h4>{{($video2) ? : $video2}} #2</h4>
                        <a href="#" class="pull-left" style="margin-right:5px">
                            <img src="{{$image2}}" class="img-responsive pull-left" style="margin-right:5px" width="20px" height="20px" alt="">{{$user2}}
                        </a>
                    </div>
                    @endif
                    @if($image3)
                    <div class="col-md-3 col-sm-3 col-xs-3 descripcion desc3" style="margin:0px 7px;padding:0px">
                        <a href="{{url('videos/'.($url3) ? : $url3)}}" class="pull-left" style="margin-right:5px">
                            <h4>{{($video3) ? : $video3}} #3</h4>
                        
                            <img src="{{$image3}}" class="img-responsive pull-left" style="margin-right:5px" width="20px" height="20px" alt="">{{$user3}}
                        </a>
                    </div>
                    @endif
                @endif   
                </div>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 sidebar">
            <div class="sidebar_ad col-center">
            <img class="img-responsive center-block" src="{{asset('img/Sidebar_ad.png')}}" style="padding-bottom:20px" alt="">
            </div>
                <!-- Side Widget Well -->
                <div class="col-lg-12 col-md-8 col-sm-8 col-xs-10 col-lg-offset-0 col-md-offset-2 col-sm-offset-2 col-xs-offset-1 first">
                    <h4 align="center"><a href="#" style="margin-right:10px; font-weight: bold; font-size: 1.3em; text-decoration:none">Link#1</a><a href="#" style="margin-right:10px;font-weight: bold; font-size: 1.3em; text-decoration:none">Link #2</a><a href="#" style="font-weight: bold; font-size: 1.3em; text-decoration:none">Link #3</a></h4>
                    <a href="#"><img class="img-responsive center-block" src="{{asset('img/girl.jpg')}}" alt="" style="margin-bottom:20px"></a>
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
                    <h4 style="text-align:center">Lorem Itsum</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <h5>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat.</h5><br>
                            <h6>Lorem ipsum dolor sit amet</h6>
                            <hr />
                            <h4 style="color:blue;">Lorem ipsum dolor sit amet</h4>
                            <div class="col-lg-12 col-md-10 col-sm-10 col-xs-12 col-lg-offset-0 col-md-offset-1 col-sm-offset-1 col-xs-offset-0" style="padding:0">
                                <div class="facebook col-lg-2 col-md-2 col-sm-2 col-xs-2" style="padding:0px;margin-right:10px">
                                <a href="#"><img src="{{asset('img/social_fb.png')}}" class="img-responsive center-block" alt="social" style="width:100%"></a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="padding:0px;margin-right:10px">
                                <a href="#"><img src="{{asset('img/social_tw.png')}}" class="img-responsive center-block" alt="social" style="width:100%"></a>
                                </div>                                
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="padding:0px;margin-right:10px">
                                <a href="#"><img src="{{asset('img/social_gl.png')}}" class="img-responsive center-block" alt="social" style="width:100%"></a>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="padding:0px;margin-right:10px">
                                <a href="#"><img src="{{asset('img/social_in.png')}}" class="img-responsive center-block" alt="social" style="width:100%"></a>
                                </div>                                
                                <div class="youtube col-lg-2 col-md-2 col-sm-2 col-xs-2" style="padding:0px;margin-right:10px">
                                <a href="#"><img src="{{asset('img/social_yt.png')}}" class="img-responsive center-block" alt="social" style="width:100%"></a>
                                </div>
                                </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <img src="{{asset('img/ebook.png')}}" style="padding-bottom:50px" class="img-responsive center-block">
                <img src="https://placeholdit.imgix.net/~text?txtsize=33&txt=300%C3%97600&w=300&h=600" style="padding-bottom:50px" class="img-responsive center-block">    
            </div>
        </div>
        </div>
        <!-- /.row -->
        

    </div>
    <!-- /.container -->
        
@endsection
@section('front-js')
<script type="text/javascript">
    
        setInterval(function() {
        var post = document.querySelector(".active .div-post").innerHTML;
        if(post != null){            
            document.querySelector(".contenedor_post").innerHTML = post;
        }
        }, 500);
  
</script>
@endsection