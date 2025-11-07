<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'isbn',
        'price',
        'author_id',
        'stock'

    ];

    protected $hidden = ['author_id', 'created_at', 'updated_at'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
