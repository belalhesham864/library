<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loans extends Model
{
      use HasFactory;
            protected $table='loans';

      protected $fillable = [
    'user_id',
    'book_id',
    'loans_at',
    'due_date',
    'returned_at'
];

    protected $casts = [
        'loans_at' => 'datetime',
        'due_date' => 'datetime',
        'returned_at' => 'datetime',
    ];

      public function user(){
        return $this->belongsTo(User::class);
      }
      public function book(){
         return $this->belongsTo(Book::class);
      }
}
