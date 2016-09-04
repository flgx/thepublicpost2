<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\PhotoRequest;
use Laracasts\Flash\Flash;
use App\Photo;
use App\Tag;
use App\Image;
use App\Category;
use App\User;
use Auth;
use Config;
class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserPosts($id){
        $photos =  Photo::orderBy('id','DESC')->where('user_id',$id)->paginate(5);
        $photos->each(function($photos){
            $photos->category;
            $photos->images;
            $photos->tags;
            $photos->user;
        });
        $user = User::find($id);
        return view('admin.photos.user')
        ->with('photos',$photos)->with('user',$user);
    }
    public function addView(Request $request,$id){
        $photo = Photo::find($id);
        $photo->views = $photo->views + 1;
        $photo->update();
        return response()->json(['msg'=>'success']);
     
        
    }
    public function index(Request $request)
    {
        if(Auth::user()->type != 'subscriber'){
            $photos= Photo::Search($request->title)->orderBy('id','DESC')->where('user_id',Auth::user()->id)->paginate(5);
            $photos->each(function($photos){
                $photos->category;
                $photos->images;
                $photos->tags;
                $photos->user;
            });
            return view('admin.photos.index')
            ->with('photos',$photos);
        }else{
            Flash::error("You don't have permissions");
            return redirect()->route('admin.home');
        }
    }
    public function all(Request $request)
    {
        if(Auth::user()->type != 'subscriber'){
            $photos= Photo::Search($request->title)->orderBy('id','DESC')->paginate(5);
            $photos->each(function($photos){
                $photos->category;
                $photos->images;
                $photos->tags;
                $photos->user;
            });
            return view('admin.photos.all')
            ->with('photos',$photos);
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
                $categories = Category::orderBy('name','ASC')->where('type','photo')->lists('name','id');
                $tags =Tag::orderBy('name','ASC')->lists('name','id');
                $photos = Photo::orderBy('id','DESC')->paginate(4);
                return view('admin.photos.create')
                ->with('photos',$photos)
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
    public function store(PhotoRequest $request)
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
                        //if pass all the validations we add the photo and the images                        
                            $photo = new Photo($request->except('images','category_id','tags'));
                            $photo->user_id = \Auth::user()->id;
                           //associate category with photo
                            $category = Category::find($request['category_id']);
                            $photo->category()->associate($category);
                            $photo->save();  
                            //associate all tags for the photo
                            $photo->tags()->sync($request->tags);
                           
                            $destinationPath = 'img/photos/';
                            $image->resize(null,280, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $image->save($destinationPath.'slider_'.$picture);
                            // Thumbnails
                            $image2=\Image::make($file->getRealPath()); //Call immage library installed.      
                            //make images thumbnails                        
                            $thumbPath ='img/photos/thumbs/';
                            $image2->resize(100, 100);
                            $image2->save($thumbPath.'thumb_'.$picture);
                            //save image information on the db.
                            $imageDb = new Image();
                            $imageDb->name = $picture;
                            $imageDb->photo()->associate($photo);
                            $imageDb->save();       
                        }        
                }
            }
            Flash::success("Photo <strong>".$photo->title."</strong> was created.");
            return redirect()->route('admin.photos.index');
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
        $photo = Photo::find($id);
        return view('admin.photos.show')->with('Photo',$photo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        $photo = Photo::find($id); 
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor' || $photo->user()->first()->id == Auth::user()->id){            
            $categories = Category::orderBy('name','DESC')->where('type','photo')->lists('name','id');
            $tags = Tag::orderBy('name','DESC')->lists('name','id');
            $images = new Image();
            $photo->images->each(function($photo){
                $photo->images;
            });
            $myTags = $photo->tags->lists('id')->ToArray(); //give me a array with only the tags id.
            return View('admin.photos.edit')->with('photo',$photo)->with('categories',$categories)->with('tags',$tags)->with('myTags',$myTags);            
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
    public function update(PhotoRequest $request, $id)
    {
        if(Auth::user()->type != 'subscriber'){
            $photo =Photo::find($id);
            if($request->featured){
                $photo->featured = 'true';
            }else{
                $photo->featured = 'false';
            }
            $photo->fill($request->all());
            $photo->user_id = \Auth::user()->id;
            
            $photo->save();
            $photo->tags()->sync($request->tags);
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
                            $destinationPath = 'img/photos/';
                            $image->resize(null,280, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $image->save($destinationPath.'slider_'.$picture);
                            // Thumbnails
                            $image2=\Image::make($file->getRealPath()); //Call immage library installed.      
                            //make images thumbnails                        
                            $thumbPath ='img/photos/thumbs/';
                            $image2->resize(100, 100);
                            $image2->save($thumbPath.'thumb_'.$picture);
                            //save image information on the db.
                            $imageDb = new Image();
                            $imageDb->name = $picture;
                            $imageDb->photo()->associate($photo);
                            $imageDb->save();       
                        }
                }
            }
            Flash::success('Photo <strong>'.$photo->title.'</strong> was updated.');
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
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor' || $photo->user()->first()->id == Auth::user()->id){
            $photo = Photo::find($id);
            $photo->delete();
            Flash::error("Photo <strong>".$photo->name."</strong> was deleted.");
            return redirect()->route('admin.photos.index');
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.photos.index');
        }            
      
    }
    
    public function approve($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $photo = Photo::find($id);
            $photo->status='approved';
            $photo->save();
            Flash::success("Photo <strong>".$photo->title."</strong> was approved.");
            return redirect()->route('admin.photos.index');            
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }
    }
    public function suspend($id)
    {
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'editor'){
            $photo = Photo::find($id);
            $photo->status='suspended';
            $photo->save();
            Flash::warning("Photo <strong>".$photo->title."</strong> was suspended.");
            return redirect()->route('admin.photos.index');            
        }else{
            Flash::error("You don't have permissions to do that.");
            return redirect()->route('admin.home');
        }
    }
}
