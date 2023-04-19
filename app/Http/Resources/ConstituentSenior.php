<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConstituentSenior extends JsonResource
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
            'id' => $this->id,
            'name' => $this->constituent->full_name,
            'hcn' => $this->constituent->household->hhinfo->hhcontrol_num,
            'age' => $this->constituent->age,
            'sex' => $this->constituent->sex,
            'bday' => $this->constituent->birthdate ? $this->constituent->birthdate->toFormattedDateString() : '',
            'address' => $this->constituent->household->hhinfo->location ? $this->constituent->household->hhinfo->location->barangay->name.', Sitio '.$this->constituent->household->hhinfo->location->sitio->name :'',
            'pensions' => $this->pensions ? $this->pensions->map(function($inner){ return ["logo" =>"images/pension/".$inner->id.".png", "code" => $inner->code, "name" => PensionType::where('id',$inner->id)->first()->code,"id" => $inner->id];}) : [],

            
            'registration_date' => $this->created_at ? $this->created_at->toFormattedDateString() : '',
        ];
    }
}
