<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilController;
use App\Http\Resources\CamabaResource;
use App\Models\Camaba;
use App\Models\LogUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class DataDiriController extends Controller
{
    protected $dariUtil;
    public function __construct(UtilController $dariUtil)
    {
        $this->dariUtil = $dariUtil;
    }

    public function detail(){
        $user = DB::table('users')->select('camabas.id', 'camabas.nama_camaba', 'users.id as user_id', 'users.email as user_email', 'users.is_valid as user_is_valid', 'users.is_mahasiswa as user_is_mahasiswa', 'camabas.tempat_lahir', 'camabas.tanggal_lahir', 'camabas.jenis_kelamin', 'camabas.wilayah', 'camabas.file_upload')
       ->leftJoin('camabas', 'camabas.user_id', '=', 'users.id')->where('users.id', Auth::user()->id)->get();

    return CamabaResource::collection($user);
    }
    // public function detail(){
    // $user = DB::table('camabas')->where('user_id',Auth::user()->id)->first();
    // return response()->json($user);
    // }
    public function save(Request $request)
    {

        $cekstatus = $request->is_update;
        $validator = Validator::make($request->all(), [

            'file_upload' => 'required|file|max:2048',
            'nama_camaba' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'wilayah' => 'required',
        ], [

            'nama_camaba.required' => 'Nama Tidak Boleh Kosong',
            'tempat_lahir.required' => 'Tempat Lahir Tidak Boleh Kosong',
            'tanggal_lahir.required' => 'Tanggal Lahir Tidak Boleh Kosong',
            'wilayah.required' => 'Wilayah Tidak Boleh Kosong',
            'file_upload.max' => 'Ukuran File Maksimal 2Mb',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'e_code' => "10"], 400);
        }
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $camaba = Camaba::where('user_id', $user_id)->first();
        if (isset($request->file_upload) && $request->file_upload !== "null") {
            $relativePath = $this->dariUtil->saveImage($request->file_upload, 'CobaFolder');
            $file__ = $relativePath;
            if ($camaba && $camaba->file_upload) {
                $absolutePath = public_path($camaba->file_upload);
                File::delete($absolutePath);
            }
        } else if ($camaba) {
            $file__ = $camaba->file_upload;
        } else{
            $file__ = null;
        }
        $camaba = Camaba::updateOrCreate(['user_id' => $user_id], [
            'nama_camaba' => $request->nama_camaba,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'wilayah' => $request->wilayah,
            'jenis_kelamin' => $request->jenis_kelamin,
            'file_upload' => $file__,
        ]);
        $status = $cekstatus === "false" ? "REGISTER Data" : "Update DATA";
        $keterangan = $cekstatus === "false" ? "User " . $request->email . ' Berhasil Mengisi Data Diri.' : "User " . $request->email . " Berhasil Mengupdate Data Diri";
        $log = LogUser::create([
            'ip' => $request->ip(),
            'email' => $user_email,
            'filter' => $status,
            'status' => "SUKSES",
            'keterangan' => $keterangan
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Success!',
            'data'    => $camaba
        ], 201);
    }
}
