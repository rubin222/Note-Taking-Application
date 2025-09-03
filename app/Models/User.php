<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable; //allows model to use larave factories and allows model to recieve notifications

    protected $fillable = [  //only name,email,password can be set via mass assignment
        'name',
        'email',
        'password',
    ];

    protected $hidden = [ //fields are hidden when the model is converted to arrays or JSON
        'password',
        'remember_token',
    ];

    protected function casts(): array  //ensures how attributes should be converted automatically
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier()  
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    //defines one user can have many notes
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    //one user many category
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}