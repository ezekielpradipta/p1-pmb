<?php

namespace App\Http\Controllers;

use App\Http\Resources\WilayahResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
    public function getWilayah(Request $request)
    {
        $quee = $request->filter_query;
        // $regions = DB::table('wilayah')
        // ->select('wilayah.id','prov.nama_wilayah as nama_prov','kab.nama_wilayah as nama_kab','wilayah.id_wilayah as id_kecamatan', 'wilayah.nama_wilayah')
        // ->join('wilayah as prov', 'prov.id_wilayah', 'like', DB::raw("concat(substr(wilayah.id_wilayah, 1, 2), '%')"))
        // ->join('wilayah as kab', 'kab.id_wilayah', 'like', DB::raw("concat(substr(wilayah.id_wilayah, 1, 4), '%')"))
        // ->join('wilayah as kec', 'kec.id_wilayah', '=', 'wilayah.id_wilayah')
        // ->whereRaw("prov.nama_wilayah like 'Prov.%' and ( kab.nama_wilayah like 'Kab.%' or kab.nama_wilayah like 'Kota%' ) and kec.nama_wilayah like 'Kec.%'")
        // ->groupBy('id','nama_prov', 'nama_kab',  'id_kecamatan','nama_wilayah')
        // ->get();


        $regions = DB::table('wilayah as kec')
        ->select('kec.id','kec.id_wilayah as id_kec','kec.nama_wilayah as nama_kec','prov.nama_wilayah as nama_prov','kab.nama_wilayah as nama_kab')
        ->join('wilayah as prov', 'prov.id_wilayah', 'like', DB::raw("concat(substr(kec.id_wilayah, 1, 2), '%')"))
        ->join('wilayah as kab', 'kab.id_wilayah', 'like', DB::raw("concat(substr(kec.id_wilayah, 1, 4), '%')"))
        ->where('kec.nama_wilayah', 'like', 'Kec.%')
        ->where('prov.nama_wilayah', 'like', 'Prov.%')
        ->where(function ($query) {
            $query->where('kab.nama_wilayah', 'like', 'Kab.%')
                  ->orWhere('kab.nama_wilayah', 'like', 'Kota%');
        })
        ->get();
        return response()->json($regions);
    }
    public function saveImage($image, $folder_name)
    {
        // if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
        //     $image = substr($image, strpos($image, ',') + 1);
        //     $type = strtolower($type[1]); 
        //     if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
        //         throw new \Exception('invalid image type');
        //     }
        // if (strlen($image) > 2048000) {
        //     throw new \Exception('image size exceeded '. 2048000/1024 .' KB');
        // }
        //     $image = str_replace(' ', '+', $image);
        //     $image = base64_decode($image);

        //     if ($image === false) {
        //         throw new \Exception('base64_decode failed');
        //     }
        // } else {
        //     throw new \Exception('Format File BUkan JPG/JPEG/GIF/PNG');
        // }
        $dir = 'images/' . $folder_name . '/';
        $filename = date('YmdHis') . '-' . $image->getClientOriginalName();
        $absolutePath = public_path($dir);
        $relativePath = $dir . $filename;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        $image->move($absolutePath, $filename);

        return $relativePath;
    }
}
