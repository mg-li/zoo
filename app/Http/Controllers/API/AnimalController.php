<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnimalForList as AnimalForListResource;
use App\Http\Resources\AnimalForShow as AnimalForShowResource;
use App\Animal;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $animals = Animal::all();
        return AnimalForListResource::collection($animals);
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
            $animal = new Animal;
            $animal->name = $request->animal['name'];
            $animal->gender = $request->animal['gender'];
            $animal->age = $request->animal['age'];
            $animal->save();
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
    public function show(Animal $animal)
    {
        return new AnimalForShowResource($animal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Animal $animal)
    {
        DB::transaction(function () use ($request, $animal) {
            $animal = new Animal;
            $animal->name = $request->animal['name'];
            $animal->gender = $request->animal['gender'];
            $animal->age = $request->animal['age'];
            $animal->save();
        });

        return response()->json([
            'result' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Animal $animal)
    {
        $animal->delete();

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
        // $animals = Animal::orderBy('last_phonetic_name')->orderBy('first_phonetic_name')->get();
        // return AnimalSelectorResource::collection($animals);
    }
}
