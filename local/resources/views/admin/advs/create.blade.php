@extends('layouts.admin')
@section('title')
    New Advertisement
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
                {!! Form::open(['route' => 'admin.advs.store','method' => 'POST','files'=>'true']) !!}

                    <div class="form-group">
                        {!! Form::label('section','Section') !!}
                        {!! Form::select('type',[''=>'Select section','post_single'=> 'Post Single','ebook_single'=> 'Ebook Single','photo_single'=> 'Photo Single','video_single' => 'Video Single','video' => 'Video Page','photo' => 'Photo Page','video' => 'Video Page','ebook' => 'Ebook Page','home' => 'Home Page','archive' => 'Archive Page'],null,['class'=> 'form-control','required']) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('position','Position') !!}
                        {!! Form::select('position', array(0 => 'Horizontal Top (720px x 98px)',1 => 'Right Square First (300px x 250px)',2 => 'Right Square Second (300px x 250px) ',3 => 'Right Square Third (300px x 250px) ',4=> 'Right Vertical Four (300px x 600px)',5=> 'Horizontal Bottom'),null,['class'=> 'form-control select-category','required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('image','Image') !!}

                        {!! Form::file('image') !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Add Ebook',['class'=>'btn btn-primary']) !!}
                    </div>

                {!! Form::close() !!}
            </div>
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
