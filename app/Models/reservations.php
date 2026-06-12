<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reservations extends Model
{
    protected $fillable = ['user_id','book_id','expires_at','status'];
    public function book(){
        return $this->belongsTo(Book::class,'Book_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
