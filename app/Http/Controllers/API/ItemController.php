<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\SearchSelector as SearchSelectorResource;
use App\Http\Resources\Item as ItemResource;
use App\Item;

class ItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function import(Request $request)
    {
        DB::transaction(function () use ($request) {
            $csv_datas = collect($request->datas);
            foreach ($csv_datas as $csv_data) {
                // if(!preg_match("/^[0-9a-zA-Z]*$/", $csv_data['col1'])) {
                //     continue;
                // }

                // $item = Item::where('code', $csv_data['col1'])->first();
                $item = Item::where('process', $csv_data['col17'])
                            ->where('name', $csv_data['col3'])
                            ->first();

                if (!$item) {
                    $item = new Item;
                }

                $csv_data['col3'] = preg_replace('/(\s+)/', ' ', $csv_data['col3']);
                $item->process = $csv_data['col17'] ?: '';
                $item->name = $csv_data['col3'];
                $item->flam = $csv_data['col31'];
                $item->record_no = $csv_data['col1'];
                $item->card_description = $csv_data['col5'];

                $item->save();

                Item::firstOrCreate (
                    ['process' => $csv_data['col17'],'name' => 'その他'],[]
                );

            }
        });
        return response()->json([
            'item_result' => 'true',
        ]);
    }

    public function selector(Request $request)
    {
        $items = Item::where('name', '<>', 'その他')->get();
        $others = Item::where('name', '=', 'その他')->get();

        foreach($others as $other) {
            $items -> push($other);
        };

        return ItemResource::collection($items);
    }
}
