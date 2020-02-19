<?php

namespace App\Traits;

use App\Permission;

trait HasPermissions {

    public function hasPermissionTo(...$permissions){
        // $user->hasPermissionTo('edit-paot', 'delete-post');
        return $this->permissions()->whereIn('slug' , $permissions)->count() ||
        $this->roles()->whereHas('permissions' , function($q) use($permissions){
            $q->whereIn('slug' , $permissions);
        })->count();
    }

    private function getPermissionIdsBySlug($permissions){
        return Permission::whereIn('slug' , $permissions)->get()->pluck('id')->toArray();
    }

    public function givePermissionTo(...$permissions){
        $permissionIds =
        $this->permissions()->attach($this->getPermissionIdsBySlug($permissions));
    }

    public function setPermissionsTo(...$permissions){
        $this->permissions()->sync($this->getPermissionIdsBySlug($permissions));
    }

    public function detachPermission(...$permissions){
        $this->permissions()->detach($this->getPermissionIdsBySlug($permissions));
    }
}
