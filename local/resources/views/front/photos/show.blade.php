@extends('layouts.front')
@section('css')
<link rel="stylesheet" href="{{asset('dist/css/style.css')}}">
@endsection
@section('title')
{{$photo->title}} | The Public Post
@endsection
@section('content')
    <!-- Page Content -->
    <div class="container">

        <div class="row myid" data-photo="{{$photo->id}}">
        <?php $id=$photo->id; ?>
            <!-- Blog Post Content Column -->
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 col-lg-offset-0 col-mds-offset-0 col-xs-offset-0 photo">
                <!-- Blog Post -->
                
                <!-- Banner_ad -->
                    <img class="img-responsive center-block banner-ad2" width="728" height="90" src="{{asset('img/banner_ad.png')}}" alt="banner_ad" style="margin-top:20px">

                    <div class="col-lg-12" style="margin-bottom:30px;padding:0">
                        <a href="#" style="display:inline-block;text-decoration:none;color:black;margin-right:10px">
                            <h3>{{$photo->title}}</h3>
                        </a>
                            @include('flash::message')
                @if(isset($message))
                <div class="col-xs-12 alert">
                {{$message}}
                </div>
                @endif
                        
                    </div>
                    <div class="col-lg-9 col-md-12 view2" style="padding:0">
                        <img src="{{asset('img/photos/slider_'.$photo->images()->first()->name)}}" alt="">
                        <div class="mask2">
                            <p><a href="#">{!! $photo->title !!}</a></p>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12" style="padding:0; margin-bottom:20px">
                        <a href="#" style="text-decoration:none;color:black">
                            <h3>{{$photo->title}}</h3>
                        </a>
                        <a href="#" class="pull-left" style="margin-right:5px">

                        @if(Auth::user()->first()->profile_image && Auth::user()->first()->facebook_id == null && Auth::user()->first()->twitter_id == null)
                        <img style="max-width:30px" alt="" class="img-circle" src="{{asset('img/users/profile/profile_'.Auth::user()->first()->profile_image)}}" alt="The Public Post">
                        @elseif(Auth::user()->first()->facebook_id != null || Auth::user()->first()->twitter_id != null)
                        <img style="max-width:30px" alt="" class="img-circle" src="{{Auth::user()->first()->profile_image}}" alt="The Public Post">
                        @endif
                        </a>{{$photo->user()->first()->name}} <span class="glyphicon glyphicon-time" style="margin-left:10px;margin-right:10px"> {{$photo->created_at}}</span><span class="icon icon-eye"> {{$photo->views()->count()}} মতামত</span><br><br>
                        <a class="btn btn-primary" href="/{{$photo->photo_link}}">ডাউনলোড <span class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>
                    <div class="ad-bottom col-lg-12">
                        <img class="center-block img-responsive" src="https://placeholdit.imgix.net/~text?txtsize=19&txt=150%C3%97300&w=150&h=300" alt="" style="margin-top:50px;margin-bottom:50px">
                    </div>
                    <div class="col-lg-12" style="height:60px;padding:0">
                        <hr style="padding:0;border:1px solid #d8d8d8;">
                    </div>
                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 portafolio-content">
                    <!-- Projects Row -->
                <div class="user col-lg-2 col-md-2 col-sm-2 col-xs-12">
                @if($photo->user()->first()->profile_image && $photo->user()->first()->facebook_id == null && $photo->user()->first()->twitter_id == null)
                    <img class="img-responsive center-block img-circle" src="{{asset('img/users/profile/profile_'.$photo->user()->first()->profile_image)}}" alt="">
                @elseif($photo->user()->facebook_id != null || $photo->user()->twitter_id != null )
                 <img src="{{$photo->user()->first()->profile_image}}" style="max-width:40px" alt="" class="img-circle" alt="The Post Page"> 
                @else
                <img src="{{asset('img/profile.png')}}" style="max-width:40px" alt="" class="img-circle" alt="The Post Page ">
                @endif
                    <p class="text-center user-name">{{$photo->user()->first()->name}}</p>
                    <div class="redes col-lg-10 col-md-8 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-2 col-sm-offset-0 col-xs-offset-0" style="padding:0">
                            <p><a href="http://facebook.com/{{$photo->user()->first()->facebook_real}}"><span class="icon icon-facebook"></span></a>
                            <a href="http://twitter.com/{{$photo->user()->first()->twitter_real}}"><span class="icon icon-twitter"></span></a>
                    </div>
                </div>
                <div class="contenido col-lg-12 col-md-10 col-sm-10 col-xs-12">
                 {!!$photo->content!!}      
                
                <div class="clearfix"></div>
                @foreach($photo->tags()->get() as $tag)

                <span class="icon icon-price-tag pull-left">{!!$tag->name!!}</span> 
                @endforeach
                <hr>
                
                <div id="share" class="col-xs-12"></div>
                <div class="ad-photo">
                    <img src="https://placehold.it/600x100" alt="">
                </div>
                <div class="col-xs-12" style="border:1px solid #eee;margin:20px 0px;"></div>
                <div class="col-md-12 col-sm-12 col-xs-12 nopadding m-b40">
                    <div class="col-md-6 col-sm-6 col-xs-6 nopadding">
                    <strong>YOU MAY LIKE</strong>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 nopadding">
                    <p class="pull-right">Sponsored Link By</p>
                    </div>
                    @foreach($related_photos as $photo)
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <a href="{{url('photos/'.$photo->id)}}" class="td-n">
                        <img class="img-responsive" src="{{asset('img/photos/slider_'.$photo->images()->first()->name)}}" alt="">

                        <h4><strong>{{$photo->title}}</strong></h4>
                        <h6 class="c-999999"><strong>{{ strip_tags(str_limit($photo->content, 200))}}</strong></h6></a>
                    </div>
                    @endforeach
                </div>
                <div class="col-xs-12" style="border:1px solid #eee;margin:20px 0px;"></div>

                <h2>মন্তব্য</h2>
                <!-- Blog Comments -->
                <ul class="comments">
                @foreach($comments as $key => $comment)
                    <li>
                    @if($comment->user_id == null)
                    <img src="{{asset('img/profile.png')}}" style="max-width:40px" alt="" class="img-circle" alt="The Post Page ">  
                        <span>{{$comment->name}}</span>
                        <p class="comment">মন্তব্য প্রদান করেছে {{$comment->created_at}}</p>
                        <p>{{$comment->comment}}</p>        
                    @else
                        @if($comment->user()->first()->profile_image && $comment->user()->first()->facebook_id == null && $comment->user()->first()->twitter_id == null)
                            <img style="max-width:40px" alt="" class="img-circle" src="{{asset('img/users/profile/profile_'.$comment->user()->first()->profile_image)}}" alt="The Public Post">
                        @elseif($comment->user()->first()->facebook_id != null || $comment->user()->first()->twitter_id != null)
                            <img style="max-width:40px" alt="" class="img-circle" src="{{$comment->user()->first()->profile_image}}" alt="The Public Post">
                        @else
                            <img src="{{asset('img/profile.png')}}" style="max-width:40px" alt="" class="img-circle" alt="The Post Page ">
                            <span>{{$comment->user()->first()->name}}</span>
                        @endif 
                        <span>{{$comment->user()->first()->name}}</span>
                            <p class="comment">মন্তব্য প্রদান করেছে {{$comment->created_at}}</p>
                            <p>{{$comment->comment}}</p>
                    @endif
                    </li>
                    <div class="col-xs-12" style="border:1px solid #eee;margin:20px 0px;"></div>
                @endforeach
                </ul>
                <!-- Comments Form -->
                @if(Auth::check())
                <div class="well comentarios nopadding">
                    <h4>মতামত দিন:</h4>
                    <div class="col-lg-21 col-md-2 col-sm-2 col-xs-2 nopadding">
                    <a class="pull-left" href="#">
                    @if(Auth::user()->profile_image && Auth::user()->first()->facebook_id == null && Auth::user()->first()->twitter_id == null)
                        <img style="max-width:80px" alt="fafa" class="img-circle" src="{{asset('img/users/profile/profile_'.Auth::user()->profile_image)}}" alt="The Public Post">
                    @elseif(Auth::user()->facebook_id != null || Auth::user()->first()->twitter_id != null)
                        <img style="max-width:100px" alt="" class="img-circle" src="{{Auth::user()->profile_image}}" alt="The Public Post">
                    @else
                        <img src="{{asset('img/profile.png')}}" style="max-width:40px" alt="" class="img-circle" alt="The Post Page ">
                    @endif  
                    </a>
                    </a>
                    </div>
                    <form role="form" action="{{url('comment/photos/'.$id.'/'.Auth::user()->id)}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group col-lg-10 col-md-10 col-sm-9 col-xs-9 nopadding">
                            <textarea class="form-control ta-styl" name="comment" rows="3"></textarea>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding m-0">
                            <button type="submit" class="btn btn-primary">পাঠান</button>
                        </div>
                    </form>
                @endif
                <div class="col-md-12 col-sm-12 col-xs-12 nopadding m-t20 m-0">
                </div>
                <div class="col-xs-12" style="border:1px solid #eee;margin:20px 0px;"></div>
                       
                        <form role="form" action="{{url('/comment/photos/'.$id)}}" method="POST">

                        <div class="mensaje m-t10">
                            <h2>যোগাযোগ</h2>
                            <textarea class="ta-styl2 form-control" name="comment"></textarea>
                        </div>
                            {{ csrf_field() }}
                            <div class="form col-md-5 nopadding m-t20">
                                <p>Name*<br>
                                <input type="text" name="name" class="form-control w100porcent" required>
                                </p>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="form col-md-5 nopadding m-t20">
                                <p>Web<br>
                                <input type="text" name="web" class="form-control w100porcent">
                                </p>
                            </div>
                            <div class="form col-md-5 nopadding m-t20">
                                <p>Email*<br>
                                <input type="email" name="email" class="form-control w100porcent" required>
                                </p>
                            </div>
                            <div class="form col-md-12 m-t20 nopadding">
                                <p>CAPTCHA Code* - Resolve this easy math account<br>
                                <?php 
                                $result=0;
                                $num1=rand(0,10);
                                $num2=rand(0,10);
                                $sum=$num1+$num2;
                                $result=$sum;
                                ?>
                                <label for="nums" class="nums" data-result="<?php echo $result; ?>"><?php echo $num1; ?> + <?php echo $num2; ?></label>
                                <input type="text" class="result form-control w15porcent" placeholder="এখানে ফল রাখুন" name="result" required>
                                </p>
                                <div id="resolve" class="btn btn-primary">সমাধান</div>
                                <p class="alert-danger captcha-error">ত্রুটি আবার চেষ্টা করুন.</p>
                                <p class="alert-success captcha-correct">নির্ভুল!</p>
                            </div>
                            <div class="form col-md-12 m-t20 nopadding">
                            <button type="submit" id="submit" class="btn btn-primary m-b20">পাঠান</button>
                            </div>
                            </form>
                     
                </div>

            </div>
                </div>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 sidebar">
            <div class="sidebar_ad col-center">
            <img class="img-responsive center-block" src="{{asset('img/Sidebar_ad.png')}}" style="padding-bottom:20px" alt="">
            </div>
                <!-- Side Widget Well -->
                <div class="col-lg-12 col-md-8 col-sm-8 col-xs-10 col-lg-offset-0 col-md-offset-2 col-sm-offset-2 col-xs-offset-1 first">
                    <h4 align="center"><a href="#" style="margin-right:10px; font-weight: bold; font-size: 1.3em; text-decoration:none">Link#1</a><a href="#" style="margin-right:10px;font-weight: bold; font-size: 1.3em; text-decoration:none">Link#2</a><a href="#" style="font-weight: bold; font-size: 1.3em; text-decoration:none">Link#3</a></h4>
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
                <div class="well categories2 col-lg-12 col-md-8 col-sm-8 col-xs-10 col-lg-offset-0 col-md-offset-2 col-sm-offset-2 col-xs-offset-1">
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

                <!-- Side Widget Well 
                <div class="well">
                    <h4>Recent Comments</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>
                -->
            </div>

        </div>
        <!-- /.row -->

        <!-- Footer -->

    </div>
    <!-- /.container -->
@endsection
@section('front-js')
<script>
//add views each time
var dataId = $('.myid').data('photo');
console.log(dataId);    
$.ajax({
    
    url: '{{ url('/admin/photos/addView') }}' + '/' + dataId,
    type: 'POST',
    data:{_token:token,id:dataId},
    success: function(msg) {
        console.log(msg['msg']);
    }
});
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