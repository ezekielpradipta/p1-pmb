<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Exports\LogUserExport;
use App\Http\Resources\LogUserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
class LogUserController extends Controller
{
    public function index(Request $request)
    {
        $filter_email = $request->email ?? "";
        $filter_type = $request->filter ?? "";
        $filter_status = $request->status ?? "";
        $tanggal_awal = $request->tanggal_awal ?? "";
        $tanggal_akhir = $request->tanggal_akhir ?? "";
        $query = DB::table('log_users')->orderBy('created_at', 'desc')->whereRaw("filter like '%$filter_type%' AND email like '%$filter_email%' AND status like '%$filter_status%'  ");

    if ($tanggal_awal && $tanggal_akhir) {
        $query = $query->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir]);
    }

        $log = $query->paginate(10);
        return LogUserResource::collection($log);
    }
    public function getFilter()
    {
        $types = DB::table('log_users')
            ->orderBy('created_at', 'desc')
            ->get()
            ->pluck('filter')
            ->toArray();
        $counts = array_count_values($types);
        arsort($counts);

        $list = array_map(function ($key) {
            return ['filter' => $key,];
        }, array_keys($counts));

        return response()->json($list ?: ['filter' => 'Data Tidak Ditemukan']);
    }
    public function export() 
    {
        ob_end_clean();
        ob_start();
        return Excel::download(new LogUserExport, 'LogUser.xlsx');
    }
}
