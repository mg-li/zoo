<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportDetailForList extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $status = '未完了';
        // if(!empty($this->instruction_num) && !empty($this->finish_num)) {
        //     if($this->instruction_num > $this->finish_num) {
        //         $status = '作業中';
        //     } elseif($this->instruction_num = $this->finish_num) {
        //         $status = '作業完了';
        //     }
        // }

        return [
            'id' => $this->id,
            'customer_code' => isset($this->customer) ? $this->customer->code : '',
            'customer_name' => isset($this->customer) ? $this->customer->name : '',
            'item_code' => isset($this->item) ? $this->item->code : '',
            'item_name' => isset($this->item) ? $this->item->name : '',
            'item_flam' => isset($this->item) ? ( isset($this->item->flam) ? $this->item->flam : '' ) : '',
            'item_process' => isset($this->item) ? $this->item->process : '',
            'category_name' => isset($this->category) ? $this->category->name : '',
            // 'facility_id' => $this->facility_id,
            'facility_name' => isset($this->facility) ? $this->facility->name : $this->facility_other,
            'facility_other' => $this->facility_other,
            'instruction_num' => $this->instruction_num ?: 0,
            'finish_num' => $this->finish_num ?: 0,
            'setup_time' => round($this->setup_time, 2),
            'facility_time' => round($this->facility_time, 2),
            'work_time' => round($this->work_time, 2),
        ];
    }
}
