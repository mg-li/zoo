<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ReportDetailForShow as ReportDetailForShowResource;
use App\Http\Resources\EmployeeSelector as EmployeeSelectorResource;

class ReportForShow extends JsonResource
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
            'remarks' => $this->remarks,
            'is_finished' => $this->is_finished,
            'report_details' => ReportDetailForShowResource::collection($this->report_details),
            'employees' => EmployeeSelectorResource::collection($this->employees),
        ];
    }
}
