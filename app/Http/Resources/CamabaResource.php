<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CamabaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'user_email'=>$this->user_email,
            'user_is_valid'=>$this->user_is_valid,
            'user_is_mahasiswa'=>$this->user_is_mahasiswa,
            'nama_camaba'=>$this->nama_camaba,
            'tempat_lahir'=>$this->tempat_lahir,
            'tanggal_lahir'=>$this->tanggal_lahir,
            'jenis_kelamin'=>$this->jenis_kelamin,
            'wilayah'=>$this->wilayah,
            'file_upload'=>$this->file_upload,
           ];
    }
}
