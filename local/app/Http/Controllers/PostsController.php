<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\PostRequest;
use Laracasts\Flash\Flash;
use App\Post;
use App\Tag;
use App\Image;
use App\Category;
use App\User;
use Auth;
use Config;
class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserPosts($id){
        $posts =  Post::orderBy('id','DESC')->where('user_id',$id)->paginate(5);
        $posts->each(function($posts){
            $posts->category;
            $posts->images;
            $posts->tags;
            $posts->user;
        });
        $user = User::find($id);
        return view('admin.posts.user')
        ->with('posts',$posts)->with('user',$user);
    }
    public function addView(Request $request,$id){
        $post = Post::find($id);
        $post->views = $post->views + 1;
        $post->update();
        return response()->json(['msg'=>'success']);
     
        
    }
    public function index(Request $request)
    {
        $posts= Post::Search($request->title)->orderBy('id','DESC')->where('user_id',Auth::user()->id)->paginate(5);
        $posts->each(function($posts){
            $posts->category;
            $posts->images;
            $posts->tags;
            $posts->user;
        });
        return view('admin.posts.index')
        ->with('posts',$posts);
    }
    public function all(Request $request)
    {
        $posts= Post::Search($request->title)->orderBy('id','DESC')->paginate(5);
        $posts->each(function($posts){
            $posts->category;
            $posts->images;
            $posts->tags;
            $posts->user;
        });
        return view('admin.posts.all')
        ->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check()){
                $categories = Category::orderBy('name','ASC')->where('type','post')->lists('type','name','id');
                $tags =Tag::orderBy('name','ASC')->lists('name','id');
                $posts = Post::orderBy('id','DESC')->paginate(4);
                return view('admin.posts.create')
                ->with('posts',$posts)
                ->with('categories',$categories)
                ->with('tags',$tags);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {

        //Check if the images are null or not.
        $fileArray0 = array('images' => $request->file('images')[0]);
        // Tell the validator that this file should be required
        $rules0 = array(
            'images' => 'required'//max 10000kb
        );
        // Now pass the input and rules into the validator
        $validator0 = \Validator::make($fileArray0, $rules0);       
        if($validator0->fails()){
           return redirect()->back()->withErrors($validator0)->withInput();
        }else{
        //Process Form Images
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach($files as $file){             

                    //Slider
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $picture = date('His').'_'.$filename;
                    //make images sliders
                    $image=\Image::make($file->getRealPath()); //Call image library installed.
                    // Build the input for validation
                    $fileArray = array('images' => $file);
                    // Tell the validator that this file should be an image
                    $rules = array(
                        'images' => 'dimensions:min_width=*,min_height=450'//max 10000kb
                    );
                    // Now pass the input and rules into the validator
                    $validator = \Validator::make($fileArray, $rules);
                    
                    if($validator->fails()){
                        
                        return redirect()->back()->withErrors($validator)->withInput();
                    }else{
                    //if pass all the validations we add the post and the images                        
                        $post = new Post($request->except('images','category_id','tags'));
                        $post->user_id = \Auth::user()->id;
                       //associate category with post
                        $category = Category::find($request['category_id']);
                        $post->category()->associate($category);
                        $post->save();  
                        //associate all tags for the post
                        $post->tags()->sync($request->tags);
                       
                        $destinationPath = 'img/posts/';
                        $image->resize(null,280, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save($destinationPath.'slider_'.$picture);
                        // Thumbnails
                        $image2=\Image::make($file->getRealPath()); //Call immage library installed.      
                        //make images thumbnails                        
                        $thumbPath ='img/posts/thumbs/';
                        $image2->resize(100, 100);
                        $image2->save($thumbPath.'thumb_'.$picture);
                        //save image information on the db.
                        $imageDb = new Image();
                        $imageDb->name = $picture;
                        $imageDb->post()->associate($post);
                        $imageDb->save();       
                    }        
            }
        }
        Flash::success("Post <strong>".$post->title."</strong> was created.");
        return redirect()->route('admin.posts.index');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('admin.posts.show')->with('Post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {          
        if(Auth::user()->type == 'admin'){
            $post = Post::find($id);
            $categories = Category::orderBy('name','DESC')->where('type','post')->lists('type','name','id');
            $tags = Tag::orderBy('name','DESC')->lists('name','id');
            $images = new Image();
            $post->images->each(function($post){
                $post->images;
            });
            $myTags = $post->tags->lists('id')->ToArray(); //give me a array with only the tags id.
            return View('admin.posts.edit')->with('post',$post)->with('categories',$categories)->with('tags',$tags)->with('myTags',$myTags);            
        }else{
            return redirect()->route('admin.posts.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {

        $post =Post::find($id);
        if($request->featured){
            $post->featured = 'true';
        }else{
            $post->featured = 'false';
        }
        $post->fill($request->all());
        $post->user_id = \Auth::user()->id;
        
        $post->save();
        $post->tags()->sync($request->tags);
        $picture = '';

        //Process Form Images
        if ($request->hasFile('images')) {
            $files = $request->file('images');

            foreach($files as $file){             

                    //Slider
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $picture = date('His').'_'.$filename;
                    //make images sliders
                    $image=\Image::make($file->getRealPath()); //Call image library installed.
                    // Build the input for validation
                    $fileArray = array('img' => $file);
                    // Tell the validator that this file should be an image
                    $rules = array(
                        'img' => 'dimensions:min_width=*,min_height=450'//max 10000kb
                    );
                    // Now pass the input and rules into the validator
                    $validator = \Validator::make($fileArray, $rules);
                   
                    if($validator->fails()){     
                         Flash('* Images must be 450px tall.','danger');         
                         return redirect()->back();
                    }else{
                        $destinationPath = 'img/posts/';
                        $image->resize(null,280, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save($destinationPath.'slider_'.$picture);
                        // Thumbnails
                        $image2=\Image::make($file->getRealPath()); //Call immage library installed.      
                        //make images thumbnails                        
                        $thumbPath ='img/posts/thumbs/';
                        $image2->resize(100, 100);
                        $image2->save($thumbPath.'thumb_'.$picture);
                        //save image information on the db.
                        $imageDb = new Image();
                        $imageDb->name = $picture;
                        $imageDb->post()->associate($post);
                        $imageDb->save();       
                    }

       
                   
            }
        }
        Flash::success('Post <strong>'.$post->title.'</strong> was updated.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
        $post = Post::find($id);
        $post->delete();
        Flash::error("Post <strong>".$post->name."</strong> was deleted.");
        return redirect()->route('admin.posts.index');            
      
    }
    
    public function approve($id)
    {
        if(Auth::user()->type == 'admin'){
            $post = Post::find($id);
            $post->status='approved';
            $post->save();
            Flash::success("Post <strong>".$post->title."</strong> was approved.");
            return redirect()->route('admin.posts.index');            
        }else{
            return redirect()->route('admin.dashboard.index');
        }
    }
    public function suspend($id)
    {
        if(Auth::user()->type == 'admin'){
            $post = Post::find($id);
            $post->status='suspended';
            $post->save();
            Flash::warning("Post <strong>".$post->title."</strong> was suspended.");
            return redirect()->route('admin.posts.index');            
        }else{
            return redirect()->route('admin.dashboard.index');
        }
    }
}
