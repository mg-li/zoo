<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;
    /**
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
    /**
     * 日報詳細
     */
    public function report_details()
    {
        return $this->hasMany('App\ReportDetail');
    }

    /**
     * 担当者
     */
    public function employees()
    {
        return $this->belongsToMany('App\Employee', 'report_employee');
    }

    /**
     * 状態を取得
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        // status 0:未入力、1:作業中、2:作業完了
        if (!count($this->report_details)) return 0;
        $status = 2;
        // foreach ($this->report_details as $report_detail) {
        //     if ($report_detail->finish_num < $report_detail->instruction_num) {
        //         $status = 1;
        //         break;
        //     }
        // }
        // foreach ($this->report_details as $report_detail) {
        //     if (!$report_detail->instruction_num) {
        //         $status = 0;
        //         break;
        //     }
        // }
        foreach ($this->report_details as $report_detail) {
            if (!$report_detail->finish_num) {
                $status = 1;
                break;
            }
        }
        return $status;
    }
}
