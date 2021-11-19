<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    function posts() {
        return $this->hasMany(Post::class);
    }

    function subscribers() {
        return $this->hasMany(subscriber::class);
    }
}
