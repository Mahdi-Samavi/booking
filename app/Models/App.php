<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class App extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'app_token', 'name',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $user = Auth::id();

            if (! $model->user_id) {
                $model->user_id = $user;
            }

            if (! $model->app_token) {
                $model->app_token = $user.'|'.Str::random(40);
            }
        });
    }

    public function appointments()
    {
        return $this->morphedByMany(Appointment::class, 'trackable');
    }

    public function categories()
    {
        return $this->morphedByMany(Category::class, 'trackable');
    }

    public function providers()
    {
        return $this->morphedByMany(Provider::class, 'trackable');
    }

    public function services()
    {
        return $this->morphedByMany(Service::class, 'trackable');
    }

    public function customers()
    {
        return $this->morphedByMany(Customer::class, 'trackable');
    }
}
