<?php

namespace App\Models\Cisco;

use App\Models\OAuth;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class WebexUser extends Model
{
    use HasFactory, Notifiable;

    /**
     * {@inheritdoc}
     */
    protected $keyType = 'string';

    /**
     * {@inheritdoc}
     */
    public $incrementing = false;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'synced_at'
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'synced_at' => 'datetime',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::limit($value);
    }

    public function groups()
    {
        return $this->belongsToMany(WebexGroup::class)
            ->using(WebexMembership::class);
    }

    public function oauth()
    {
        return $this->morphOne(OAuth::class, 'provider');
    }

    public function memberships()
    {
        return $this->hasMany(WebexMembership::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
