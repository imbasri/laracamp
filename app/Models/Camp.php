<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Camp extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['title', 'price'];

    public function getIsRegisteredAttribute()
    {
        if (!auth()->check()) {
            return false;
        }
        // check if the user is registered for the camp
        return Checkout::whereCampId($this->id)->whereUserId(auth()->user()->id)->exists();
    }
}
