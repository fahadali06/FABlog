<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $table = 'blog_category';
    
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    public function user1(){
        return $this->hasMany('App/User', 'id');
    }
}
