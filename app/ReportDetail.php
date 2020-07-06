<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportDetail extends Model
{
    use SoftDeletes;
    /**
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 複数代入しない属性
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * 得意先
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    /**
     * 商品
     */
    public function item()
    {
        return $this->belongsTo('App\Item');
    }

    /**
     * 設備
     */
    public function facility()
    {
        return $this->belongsTo('App\Facility');
    }

    /**
     * 機械
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * 添付ファイルの取得
     */
    public function attachments()
    {
        return $this->morphToMany('App\Attachment', 'attachmentable')->withTimestamps();
    }
}
