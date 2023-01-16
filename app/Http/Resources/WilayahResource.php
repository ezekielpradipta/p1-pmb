<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WilayahResource extends JsonResource
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
        'id_kecamatan'=>$this->id_kecamatan,
        'nama_kab'=>$this->nama_kab,
        'nama_prov'=>$this->nama_prov,
        'nama_wilayah'=>$this->nama_wilayah,
    ];
    }
}
