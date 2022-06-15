<?php

namespace App\Http\Controllers;

use App\Models\Silsilah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SilsilahController extends Controller
{
    public function insert(Request $request)
    {
        DB::beginTransaction();
        try {

            $id_ayah = $request->anak_dari;
            // jika value id_ayah = 0
            // maka level 1
            if ($id_ayah == 0) {
                $level = 1;
            } else {
                // cek level silsilah
                $anak_dari = Silsilah::where('id', $id_ayah)->value('id_ayah');

                // level 2 = null
                // level 3 = not null

                $level = 2;
                if ($anak_dari != null) {
                    $level = 3;
                }
            }

            // simpan
            $values = [
                'nama'              => $request->nama,
                'jenis_kelamin'     => $request->jenis_kelamin,
                'level'             => $level,
                'id_ayah'           => $id_ayah
            ];
            Silsilah::insert($values);
            $response = [
                'status'        => 200,
                'message'       => 'Berhasil menambahkan data'
            ];
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'status'        => 500,
                'message'       => 'Gagal menambahkan data' . $th
            ];
        }

        return response()->json($response);
    }
}
