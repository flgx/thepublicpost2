<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $table = "newsletters";

    protected $fillable = ['email','ebook_id','photo_id','post_id','video_id'];

    public function ebook(){
    	return $this->belongsTo('App/Ebook');
    }
    public function photo(){
    	return $this->belongsTo('App/Photo');
    }
    public function video(){
    	return $this->belongsTo('App/Video');
    }
    public function post(){
    	return $this->belongsTo('App/Post');
    }
}
