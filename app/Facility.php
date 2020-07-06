<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
{
    use SoftDeletes;

    /**
     * 機械を取得
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
