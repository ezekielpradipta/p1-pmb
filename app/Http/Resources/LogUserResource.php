<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LogUserResource extends JsonResource
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
            'ip'=>$this->ip,
            'email'=>$this->email,
            'filter'=>$this->filter,
            'status'=>$this->status,
            'keterangan'=>$this->keterangan,
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d'),
           ];
    }
}
