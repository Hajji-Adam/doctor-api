<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postman extends Model
{
    use HasFactory;
    protected $fillable = [ 'name','age'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
