<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
      use HasFactory;
      protected $table='categories';
      protected $fillable = ['title','slug','description','status'];
      protected $hidden = ['updated_at'];
      public function books(){
        return $this->hasMany(Book::class);
      }

      public function scopeActive($q){
 $q->where('status',1);
      }
      public function getStatusAttribute($value){
   return $value==1 ? ' Active' : ' Not Active';
      }
      
}
