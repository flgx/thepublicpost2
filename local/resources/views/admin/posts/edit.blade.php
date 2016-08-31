@extends('layouts.admin')
@section('title')
    Edit Post
@endsection

@section('content')
        <div class="row">
            <div class="col-lg-6 col-md-6">
                {!! Form::open(['route' => ['admin.posts.update',$post->id],'method' => 'PUT','files'=>'true']) !!}

                    <div class="form-group">
                        {!! Form::label('title','Title') !!}
                        {!! Form::text('title', $post->title,['class'=> 'form-control','placeholder'=>'Type a title','required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('category_id','Category') !!}
                        {!! Form::select('category_id', $categories,$post->category->id,['class'=> 'form-control select-category','required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('content','Content') !!}
                        {!! Form::textarea('content', $post->content,['class' => 'textarea-content','required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('featured_text','Featured Text') !!}
                        {!! Form::textarea('featured_text', $post->featured_text,['class' => 'textarea-content form-control','required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('featured','Mark as Featured') !!}
                        @if($post->featured == 'true')
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
                        {!! Form::label('images','Images') !!}
                        {!! Form::file('images[]', array('multiple'=>true)) !!}
                    </div>
                    <div class="form-group myid" data-post="{{$post->id}}">
                        {!! Form::submit('Edit Post',['class'=>'btn btn-primary']) !!}
                    </div>

                {!! Form::close() !!}
            </div>
            
            <!-- Post Images -->
            <div class="col-md-6 type" data-type="posts">
                <h1>Images</h1>
                <hr>
                @if(count($post->images) > 0)  
                    <?php
                        $i=0;
                    ?>
                    @foreach($post->images as $image)
                    <div class="col-xs-12">
                        <img src="{{asset('img/posts/thumbs').'/thumb_'.$image->name, '$post->title'}}" alt="The Public Post {{$post->title}}">
                        <p class="col-xs-12" style="padding-left:0px; margin-top:10px;">
                            <a href="#" class="btn-delete btn btn-danger" onclick="return confirm('Are you sure?');"  data-imgid="{{$image->id}}"><i class="fa fa-trash fa-2x"></i></a>
                        </p>
                    </div>
                    <hr>
                    @endforeach
                @else
                    <p>Not images found. Please add a new image.</p>  
                @endif       
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

        $('.textarea-content').trumbowyg({
            
        }); 

        var dataId = $('.myid').data('post');

        $.ajax({
            url: '{{ url('/admin/posts/addView') }}' + '/' + dataId,
            type: 'POST',
            data:{_token:token,id:dataId},
            success: function(msg) {
                console.log(msg['msg']);
            }
        });
</script>
@endsection