<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory; //enables model factory ,help you quickly generate fake data for testing or database seeding


    protected $fillable = [ //fields set using mass assignment, mass assignment happens when do Category::create($request->all()    )
        'user_id',
        'name',
        'color'
    ];

    public function user(): BelongsTo  //defines relationship category belongs to user
    {
        return $this->belongsTo(User::class);
    }

    public function notes(): HasMany //defines relationship:category has many notes
    {
        return $this->hasMany(Note::class);
    }
}