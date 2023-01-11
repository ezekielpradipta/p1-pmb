<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Resources\UserResource;
use App\Models\LogUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $filter_email = $request->email ?? "";
        $filter_valid = $request->valid ?? "";
        $user = DB::table('role_user')->join('users', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', 2)->whereRaw("(email like '%$filter_email%' OR name like '%$filter_email%') AND is_valid like '%$filter_valid%'")->orderBy('users.id', 'asc')->paginate(10);
        return UserResource::collection($user);
    }
    public function save(Request $request)
    {
        $cekstatus = $request->is_update;
        if ($cekstatus == false) {
            $validator = Validator::make($request->all(), [
                'name'      => 'required',
                'email'     => 'required|email|unique:users|indisposable',
                'password'  => 'required|min:8|confirmed'
            ], [
                'name.required' => 'Nama Tidak Boleh Kosong',
                'email.required' => 'Email Tidak Boleh Kosong',
                'email.email' => "Format Email salah",
                'password.required' => 'Password Tidak Boleh Kosong',
                'password.min' => 'Password Kurang dari 8 Digit',
                'password.confirmed' => 'Password Tidak Sama',
                'email.indisposable' => "Email Fake",
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name'      => 'required',
                'password'  => 'required|min:8|confirmed'
            ], [
                'name.required' => 'Nama Tidak Boleh Kosong',
                'password.required' => 'Password Tidak Boleh Kosong',
                'password.min' => 'Password Kurang dari 8 Digit',
                'password.confirmed' => 'Password Tidak Sama',

            ]);
        }
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'e_code' => "10"], 400);
        }
        $user = User::updateOrCreate(['id' => $request->id], [
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'is_valid' => "1",
        ]);
        $user->roles()->sync(2);
        $ip = $request->ip();
        if ($cekstatus == false) {
            $log = LogUser::create([
                'ip' => $ip,
                'email' => $request->email,
                'filter' => "REGISTER",
                'status' => "SUKSES",
                'keterangan' => "Admin Berhasil Merubah " . $request->email
            ]);
        } else {
            $log = LogUser::create([
                'ip' => $ip,
                'email' => $request->email,
                'filter' => "Update DATA",
                'status' => "SUKSES",
                'keterangan' => "Admin Berhasil Merubah " . $request->email
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Register Success!',
            'data'    => $user
        ], 201);
    }
    public function delete(Request $request, $id)
    {
        $user = User::find($id);
        $email = $user->email;
        $user->delete();
        $ip = $request->ip();
        $log = LogUser::create([
            'ip' => $ip,
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
    public function detail($id){
        $user = DB::table('users')->where('id',$id)->first();
        $data =[];
        if($user){
            $data['name']=$user->name;
            $data['email']=$user->email;
            $data['id']=$user->id;
        }
        return response()->json($data,200);
    }
}
