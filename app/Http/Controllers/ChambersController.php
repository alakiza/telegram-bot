<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Http\Controllers\DBHelper;

class ChambersController extends Controller
{
    public function GetChambers(Request $request)
    {
        $patients = DB::table('chambers')->get();

        return $patients;
    }

    public function AddChambers(Request $request)
    {
        // Log::info($request->json()->all());

        // $validator = Validator::make($request->all(), [
        // 'name' => ['required', 'max:255'],
        // 'base_probes_id' => ['required', 'integer'],
        // 'parameters' => ['array']
        // ]);

        // if ($validator->fails()) {
        // return response($validator->errors()->all(), 500);
        // }

        // $data = $request->json()->all();

        // DB::table('probes')->insert(['name' => $data['name'], 'base_probes_id' => $data['base_probes_id'], 'parameters' => json_encode($data['parameters'])]);

        // return response(200);
    }
}
