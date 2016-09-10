@extends('layouts.admin')
@section('title')
    Edit Video
@endsection

@section('content')
        <div class="row">            
            <div class="col-lg-6 col-md-6">
  
                @if(count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                    <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>                               
                    @endforeach
                    </ul>
                </div>
                @endif
                    {!! Form::open(['route' => ['admin.videos.update',$video->id],'method' => 'PUT','files'=>'true']) !!}

                        <div class="form-group">
                            {!! Form::label('title','Title') !!}
                            {!! Form::text('title', $video->title,['class'=> 'form-control','placeholder'=>'Type a title','required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('video_link','Video Id') !!}
                            {!! Form::text('video_link', $video->video_link,['class'=> 'form-control','placeholder'=>'Type a Video ID','required']) !!}.
                            <h2>Copy and Paste from YouTube Video ID: </h2>
                            <img src="{{asset('img/youtube.jpg')}}" alt="">                        
                        </div>

                        <div class="form-group">
                            {!! Form::label('category_id','Category') !!}
                            {!! Form::select('category_id', $categories,$video->category->id,['class'=> 'form-control select-category','required']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('content','Content') !!}
                            {!! Form::textarea('content', $video->content,['class' => 'textarea-content','required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('featured','Mark as Featured') !!}
                            @if($video->featured == 'true')
                            {{ Form::checkbox('featured', 'true',true) }}
                            @else
                            {{ Form::checkbox('featured', 'true',false) }}
                            @endif      
                        </div>

                        <div class="form-group">
                            {!! Form::label('tags','Tags') !!}
                            {!! Form::select('tags[]', $tags,$myTags,['class'=> 'form-control select-tag','multiple','required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Edit Video',['class'=>'btn btn-primary']) !!}
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        <!-- /.row -->
        </div>
        <!-- /.row -->


@endsection

@section('js')
    <script>
        $(".select-tag").chosen({
            placeholder_text_multiple: "Select your tags"
        });
        $(".select-category").chosen({
            placeholder_text_single: "Select a category"
        });
    </script>
@endsection
