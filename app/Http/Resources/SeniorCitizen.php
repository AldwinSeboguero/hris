<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\DisabilityType;
use App\Models\ConstituentPwd;
class SeniorCitizen extends JsonResource
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
            'name' => $this->full_name,
            'hcn' => $this->household->hhinfo->hhcontrol_num,
            'age' => $this->age,
            'sex' => $this->sex,
            'income' => $this->income->annualincome ? 'Php '.$this->income->annualincome->from.'.00 - '.$this->income->annualincome->to.'.00' : '',

            'pwd_id' => ConstituentPwd::where('constituent_id', $this->id)->get()->first() ? ConstituentPwd::where('constituent_id', $this->id)->get()->first()->pwd_id : '',

            'bday' => $this->birthdate ? $this->birthdate->toFormattedDateString() : '',
            'status' => ConstituentPwd::where('constituent_id', $this->id)->get()->first() ? ConstituentPwd::where('constituent_id', $this->id)->get()->first()->active : '',
            'address' => $this->household->hhinfo->location ? $this->household->hhinfo->location->barangay->name.', Sitio '.$this->household->hhinfo->location->sitio->name :'',
            'disabilities' => $this->disabilities ? $this->disabilities->map(function($inner){ return [ "name" => DisabilityType::where('id',$inner->id)->first()->name,"id" => $inner->id];}) : [],
            // 'pensions' => ConstituentPwd::where('constituent_id', $this->id)->get()->first() ? ConstituentPwd::where('constituent_id', $this->id)->first()->pensions->map(function($inner){ return ["logo" =>"images/pension/".$inner->pension_type_id.".png", "name" => PensionType::where('id',$inner->pension_type_id)->first()->code];}) : '',
            'createdby' => ConstituentPwd::where('constituent_id', $this->id)->get()->first() ? (ConstituentPwd::where('constituent_id', $this->id)->get()->first()->createdby ? ConstituentPwd::where('constituent_id', $this->id)->get()->first()->createdBy->name : '') : '',
        ];
    }
}
