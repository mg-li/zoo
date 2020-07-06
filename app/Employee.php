<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    /**
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
    /**
     * ユーザを取得
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * チームを取得
     */
    public function teams()
    {
        return $this->belongsToMany('App\Team', 'employee_team');
    }

    /**
     * 日報取得
     */
    public function reports()
    {
        return $this->belongsToMany('App\Report');
    }

    /**
     * 従業員のフルネーム取得
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->last_name} {$this->first_name}";
    }

    /**
     * かな名称を取得
     */
    public function getFullPhoneticNameAttribute()
    {
        return $this->last_phonetic_name.' '.$this->first_phonetic_name;
    }
}
