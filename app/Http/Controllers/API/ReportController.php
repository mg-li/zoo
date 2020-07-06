<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ReportForList as ReportForListResource;
use App\Http\Resources\ReportForShow as ReportForShowResource;
use App\Http\Controllers\Controller;
use App\Report;
use App\Item;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $reports = Report::query();
        if(!empty($request->started_on)) {
            $reports->whereDate('started_on', '>=', $request->started_on);
        }
        if(!empty($request->finished_on)) {
            $reports->whereDate('finished_on', '<=', $request->finished_on);
        }
        if(!$request->is_admin){
            $reports->whereHas('report_details', function($q){
                $q->whereColumn('finish_num', '<', 'instruction_num');
            });
        }
        $reports = $reports->get();
        return ReportForListResource::collection($reports);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $report = new Report;
            $report->started_on  = $request->report['started_on'];
            $report->finished_on = $request->report['finished_on'];
            $report->remarks     = $request->report['remarks'];
            $report->is_finished = $request->report['is_finished'];
            $report->save();

            $ids = [];
            foreach ($request->report['employees'] as $employee) {
                array_push($ids, $employee['id']);
            }
            $report->employees()->sync($ids);

            foreach ($request->report['report_details'] as $detail) {
                if (!$detail['item_id']) {
                    $item = new Item;
                    $item->process = $detail['item_process'];
                    $item->name = isset($detail['item_name']) ? $detail['item_name'] : '商品名登録なし';
                    $item->flam = $detail['item_no'];
                    $item->save();
                }
                $report_detail = $report->report_details()->create([
                    // 'customer_id'     => array_key_exists('id', $detail['customer']) ? $detail['customer']['id'] : null,
                    // 'item_id'         => array_key_exists('id', $detail['item']) ? $detail['item']['id'] : null,
                    'item_id'     => isset($detail['item_id']) ? $detail['item_id'] : $item->id,
                    'category_id'     => $detail['category_id'],
                    'facility_id'     => $detail['facility_id'],
                    'facility_other'     => $detail['facility_other'],
                    'instruction_num' => $detail['instruction_num'],
                    'finish_num'      => $detail['finish_num'],
                    'setup_time'   => $detail['setup_time'],
                    'facility_time'   => $detail['facility_time'],
                    'work_time'       => $detail['work_time'],
                ]);

                // 添付ファイル
                $attachments = $detail['attachments'];
                $ids = [];
                foreach ($attachments as $attachment) {
                    array_push($ids, $attachment['id']);
                }
                $report_detail->attachments()->sync($ids);
            }
        });

        return response()->json([
            'result' => true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        return new ReportForShowResource($report);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        DB::transaction(function () use ($request, $report) {
            $report->started_on  = $request->report['started_on'];
            $report->finished_on = $request->report['finished_on'];
            $report->remarks     = $request->report['remarks'];
            $report->is_finished = $request->report['is_finished'];
            $report->save();

            $ids = [];
            foreach ($request->report['employees'] as $employee) {
                array_push($ids, $employee['id']);
            }
            $report->employees()->sync($ids);

            $report->report_details()->delete();
            foreach ($request->report['report_details'] as $detail) {
                if (!$detail['item_id']) {
                    $item = new Item;
                    $item->process = $detail['item_process'];
                    $item->name = isset($detail['item_name']) ? $detail['item_name'] : '商品名登録なし';
                    $item->flam = $detail['item_no'];
                    $item->save();
                }
                $report_detail = $report->report_details()->create([
                    'id'              => $detail['id'],
                    // 'customer_id'     => array_key_exists('id', $detail['customer']) ? $detail['customer']['id'] : null,
                    // 'item_id'         => array_key_exists('id', $detail['item']) ? $detail['item']['id'] : null,
                    'item_id'         => isset($detail['item_id']) ? $detail['item_id'] : $item->id,
                    'category_id'     => $detail['category_id'],
                    'facility_id'     => $detail['facility_id'],
                    'facility_other'  => $detail['facility_other'],
                    'instruction_num' => $detail['instruction_num'],
                    'finish_num'      => $detail['finish_num'],
                    'setup_time'      => $detail['setup_time'],
                    'facility_time'   => $detail['facility_time'],
                    'work_time'       => $detail['work_time'],
                ]);

                // 添付ファイル
                $attachments = $detail['attachments'];
                $ids = [];
                foreach ($attachments as $attachment) {
                    array_push($ids, $attachment['id']);
                }
                $report_detail->attachments()->sync($ids);
            }
        });

        return response()->json([
            'result' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        DB::transaction(function () use ($report) {
            foreach ($report->report_details as $report_detail) {
                foreach ($report_detail->attachments as $attachment) {
                    $attachment->deleteWithFile();
                }
                $report_detail->attachments()->detach();
            }
            $report->report_details()->delete();
            $report->delete();
        });
        return response()->json([
            'result' => true,
        ]);
    }

}
