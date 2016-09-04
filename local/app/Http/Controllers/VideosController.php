<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\VideoRequest;
use Laracasts\Flash\Flash;
use App\Video;
use App\Tag;
use App\Image;
use App\Category;
use App\User;
use Auth;
use Config;
class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserPosts($id){
        $videos =  Video::orderBy('id','DESC')->where('user_id',$id)->paginate(5);
        $videos->each(function($videos){
            $videos->category;
            $videos->images;
            $videos->tags;
            $videos->user;
        });
        $user = User::find($id);
        return view('admin.videos.user')
        ->with('videos',$videos)->with('user',$user);
    }
    public function addView(Request $request,$id){
        $video = Video::find($id);
        $video->views = $video->views + 1;
        $video->update();
        return response()->json(['msg'=>'success']);
     
        
    }
    public function index(Request $request)
    {
        if(Auth::user()->type != 'subscriber'){
            $videos= Video::Search($request->title)->orderBy('id','DESC')->where('user_id',Auth::user()->id)->paginate(5);
            $videos->each(function($videos){
                $videos->category;
                $videos->images;
                $videos->tags;
                $videos->user;
            });
            return view('admin.videos.index')
            ->with('videos',$videos);
        }else{
            Flash::error("You don't have permissions");
            return redirect()->route('admin.home');
        }
    }
    public function all(Request $request)
    {
        if(Auth::user()->type != 'subscriber'){
            $videos= Video::Search($request->title)->orderBy('id','DESC')->paginate(5);
            $videos->each(function($videos){
                $videos->category;
                $videos->images;
                $videos->tags;
                $videos->user;
            });
            return view('admin.videos.all')
            ->with('videos',$videos);
        }else{
            Flash::error("You don't have permissions");
            return redirect()->route('admin.home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->type != 'subscriber'){
                $categories = Category::orderBy('name','ASC')->where('type','video')->lists('name','id');
                $tags =Tag::orderBy('name','ASC')->lists('name','id');
                $videos = Video::orderBy('id','DESC')->paginate(4);
                return view('admin.videos.create')
                ->with('videos',$videos)
                ->with('categories',$categories)
                ->with('tags',$tags);
        }else{
            Flash::error("You don't have permissions");
            return redirect()->route('admin.home');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VideoRequest $request)
    {
        if(Auth::user()->type != 'subscriber'){
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
                        //if pass all the validations we add the video and the images                        
                            $video = new Video($request->except('images','category_id','tags'));
                            $video->user_id = \Auth::user()->id;
                           //associate category with video
                            $category = Category::find($request['category_id']);
                            $video->category()->associate($category);
                            $video->save();  
                            //associate all tags for the video
                            $video->tags()->sync($request->tags);
                           
                            $destinationPath = 'img/videos/';
                            $image->resize(null,280, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $image->save($destinationPath.'slider_'.$picture);
                            // Thumbnails
                            $image2=\Image::make($file->getRealPath()); //Call immage library installed.      
                            //make images thumbnails                        
                            $thumbPath ='img/videos/thumbs/';
                            $image2->resize(100, 100);
                            $image2->save($thumbPath.'thumb_'.$picture);
                            //save image information on the db.
                            $imageDb = new Image();
                            $imageDb->name = $picture;
                            $imageDb->video()->associate($video);
                            $imageDb->save();       
                        }        
                }
            }
            Flash::success("Video <strong>".$video->title."</strong> was created.");
            return redirect()->route('admin.videos.index');
            }
        }else{
                Flash::error("You don't have permissions");
                return redirect()->route('admin.home');
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
        $video = Video::find($id);
        return view('admin.videos.show')->with('Video',$video);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        $video = Video::find($id); 
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor' || $video->user()->first()->id == Auth::user()->id){            
            $categories = Category::orderBy('name','DESC')->where('type','video')->lists('name','id');
            $tags = Tag::orderBy('name','DESC')->lists('name','id');
            $images = new Image();
            $video->images->each(function($video){
                $video->images;
            });
            $myTags = $video->tags->lists('id')->ToArray(); //give me a array with only the tags id.
            return View('admin.videos.edit')->with('video',$video)->with('categories',$categories)->with('tags',$tags)->with('myTags',$myTags);            
        }else{
            Flash:error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VideoRequest $request, $id)
    {
        if(Auth::user()->type != 'subscriber'){
            $video =Video::find($id);
            if($request->featured){
                $video->featured = 'true';
            }else{
                $video->featured = 'false';
            }
            $video->fill($request->all());
            $video->user_id = \Auth::user()->id;
            
            $video->save();
            $video->tags()->sync($request->tags);
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
                            $destinationPath = 'img/videos/';
                            $image->resize(null,280, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $image->save($destinationPath.'slider_'.$picture);
                            // Thumbnails
                            $image2=\Image::make($file->getRealPath()); //Call immage library installed.      
                            //make images thumbnails                        
                            $thumbPath ='img/videos/thumbs/';
                            $image2->resize(100, 100);
                            $image2->save($thumbPath.'thumb_'.$picture);
                            //save image information on the db.
                            $imageDb = new Image();
                            $imageDb->name = $picture;
                            $imageDb->video()->associate($video);
                            $imageDb->save();       
                        }
                }
            }
            Flash::success('Video <strong>'.$video->title.'</strong> was updated.');
            return redirect()->back();
        }else{
                Flash::error("You don't have permissions");
                return redirect()->route('admin.home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor' || $video->user()->first()->id == Auth::user()->id){
            $video = Video::find($id);
            $video->delete();
            Flash::error("Video <strong>".$video->name."</strong> was deleted.");
            return redirect()->route('admin.videos.index');
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.videos.index');
        }            
      
    }
    
    public function approve($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $video = Video::find($id);
            $video->status='approved';
            $video->save();
            Flash::success("Video <strong>".$video->title."</strong> was approved.");
            return redirect()->route('admin.videos.index');            
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }
    }
    public function suspend($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $video = Video::find($id);
            $video->status='suspended';
            $video->save();
            Flash::warning("Video <strong>".$video->title."</strong> was suspended.");
            return redirect()->route('admin.videos.index');            
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }
    }
}
