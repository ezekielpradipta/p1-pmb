<?php

namespace App\Exports;

use App\Models\LogUser;
use Maatwebsite\Excel\Concerns\FromCollection;

class LogUserExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LogUser::all();
    }
}
