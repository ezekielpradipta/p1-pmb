<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilController;
use App\Http\Resources\CamabaResource;
use App\Http\Resources\UserResource;
use App\Models\Camaba;
use App\Models\LogUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    protected $dariUtil;
    public function __construct(UtilController $dariUtil)
    {
        $this->dariUtil = $dariUtil;
    }

    public function index(Request $request)
    {
        $filter_email = $request->email ?? "";
        $filter_valid = $request->valid ?? "";
        // $user = DB::table('role_user')->join('users', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', 2)->whereRaw("email like '%$filter_email%'  AND is_valid like '%$filter_valid%'")->orderBy('users.id', 'asc')->paginate(10);
        // return UserResource::collection($user);
        // ->select('users.id','users.email','users.is_valid','users.is_mahasiswa')
        $user = DB::table('role_user')->select('camabas.id', 'camabas.nama_camaba', 'users.id as user_id', 'users.email as user_email', 'users.is_valid as user_is_valid', 'users.is_mahasiswa as user_is_mahasiswa', 'camabas.tempat_lahir', 'camabas.tanggal_lahir', 'camabas.jenis_kelamin', 'camabas.wilayah', 'camabas.file_upload')
            ->join('users', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', 2)->leftJoin('camabas', 'camabas.user_id', '=', 'users.id')->whereRaw("users.email like '%$filter_email%'  AND users.is_valid like '%$filter_valid%'")->orderBy('users.id', 'asc')
            ->paginate(10);

        return CamabaResource::collection($user);
        // return response()->json($user);
    }
    public function save(Request $request)
    {
        $cekstatus = $request->is_update;
        if ($cekstatus == false) {
            $validator = Validator::make($request->all(), [

                'email'     => 'required|email|unique:users|indisposable',
                'password'  => 'required|min:8|',
                'file_upload' => 'required|file|max:2048',
                'nama_camaba' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'wilayah' => 'required',
            ], [

                'email.required' => 'Email Tidak Boleh Kosong',
                'email.email' => "Format Email salah",
                'password.required' => 'Password Tidak Boleh Kosong',
                'password.min' => 'Password Kurang dari 8 Digit',
                'email.indisposable' => "Email Fake",
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'password'  => 'required|min:8|',
                'nama_camaba' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'wilayah' => 'required',
            ], [

                'password.required' => 'Password Tidak Boleh Kosong',
                'password.min' => 'Password Kurang dari 8 Digit',
            ]);
        }

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'e_code' => "10"], 400);
        }
        $camaba = Camaba::where('user_id', $request->user_id)->first();
        if ($cekstatus === "true" && isset($request->file_upload) && $request->file_upload !== "null") {
            $relativePath = $this->dariUtil->saveImage($request->file_upload, 'CobaFolder');
            $file__ = $relativePath;
            if ($camaba && $camaba->file_upload) {
                $absolutePath = public_path($camaba->file_upload);
                File::delete($absolutePath);
            }
        } else if ($camaba) {
            $file__ = $camaba->file_upload;
        }
        $user = User::updateOrCreate(['id' => $request->user_id], [
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'is_valid' => "1",
        ]);
        $user->roles()->sync(2);
        $user->camaba()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama_camaba' => $request->nama_camaba,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'wilayah' => $request->wilayah,
                'jenis_kelamin' => $request->jenis_kelamin,
                'file_upload' => $file__,

            ]
        );
        $status = $cekstatus == false ? "REGISTER" : "Update DATA";
        $keterangan = $cekstatus == false ? "Admin Berhasil Mendaftarkan " . $request->email : "Admin Berhasil Merubah " . $request->email;

        $log = LogUser::create([
            'ip' => $request->ip(),
            'email' => $request->email,
            'filter' => $status,
            'status' => "SUKSES",
            'keterangan' => $keterangan
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Success!',
            'data'    => $user
        ], 201);
    }
    public function delete(Request $request, $id)
    {
        $user = User::find($id);
        $email = $user->email;
        $user->delete();
        $user->role_user->delete();
        $camaba = Camaba::where('user_id', $request->id)->first();
        if ($camaba) {
            if ($camaba->file_upload) {
                $absolutePath = public_path($camaba->file_upload);
                File::delete($absolutePath);
            }
            $camaba->delete();
        }
        LogUser::create([
            'ip' => $request->ip(),
            'email' => $email,
            'filter' => "Delete",
            'status' => "SUKSES",
            'keterangan' => "Admin Berhasil Menghapus " . $email
        ]);
        return response()->json([
            'message' => 'User Berhasil Dihapus!!',
        ], 201);
    }
    public function valid(Request $request, $id)
    {
        $user = User::find($id);
        $user->is_valid = '1';
        $email = $user->email;
        $user->save();
        $ip = $request->ip();
        $log = LogUser::create([
            'ip' => $ip,
            'email' => $email,
            'filter' => "Validasi Email",
            'status' => "SUKSES",
            'keterangan' => "Admin Berhasil Menghapus " . $email
        ]);
        return response()->json([
            'message' => 'Berhasil Memvalidasi User',
        ], 201);
    }
    public function detail($id)
    {
        $user = DB::table('role_user')->select('camabas.id', 'camabas.nama_camaba', 'users.id as user_id', 'users.email as user_email', 'users.is_valid as user_is_valid', 'users.is_mahasiswa as user_is_mahasiswa', 'camabas.tempat_lahir', 'camabas.tanggal_lahir', 'camabas.jenis_kelamin', 'camabas.wilayah', 'camabas.file_upload')
            ->join('users', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', 2)->leftJoin('camabas', 'camabas.user_id', '=', 'users.id')->where('users.id', $id)->get();
        return CamabaResource::collection($user);
    }
}
