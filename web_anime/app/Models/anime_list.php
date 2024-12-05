<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class anime_list extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'image',
        'title',
        'year',
        'description'
    ];

    /**
     * image
     *
     * @return Attribute
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($image) => url('/storage/anime_lists/' . $image),
        );
    }
}
