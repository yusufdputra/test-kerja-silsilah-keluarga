<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Silsilah;
use Illuminate\Http\Request;

class SilsilahController extends Controller
{
    // get data cucu budi by jenis kelamin
    public function getCucuByJenisKelamin(Request $request)
    {
        $data = Silsilah::where([
            ['level', 3],
            ['jenis_kelamin', $request->jenis_kelamin]
        ])->get();

        return response()->json([
            'status'        => 200,
            'data'          => $data
        ]);
    }
}
