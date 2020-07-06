<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\EmployeeForList as EmployeeForListResource;
use App\Http\Resources\ReportDetailForList as ReportDetailForListResource;
use App\Http\Resources\Employee as EmployeeResource;

class ReportForList extends JsonResource
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
            'started_on' => $this->started_on,
            'finished_on' => $this->finished_on,
            'report_details' => ReportDetailForListResource::collection($this->report_details),
            'report_employees' => EmployeeResource::collection($this->employees),
            'employees' => implode(',', $this->employees->pluck('full_name')->all()),
            'customers' => implode(',', $this->report_details->pluck('customer.name')->all()),
            'items' => implode(',', $this->report_details->pluck('item.name')->all()),
            'flams' => implode(',', $this->report_details->pluck('item.flam')->all()),
            'status' => $this->status,
            'is_finished' => $this->is_finished,
        ];
    }
}
