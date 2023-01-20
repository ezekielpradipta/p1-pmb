<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Mail\VerifEmailUser;
use App\Models\EmailVerif;
use App\Models\LogUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return UserResource::make($user);
    }
    public function sendEmail(Request $request){
        $email = Auth::user()->email;
        $tokenaa = Str::random(32);
        $token=  base64_encode($email . "+" .$tokenaa."+".$email);
        $verif = new EmailVerif();
        $verif->email = $email;
        $verif->token = $tokenaa;
        $verif->save();
        Mail::to($email)->send(new VerifEmailUser($token));   
        $ip = $request->ip();  
        $log = LogUser::create([
            'ip'=> $ip,
            'email'=>$email,
            'filter'=>"Kirim Email Verifikasi",
            'status'=>"SUKSES",
            'keterangan'=> "User ".$email." Berhasil Mengirim Email Verifikasi"
        ]);
        return response()->json([
            'message' => 'Silahkan Cek Email Untuk Mengaktifkan Akun',
        ], 201);
    }
}
