<?php

namespace App\Models;

use Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'parent_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_root'           => 'boolean'
    ];

    public function getUserRoleAttribute()
    {
        if ($this->attributes['is_root']) {
            return 'Root user';
        }

        return data_get($this, 'role.display_name');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->role->label == $role;
        } else if (is_array($role)) {
            return in_array(g($this->role, 'id'), $role);
        } else if (gettype($role) == 'object') {
            return $this->hasRole(Arr::pluck($role, 'id'));
        }

        return $this->role_id == $role;
    }

    public function myUsers()
    {
        return $this->hasMany(self::class, 'id', 'parent_id');
    }

    public function scopeMine()
    {
        return $this->where('parent_id', Auth::user()->id);
    }

    /**
     * @param string $ability
     * @param array $arguments
     * @return bool
     */
    public function can($ability, $arguments = [])
    {
        return !!$this->is_root || parent::can($ability, $arguments);
    }
}
