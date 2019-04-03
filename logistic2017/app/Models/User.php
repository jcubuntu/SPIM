<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function roles() {
        return $this->belongsToMany('App\Models\Role', 'role_users');
    }

    /**
     * checkRole
     *
     * @var boolean
     */
    public function hasRole($name, $matchAll = false) {
        $result = false;

        if(is_array($name)) {
            if($matchAll) {
                $result = $this->roles()->where(function($query) use ($name) {
                    foreach($name as $n) {
                        $query->where('name', $n);
                    }
                })->count();
            } else {
                $result = $this->roles()->whereIn('name', $name)->count();
            }
        } else {
            $result = $this->roles->where('name', $name)->count();
        }
        if(!$result && $name != 'admin') {
            $result = $this->hasRole('admin');
        }
        return $result;
        
    }
    /**
     * checkPermission
     *
     * @var boolean
     */
    public function hasPerm($name, $matchAll = false) {
        $roles = $this->roles;

        if($this->hasRole('admin')) return true;

        if(is_array($name)) {
            foreach ($roles as $role) {
                if($matchAll) {
                    $result = $role->permission->where(function($query) use ($name) {
                        foreach($name as $n) {
                            $query->where('name', $n);
                        }
                    })->count();
                } else {
                    $result = $role->permissions->whereIn('name', $name)->count();
                }
                if($result) return true;
            }
        } else {
            foreach ($roles as $role) {
                if($role->permissions->where('name', $name)->count()) return true;
            }
        }
        return false;
    }
}
