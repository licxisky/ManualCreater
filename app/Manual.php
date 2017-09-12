<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manual extends Model
{
    use SoftDeletes;

    protected $table = 'mn_manuals';

    const CREATED_AT = 'manual_create_time';
    const UPDATED_AT = 'manual_update_time';
    const DELETED_AT = 'manual_delete_time';

    public function manuals()
    {
        return $this->hasMany('\App\Manual', 'manual_parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('\App\Manual', 'manual_parent_id', 'id');
    }
}
