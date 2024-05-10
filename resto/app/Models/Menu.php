<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = array("nom", "description", "prix", "estVege", "image");
    protected $casts = [
        'estVege' => 'boolean'
    ];

    public function imageFullPath()
    {
        return "/storage/$this->image";
    }
}
