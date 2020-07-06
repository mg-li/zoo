<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\SearchSelector as SearchSelectorResource;
use App\Customer;

class CustomerController extends Controller
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
                if(!preg_match("/^[0-9a-zA-Z]*$/", $csv_data['col1'])) {
                    continue;
                }

                $customer = Customer::where('code', $csv_data['col1'])->first();

                if (!$customer) {
                    $customer = new Customer;
                }

                $customer->code = $csv_data['col1'];
                $customer->name = $csv_data['col2'];

                $customer->save();
            }
        });
        return response()->json([
            'cusotmer_result' => 'true',
        ]);
    }

    public function selector(Request $request)
    {
        $code = $request->code;
        $name = $request->name;
        // $customer_type = $request->customer_type;

        $query = Customer::query();
        if(!empty($code)) {
            $query->where('code', 'like', '%'.$code.'%');
        }
        if(!empty($name)) {
            $query->where('name', 'like', '%'.$name.'%');
        }
        $customers = $query->get();
        
        // if ($customer_type == 3) {
        //     $customers = Customer::where()
        //     ->when($code, function ($query) use ($code) {
        //         return $query->where('code', 'like', '%'.$code.'%');
        //     })
        //     ->when($name, function ($query) use ($name) {
        //         return $query->where('name', 'like', '%'.$name.'%');
        //     })
        //     ->get();
        // } else if ($customer_type == 2) {
        //     $customers = Customer::where()
        //     // ->orWhere('is_supplier', '=', null)
        //     ->when($code, function ($query) use ($code) {
        //         return $query->where('code', 'like', '%'.$code.'%');
        //     })
        //     ->when($name, function ($query) use ($name) {
        //         return $query->where('name', 'like', '%'.$name.'%');
        //     })
        //     ->where('code', '<=', '001000')
        //     ->get();
        // } else if ($customer_type == 1) {
        //     $customers = Customer::where()
        //     // ->orWhere('is_supplier', '=', null)
        //     ->when($code, function ($query) use ($code) {
        //         return $query->where('code', 'like', '%'.$code.'%');
        //     })
        //     ->when($name, function ($query) use ($name) {
        //         return $query->where('name', 'like', '%'.$name.'%');
        //     })
        //     ->where('code', '>=', '001001')
        //     ->get();
        // }
        return SearchSelectorResource::collection($customers);
        // return response()->json([
        //     'cusotmer_result' => 'true',
        //     'request' => $request->code,
        // ]);
    }
}
