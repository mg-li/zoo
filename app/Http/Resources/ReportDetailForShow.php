<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Attachment as AttachmentResource;
use App\Customer;
use App\Item;

class ReportDetailForShow extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer' => isset($this->customer) ? $this->customer : new Customer,
            'customer_name' => isset($this->customer) ? $this->customer->name : null,
            'item' => isset($this->item) ? $this->item : new Item,
            'item_name' => isset($this->item) ? $this->item->name : null,
            'item_flam' => isset($this->item) ? $this->item->flam : '',
            'item_id' => isset($this->item) ? $this->item->id : null,
            'item_process' => isset($this->item) ? $this->item->process : null,
            'category_id' => $this->category_id,
            'category_name' => isset($this->category) ? $this->category->name : null,
            'facility_id' => $this->facility_id,
            'facility_name' => isset($this->facility) ? $this->facility->name : null,
            'facility_other' => $this->facility_other,
            'instruction_num' => strval($this->instruction_num),
            'finish_num' => strval($this->finish_num),
            'setup_time' => strval(round($this->setup_time, 2)),
            'facility_time' => strval(round($this->facility_time, 2)),
            'work_time' => strval(round($this->work_time, 2)),
            'attachments' => AttachmentResource::collection($this->attachments),
        ];
    }
}
