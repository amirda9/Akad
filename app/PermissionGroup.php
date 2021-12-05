<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    protected $table = 'permission_groups';
    protected $guarded = [];

    public function permissions()
    {
        return $this->hasMany('App\Permission','group_id');
    }
}
