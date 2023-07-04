<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'contact_info',
        'social_media',
        'Facebook_links',
        'Instagram_links',
        'Twitter_links',
        'industry_category',
        'photo',
        'account_type',
        'client_name',
        'serviceList',
        'location'
    ];


    public function scopeFilter($query, array $filters)
    {
        if ($filters['search'] ?? false) {
            $searchTerm = $filters['search'];

            $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        return $query;
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationship With Listings
    public function listings() {
        return $this->hasMany(Listing::class, 'user_id');
    }

    public function posts() {
        return $this->hasMany(Post::class, 'user_id');
    }
    public function likes()
    {
        return $this->belongsToMany(Post::class, 'likes');
    }
    public function connections(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'connections', 'user_id', 'connected_user_id')
            ->withPivot('accepted')
            ->withTimestamps();
    }

    public function sentConnectionRequests(): BelongsToMany
    {
        return $this->connections()->wherePivot('accepted', false);
    }

    public function receivedConnectionRequests(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'connections', 'connected_user_id', 'user_id')
            ->wherePivot('accepted', false)
            ->withTimestamps();
    }

    public function connectedUsers(): BelongsToMany
    {
        return $this->connections()->wherePivot('accepted', true);
    }

    public function connect(User $user): void
    {
        $this->connections()->attach($user, ['accepted' => false]);
    }

    public function acceptConnectionRequest(User $user): void
    {
        $this->receivedConnectionRequests()->updateExistingPivot($user, ['accepted' => true]);
    }

}
