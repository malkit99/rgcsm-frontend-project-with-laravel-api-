<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }

    public function hasPermissionTo(...$permissions){
        // $user->hasPermissionTo('edit-paot', 'delete-post');
        return $this->permissions()->whereIn('slug' , $permissions)->count();

    }

    public function scopeDeveloper($query){
        return $query->where('slug' , 'developer');
    }


    public function scopeAdmin($query){
        return $query->where('slug' , 'admin');
    }
}
