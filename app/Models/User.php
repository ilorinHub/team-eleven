<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasUlids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'password',
    ];

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

    protected function firstName () : Attribute
    {
        return Attribute::make(
            get: fn($value) => ucfirst($value),
            set: fn($value) => strtolower($value),
        );
    }

    protected function lastName () : Attribute
    {
        return Attribute::make(
            get: fn($value) => ucfirst($value),
            set: fn($value) => (!is_null($value)) ? strtolower($value) : NULL,
        );
    }

    protected function fullName () : Attribute
    {
        return Attribute::make(
            get: fn($value) => ucwords($value),
        );
    }

    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function payments() : HasMany
    {
        return $this->hasMany(Payment::class)
            ->whereStatus(Payment::PAID)
            ->orWhere('status', Payment::INCOMPLETE);
    }

    public function scopeSelf ($query) {
        return $query->where('id', auth()->id())->first();
    }

    public function hasAnyRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }

    public function hasAnyRoles(array $role)
    {
        return null !== $this->roles()->whereIn('name', $role)->first();
    }
}
