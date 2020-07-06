<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    /**
     * この添付をつけた全スレッドの取得
     */
    public function borads()
    {
        return $this->morphedByMany('App\Board', 'attachmentables');
    }
    // 以下のコードは添付を紐づけるモデルへ記載する
    // /**
    //  * 添付ファイルの取得
    //  */
    // public function attachments()
    // {
    //     return $this->morphToMany('App\Attachment', 'attachmentable');
    // }

    /**
     * ファイルも併せて削除
     */
    public function deleteWithFile()
    {
        Storage::delete($this->file_path);
        $this->delete();
    }
}
