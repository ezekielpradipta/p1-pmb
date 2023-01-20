<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
class CamabaResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'email'=>$this->user_email,
            'user_is_valid'=>$this->user_is_valid,
            'user_is_mahasiswa'=>$this->user_is_mahasiswa,
            // 'user' => new UserResource($this),
            'nama_camaba'=>$this->nama_camaba,
            'tempat_lahir'=>$this->tempat_lahir,
            'tanggal_lahir'=>$this->tanggal_lahir,
            'jenis_kelamin'=>$this->jenis_kelamin,
            'wilayah'=>$this->wilayah,
            'file_upload_url'=>$this->file_upload? URL::to($this->file_upload) : null,
           ];
    }
}
