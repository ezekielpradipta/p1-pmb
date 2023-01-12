<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordUser;
use App\Mail\VerifEmailUser;
use App\Models\EmailVerif;
use App\Models\LogUser;
use App\Models\PasswordReset;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
  
            'email'     => 'required|email|unique:users|indisposable',
            'password'  => 'required|min:8|confirmed'
        ], [
 
            'email.required' => 'Email Tidak Boleh Kosong',
            'email.email' => "Format Email salah",
            'password.required' => 'Password Tidak Boleh Kosong',
            'password.min' => 'Password Kurang dari 8 Digit',
            'password.confirmed' => 'Password Tidak Sama',
            'email.indisposable' => "Email Fake",
        ]);
        $ip = $request->ip();  
        if ($validator->fails()) {
            $error =  $validator->errors();
            $email = $request->email ?? "";
            $log = LogUser::create([
                'ip'=> $ip,
                'email'=>$email,
                'filter'=>"LOGIN",
                'status'=>"GAGAL",
                'keterangan'=> "User ".$email." Gagal Register," . $error." "
            ]);
            return response()->json(['message' => $validator->errors(), 'e_code' => "10"], 400);
        }

        $user = User::create([
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);
        $user->roles()->attach(2);
        $email = $request->email;
        $tokenaa = Str::random(32);
        $token=  base64_encode($email . "+" .$tokenaa."+".$email);
        $verif = new EmailVerif();
        $verif->email = $email;
        $verif->token = $tokenaa;
        $verif->save();
        Mail::to($email)->send(new VerifEmailUser($token));   

        $log = LogUser::create([
            'ip'=> $ip,
            'email'=>$email,
            'filter'=>"REGISTER",
            'status'=>"SUKSES",
            'keterangan'=> "User ".$email." Berhasil Mendaftar"
        ]);
        return response()->json([
            'message' => 'Register Success!, Silahkan Cek Email Untuk Mengaktifkan Akun',
            'data'    => $user
        ], 201);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email Tidak Boleh Kosong',
            'email.email' => "Format Email salah",
            'password.required' => 'Password Tidak Boleh Kosong',
        ]);
        $ip = $request->ip();  
        if ($validator->fails()) {
         
            $email = $request->email ?? "";
            $error =  $validator->errors();
         
            $log = LogUser::create([
                'ip'=> $ip,
                'email'=>$email,
                'filter'=>"LOGIN",
                'status'=>"GAGAL",
                'keterangan'=> "User ".$email." Gagal LOGIN," . $error." "
            ]);
            return response()->json(['message' => $validator->errors(), "e_code" => "10"], 400);
        }
        $email = $request->email;
        $user = User::where('email', $email)->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {

            $log = LogUser::create([
                'ip'=> $ip,
                'email'=>$email,
                'filter'=>"LOGIN",
                'status'=>"GAGAL",
                'keterangan'=> "User ".$email." Memasukan Password Salah " 
            ]);
            return response()->json([
                'e_code' => "11",
                'message' => 'Login Gagal! Periksa kembali Email / Password',
            ], 400);
        }
        $log = LogUser::create([
            'ip'=> $ip,
            'email'=>$email,
            'status'=>"SUKSES",
            'filter'=>"LOGIN",
            'keterangan'=> "User ".$email." Berhasil LOGIN"
        ]);
        $message = "Selamat Datang " . (string)$user->email;
        return response()->json([
            'message' => $message,
            'data'    => $user,
            'token'   => $user->createToken('authToken')->accessToken
        ], 201);
    }
    public function logout(Request $request)
    {
        
        $ip = $request->ip();  
        $email = $request->user()->email;      
        $log = LogUser::create([
            'ip'=> $ip,
            'email'=>$email,
            'status'=>"SUKSES",
            'filter'=>"LOGOUT   ",
            'keterangan'=> "User ".$email." Telah Logout"
        ]);
        $removeToken = $request->user()->tokens()->delete();
        if ($removeToken) {
            return response()->json([
                'message' => 'Logout Success!',
            ], 201);
        }
     
    }
    public function getUser()
    {
        $user = auth()->user();
        return response()->json($user, 200);
    }

    public function validasiEmail(Request $request,$id)
    {

        if (base64_encode(base64_decode($id, true)) === $id) {
            $test = base64_decode($id);
            $rule1 = Str::contains($test, '+');
            if (!$rule1) {
                return response()->json(['message' => 'PERUBAHAN DATA PAKSA TERDETEKSI'], 401);
            }
            $array = explode('+', $test);
            $tryAr = array($array);
            $rule2 = count($array);
            if ($rule2 !== 3) {
                return response()->json(['message' => 'PERUBAHAN DATA PAKSA TERDETEKSI'], 401);
            }
            $user = User::where("email", $array[2])->first();
            if (!$user) {
                return response()->json(['message' => 'PERUBAHAN DATA PAKSA TERDETEKSI'], 401);
            }
            $verif_email = EmailVerif::where("email", $array[2])->where("token", $array[1])->first();
            if (!$verif_email) {
                return response()->json(['message' => 'PERUBAHAN DATA PAKSA TERDETEKSI'], 401);
            }
        
            $user->is_valid= "1";
            $user->save();
            $verif_email->delete();
            $ip = $request->ip();  
            $email = $array[2];      
            $log = LogUser::create([
                'ip'=> $ip,
                'email'=>$email,
                'status'=>"SUKSES",
                'filter'=>"Validasi Email",
                'keterangan'=> "User ".$email." Berhasil Memvalidasi Email"
            ]);
            return response()->json([
                'message' => 'Email Berhasil Terverifikasi!',
            ], 201);
            // return response()->json($user);
        } else {
            return response()->json(['message' => 'PERUBAHAN DATA PAKSA TERDETEKSI'], 401);
        }

    }
    public function sendToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], [
            'email.required' => 'Email Tidak Boleh Kosong',
            'email.email' => "Format Email salah",
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), "e_code" => "10"], 400);
        }
        $user = User::where('email', $request->email)->first();
        if (!isset($user->id)) {
            return response()->json(['message' => 'User Tidak Ditemukan', 'e_code' => '12'], 400);
        }
        $token = Str::random(32);
        Mail::to($user)->send(new ResetPasswordUser($token));
        $password_ = new PasswordReset();
        $password_->email = $user->email;
        $password_->token = $token;
        $password_->save();
        $ip = $request->ip();  
        $email = $request->email;      
        $log = LogUser::create([
            'ip'=> $ip,
            'email'=>$email,
            'status'=>"SUKSES",
            'filter'=>"Send Token",
            'keterangan'=> "User ".$email." Berhasil Mengirim Token Reset Password Ke Email"
        ]);
        return response()->json([
            'message' => 'Silahkan Cek Email',
        ], 201);
    }
    public function validateToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ], [
            'token.required' => 'Token Tidak Boleh Kosong',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), "e_code" => "10"], 400);
        }
        $password = PasswordReset::where('token', $request->token)->first();
        if (!isset($password->email)) {
            return response()->json(['message' => 'Token Salah', 'e_code' => '13'], 400);
        }
        $user = User::where('email', $password->email)->first();
        $ip = $request->ip();  
        $email = $password->email;      
        $log = LogUser::create([
            'ip'=> $ip,
            'email'=>$email,
            'status'=>"SUKSES",
            'filter'=>"Validasi Token",
            'keterangan'=> "User ".$email." Berhasil Memvalidasi Token Reset Password"
        ]);
        return response()->json($user, 200);
    }
    public function resetPassword($id)
    { 
        if (base64_encode(base64_decode($id, true)) === $id) {
            $test = base64_decode($id);
            $rule1 = Str::contains($test, '+');
            if (!$rule1) {
                return response()->json(['message' => 'PERUBAHAN DATA PAKSA TERDETEKSI'], 401);
            }
            $array = explode('+', $test);
            $tryAr = array($array);
            $rule2 = count($array);
            if ($rule2 !== 3) {
                return response()->json(['message' => 'PERUBAHAN DATA PAKSA TERDETEKSI'], 401);
            }
            if ($array[0] !== "email") {
                return response()->json(['message' => 'PERUBAHAN DATA PAKSA TERDETEKSI'], 401);
            }
            $user = User::where("email", $array[1])->first();
            if (!$user) {
                return response()->json(['message' => 'PERUBAHAN DATA PAKSA TERDETEKSI'], 401);
            }
            $password_reset = PasswordReset::where("email", $array[1])->where("token", $array[2])->first();
            if (!$password_reset) {
                return response()->json(['message' => 'PERUBAHAN DATA PAKSA TERDETEKSI'], 401);
            }
            return response()->json([ $array], 200);
        } else {
            return response()->json(['message' => 'PERUBAHAN DATA PAKSA TERDETEKSI'], 401);
        }
    }
    public function newPassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
        ], [
            'password.required' => 'Password Tidak Boleh Kosong',
            'password.min' => 'Password Kurang dari 8 Digit',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), "e_code" => "10"], 400);
        }
        $getData =  $this->resetPassword($id);
        $data_email = $getData->original[0][1];
        $user = User::where("email", $data_email)->first();
        $password_reset = PasswordReset::where("email",$user->email)->first();
        $password_reset->delete();
        $user->password = Hash::make($request->password);
        $user->save();
        // return response()->json(['hasil' => $password_reset], 200);
        $ip = $request->ip();  
        $email = $data_email;      
        $log = LogUser::create([
            'ip'=> $ip,
            'email'=>$email,
            'status'=>"SUKSES",
            'filter'=>"Reset Password",
            'keterangan'=> "User ".$email." Berhasil Mereset Password"
        ]);
        return response()->json([
            'message' => 'Password Berhasil dirubah, Silahkan Login Kembali',
        ], 201);
    }
}
