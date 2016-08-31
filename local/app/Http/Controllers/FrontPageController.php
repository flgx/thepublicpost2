<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Ebook;
use App\Tag;
use App\Post;
use App\Video;
use App\User;
use App\Image;
use App\Category;

use App\Photo;
class FrontPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slider_posts = Post::orderBy('id','DESC')->paginate(5);
        $lastest_posts = Post::orderBy('id','DESC')->paginate(5);
        $featured_posts = Post::orderBy('id','DESC')->paginate(3);
        $images = new Image();
        $featured_posts->each(function($post){
                $post->images->each(function($postimg){
                    $postimg->images;
                });
        });
        dd($featured_posts->items()[0]['images'][0]);
        exit();
        $lastest_videos = Video::orderBy('id','DESC')->paginate(3);
        $lastest_photos = Photo::orderBy('id','DESC')->paginate(4);
        return view('front.welcome')
        ->with('slider_posts',$slider_posts)
        ->with('lastest_posts',$lastest_posts)
        ->with('featured_posts',$featured_posts)
        ->with('lastest_videos',$lastest_videos)
        ->with('lastest_photos',$lastest_photos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
