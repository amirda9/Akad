<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $table = 'permissions';
    protected $guarded = [];
    public function group()
    {
        return $this->belongsTo('App\PermissionGroup','group_id');
    }
}
