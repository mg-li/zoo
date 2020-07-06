<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Attachment;

class AttachmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeReportDetail(Request $request)
    {
        //添付ファイルの保存
        $attachment = DB::transaction(function () use ($request) {
            $dir = now()->format('Y/m');
            $name = $request->file('file')->getClientOriginalName();
            $path = $request->file('file')->store('upload/attachments/'.$dir);
            $size = $request->file('file')->getClientSize();
            $mine = $request->file('file')->getClientMimeType();
            $extention = $request->file('file')->getClientOriginalExtension();

            $attachment = new Attachment;
            $attachment->file_name = $name;
            $attachment->file_path = $path;
            $attachment->file_size = $size;
            $attachment->file_mine = $mine;
            $attachment->file_extention = $extention;
            $attachment->save();

            return $attachment;
        });
        return response()->json([
            'result' => true,
            'file' => [
                'id' => $attachment->id,
                'file_name' => $attachment->file_name,
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attachment $attachment)
    {
        // 削除は業務ロジックにて実施（キャンセルを考慮）
        // $attachment->deleteWithFile();
        return response()->json([
            'result' => true,
        ]);
    }

    /**
     * ファイルのダウンロード
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  Attachment  $attachment
     */
    public function download(Request $request, Attachment $attachment)
    {
        $file = storage_path('app/'.$attachment->file_path);    //ファイルの置いてるパス
        return response()->file($file);
    }
}
