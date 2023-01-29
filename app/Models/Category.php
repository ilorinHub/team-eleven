<?php
declare(strict_types=1);

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

}
