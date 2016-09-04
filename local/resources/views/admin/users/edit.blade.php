@extends('layouts.admin')
@section('title','Edit User: '. $user->name)

@section('content')
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="actions col-xs-12">
                    <a class="btn btn-primary" href="{{url('admin/posts/'.$user->id.'/user')}}"><i class="fa fa-archive"></i> User Posts</a>
                    <a class="btn btn-primary" href="{{url('admin/photos/'.$user->id.'/user')}}"><i class="fa fa-photo"></i> User Photos</a>
                    <a class="btn btn-primary" href="{{url('admin/videos/'.$user->id.'/user')}}"><i class="fa fa-video-camera"></i> User Videos</a>
                    <a class="btn btn-primary" href="{{url('admin/ebooks/'.$user->id.'/user')}}"><i class="fa fa-book"></i> User Ebooks</a>
                </div>
                <hr>
            	{!! Form::open(['route' => ['admin.users.update',$user->id],'method' => 'PUT','files' => true]) !!}
                    @if($user->profile_image)
                    <div class="col-xs-6">

                        @if($user->facebook_id == null &&  $user->twitter_id == null)                        
                        <img src="{{asset('img/users/profile').'/profile_'.$user->profile_image}}" style="max-width:100%;" class="img-circle col-xs-4" alt="The Post Page ">
                        @elseif(Auth::user()->facebook_id != null ||  Auth::user()->twitter_id != null)          
                          <img src="{{$user->profile_image}}" style="max-width:100%;" class="img-circle" alt="The Public Post ">
                        @else
                         <img src="asset('img/profile.png')" class="img-circle" alt="The Post Page ">
                        @endif                        
                     </div>
                    @else
                    <div class="col-xs-6">
                        <img src="{{asset('img/profile.png')}}" class="img-circle " alt="The Post Page ">   
                        <div class="panel panel-success">
                          <div class="panel-heading">* Please change your profile image.</div>
                        </div>
                    </div>
                    @endif

                    <div class="form-group col-xs-6">
                    <i class="fa fa-photo"></i>
                        {!! Form::label('profile_image','Profile Image') !!}
                        {!! Form::file('profile_image',null,['class'=> 'form-control','required']) !!}

                    </div>          
                    <div class="form-group col-xs-12">
                    <i class="fa fa-pencil"></i>
                        {!! Form::label('name','Name') !!}
                        {!! Form::text('name', $user->name,['class'=> 'form-control','placeholder'=>'Type a name','required']) !!}
                    </div>
                                
                	<div class="form-group col-xs-12">
                        <i class="fa fa-tag"></i>
            			{!! Form::label('tagline','Tagline') !!}
            			{!! Form::text('tagline', $user->tagline,['class'=> 'form-control','placeholder'=>'Type a tagline','required']) !!}
                	</div>
                    <div class="form-group col-xs-12">
                    <i class="fa fa-facebook-square"></i>
                        {!! Form::label('facebook_real','Facebook ID') !!}
                        {!! Form::text('facebook_real', $user->facebook_real,['class'=> 'form-control','placeholder'=>'Type your Facebook ID']) !!}
                    </div>
                    <div class="form-group col-xs-12">
                        <i class="fa fa-twitter-square"></i>
                        {!! Form::label('twitter_real','Twitter ID') !!}
                        {!! Form::text('twitter_real', $user->twitter_real,['class'=> 'form-control','placeholder'=>'Type your Twitter ID']) !!}
                    </div>
                   
            		<div class="form-group col-xs-12">
                        <i class="fa fa-envelope"></i>

            			{!! Form::label('email','E-mail') !!}
            			{!! Form::email('email', $user->email,['class'=> 'form-control','placeholder'=>'youremail@gmail.com','required']) !!}
            		</div>
                        
                    <div class="form-group col-xs-12">
                        <i class="fa fa-money"></i>
                        {!! Form::label('bkash','Bkash') !!}
                        {!! Form::text('bkash', $user->bkash,['class'=> 'form-control','placeholder'=>'Type your bkash ID','required']) !!}
                    </div>

                    @if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor')
            		<div class="form-group col-xs-12">
                        <i class="fa fa-user-group"></i>
            			{!! Form::label('type','User Type') !!}
            			{!! Form::select('type',[''=>'Select type of user','member'=> 'Member','admin' => 'Administrator'],$user->type,['class'=> 'form-control','required']) !!}
            		</div>
                    @endif
            		<div class="form-group col-xs-12">
            			{!! Form::submit('Edit User',['class'=>'btn btn-primary']) !!}
            		</div>

            	{!! Form::close() !!}
            </div>
        </div>
        <!-- /.row -->


@endsection