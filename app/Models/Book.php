<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{

    use HasFactory,SoftDeletes;
          protected $table='books';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cost',
        'image',
        'status',
        'category_id',
    ];
    
    protected $hidden = ['deleted_at','created_at'];
    public function category(){
        return $this->belongsTo(Category::class);
    }
        public function loans(){
        return $this->hasMany(Loans::class);
    }
          public function scopeActive($q){
 $q->where('status',1);
      }
           public function getStatusAttribute($value){
   return $value==1 ? ' Active' : ' Not Active';
      }
     
public function getImageAttribute($value)
{
    return asset($value);
}

public function scopeActiveCategry($query){
    return $query->whereHas('category',function($q)
    {
        $q->where('status',1);
    });
}
}
