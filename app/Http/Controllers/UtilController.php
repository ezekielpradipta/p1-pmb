<?php

namespace App\Http\Controllers;

use App\Http\Resources\WilayahResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UtilController extends Controller
{
    public function cekEmail(Request $request)
    {
        $cek = $request->email;
        if ($cek != "") {
            $cek = $cek;
        }
        $data = DB::table('users')->where("email", $cek)->count();
        if ($data > 0) {
            return response()->json(['message' => 'not_unique'], 200);
        } else {
            return response()->json(['message' => 'unique'], 200);
        }
    }
    public function getWilayah(Request $request)  {
       
        $regions = DB::table('wilayah')
        ->select('wilayah.id','prov.nama_wilayah as nama_prov','kab.nama_wilayah as nama_kab','wilayah.id_wilayah as id_kecamatan', 'wilayah.nama_wilayah')
        ->join('wilayah as prov', 'prov.id_wilayah', 'like', DB::raw("concat(substr(wilayah.id_wilayah, 1, 2), '%')"))
        ->join('wilayah as kab', 'kab.id_wilayah', 'like', DB::raw("concat(substr(wilayah.id_wilayah, 1, 4), '%')"))
        ->join('wilayah as kec', 'kec.id_wilayah', '=', 'wilayah.id_wilayah')
        ->whereRaw("prov.nama_wilayah like 'Prov.%' and ( kab.nama_wilayah like 'Kab.%' or kab.nama_wilayah like 'Kota%' ) and kec.nama_wilayah like 'Kec.%'")
        ->groupBy('id','nama_prov', 'nama_kab',  'id_kecamatan','nama_wilayah')
        ->get();
    
        return response()->json($regions);
        // return WilayahResource::collection($regions);
        // $data = DB::table(DB::raw('(
        //     SELECT id, SUBSTR(id_wilayah, 1, 2) AS id_prov, SUBSTR(id_wilayah, 1, 4) AS id_kab, id_wilayah AS id_kecamatan
        //     FROM wilayah
        //   ) AS w'))
        //   ->join(DB::raw('(
        //     SELECT id_wilayah, nama_wilayah
        //     FROM wilayah
        //     WHERE nama_wilayah LIKE "Prov.%"
        //   ) AS prov'), 'prov.id_wilayah', 'LIKE', DB::raw("CONCAT(w.id_prov, '%')"))
        //   ->join(DB::raw('(
        //     SELECT id_wilayah, nama_wilayah
        //     FROM wilayah
        //     WHERE nama_wilayah LIKE "Kab.%" OR nama_wilayah LIKE "Kota.%"
        //   ) AS kab'), 'kab.id_wilayah', 'LIKE', DB::raw("CONCAT(w.id_kab, '%')"))
        //   ->join(DB::raw('(
        //     SELECT id_wilayah, nama_wilayah
        //     FROM wilayah
        //     WHERE nama_wilayah LIKE "Kec.%"
        //   ) AS kec'), 'kec.id_wilayah', '=', 'w.id_kecamatan')
        //   ->select('w.id', 'prov.nama_wilayah AS nama_prov', 'kab.nama_wilayah AS nama_kab', 'kec.nama_wilayah AS nama_kec','w.id_kecamatan')
        //   ->groupBy('w.id', 'nama_prov','nama_kab','nama_kec', 'w.id_kecamatan')
        //   ->get();
          
        //   return response()->json($data);
    }
}
