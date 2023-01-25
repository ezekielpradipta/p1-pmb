<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\JenisQuiz;
use App\Http\Requests\StoreJenisQuizRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateJenisQuizRequest;
use App\Http\Resources\JenisQuizResource;
use App\Models\LogUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class JenisQuizController extends Controller
{
    public function index(){
        $jenis = DB::table('jenis_quiz')->paginate(10);
        return JenisQuizResource::collection($jenis);
    }
    public function detail($id){
        $jenis = DB::table('jenis_quiz')->where('id',$id)->get();
        return JenisQuizResource::collection($jenis);
    }
    public function store(Request $request)
    {
        $cekstatus = $request->is_update;
        $validator = Validator::make($request->all(), [

            'jenis_quiz'     => 'required|string',
        ], [

            'jenis_quiz.required' => 'Jenis Quiz Tidak Boleh Kosong',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'e_code' => "10"], 400);
        }
        $status = $cekstatus == false ? "TAMBAH JENIS QUIZ" : "Update JENIS QUIZ";
        $keterangan = $cekstatus == false ? "Admin Berhasil Menambah Jenis Quiz " : "Admin Berhasil Merubah Jenis Quiz ";
        $jenis = JenisQuiz::updateOrCreate(['id'=>$request->id],
        ['jenis_quiz'=>$request->jenis_quiz]);
        $log = LogUser::create([
            'ip' => $request->ip(),
            'email' => Auth::user()->email,
            'filter' => $status,
            'status' => "SUKSES",
            'keterangan' => $keterangan
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Success!',
        ], 201);


    }
    public function delete(Request $request,$id)
    {
       $jenis = JenisQuiz::find($id);
       $nama = $jenis->jenis_quiz;
       $jenis->delete();
       LogUser::create([
        'ip' => $request->ip(),
        'email' => Auth::user()->email,
        'filter' => "Delete",
        'status' => "SUKSES",
        'keterangan' => "Admin Berhasil Menghapus Jenis Quiz " . $nama
    ]);
    return response()->json([
        'message' => 'Jenis Quiz Berhasil Dihapus!!',
    ], 201);
    }

}
