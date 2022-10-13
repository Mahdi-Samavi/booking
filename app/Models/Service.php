<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Service extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTranslations;

    public $translatable = ['title'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title', 'amount', 'description', 'duration',
        'presence_type', 'capacity', 'cancel_at', 'status',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['cover', 'gallery'];

    public function apps()
    {
        return $this->morphToMany(App::class, 'trackable');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function providers()
    {
        return $this->hasMany(Provider::class);
    }

    protected function cover(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl('service-cover'),
        );
    }

    protected function gallery(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getMedia('service-gallery'),
        );
    }
}
