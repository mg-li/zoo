<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class animal extends Model
{
    /**
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
}
