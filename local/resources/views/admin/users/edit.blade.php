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
                        @if(Auth::user()->profile_image && Auth::user()->facebook_id == 'null')
                        
                          <img src="{{asset('img/users/profile').'/profile_'.Auth::user()->profile_image}}" class="img-circle col-xs-12" alt="The Post Page ">
                        @elseif(Auth::user()->facebook_id != 'null')          
                          <img src="{{Auth::user()->profile_image}}" class="img-circle" alt="The Post Page ">
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
                        {!! Form::label('profile_image','Profile Image') !!}
                        {!! Form::file('profile_image',null,['class'=> 'form-control','required']) !!}

                    </div>                
            		<div class="form-group col-xs-12">
            			{!! Form::label('name','Name') !!}
            			{!! Form::text('name', $user->name,['class'=> 'form-control','placeholder'=>'Type a name','required']) !!}
            		</div>
            		<div class="form-group col-xs-12">
            			{!! Form::label('email','E-mail') !!}
            			{!! Form::email('email', $user->email,['class'=> 'form-control','placeholder'=>'youremail@gmail.com','required']) !!}
            		</div>
                        
                    <div class="form-group col-xs-12">
                        {!! Form::label('bkash','Bkash') !!}
                        {!! Form::text('bkash', $user->bkash,['class'=> 'form-control','placeholder'=>'Type your bkash ID','required']) !!}
                    </div>

                    @if(Auth::user()->type == 'admin')
            		<div class="form-group col-xs-12">
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