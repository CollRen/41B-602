<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Category;  // Pas besoin car ||====---> namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
