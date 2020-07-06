<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\FacilityForList as FacilityForListResource;
use App\Http\Resources\FacilityForShow as FacilityForShowResource;
use App\Http\Resources\FacilitySelector as FacilitySelectorResource;
use App\Facility;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facilities = Facility::all();
        return FacilityForListResource::collection($facilities);
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
            $facility = new Facility;
            $facility->code = $request->facility['code'];
            $facility->category_id = $request->facility['category_id'];
            $facility->name = $request->facility['name'];
            $facility->model_number = isset($request->facility['model_number']) ? $request->facility['model_number'] : '';
            $facility->save();
        });

        return response()->json([
            'result' => true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function show(Facility $facility)
    {
        return new FacilityForShowResource($facility);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facility $facility)
    {
        DB::transaction(function () use ($request, $facility) {
            $facility->code = $request->facility['code'];
            $facility->category_id = $request->facility['category_id'];
            $facility->name = $request->facility['name'];
            $facility->model_number = isset($request->facility['model_number']) ? $request->facility['model_number'] : '';
            $facility->save();
        });

        return response()->json([
            'result' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facility $facility)
    {
        $facility->delete();

        return response()->json([
            'result' => true,
        ]);
    }

    /**
     * セレクトボックス用
     *
     * @return \Illuminate\Http\Response
     */
    public function selector()
    {
        $facilities = Facility::all();
        return FacilitySelectorResource::collection($facilities);
    }
}
