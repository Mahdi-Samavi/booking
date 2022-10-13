<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasTranslations;

    public $translatable = ['title'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id', 'title', 'description',
    ];

    public function apps()
    {
        return $this->morphToMany(App::class, 'trackable');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function providers()
    {
        return $this->belongsToMany(Provider::class);
    }
}
