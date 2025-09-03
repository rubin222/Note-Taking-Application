<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory; 

    protected $fillable = [ //fields that can be mass assigned i.e set multiple attributes on a model at once 
        'user_id',
        'category_id',
        'title',
        'content'
    ];

    public function user(): BelongsTo  //defines relationship note belong to user
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo //note belongs to category
    {
        return $this->belongsTo(Category::class);
    }
}