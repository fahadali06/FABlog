<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blogs extends Model
{
    use SoftDeletes;
    
    public function blogcategory() {
        return $this->hasOne('App\BlogCategory', 'id', 'blog_category');
    }
    
    public function bloguser() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
