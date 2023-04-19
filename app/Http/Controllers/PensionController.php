<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PensionType;
class PensionController extends Controller
{
    public function getPensions(){
        return response()->json([
            'pensions' => PensionType::orderBy('id')->get()->map(
                function($inner){
                    return [
                        'id' => $inner->id,
                        'name' => $inner->name,
                        'code' => $inner->code,
                        'logo' => "../../images/pension/".$inner->id.".png",
                    ];
                }
            )->prepend(['id' => 'blank','name'=> '','code'=>'','logo'=>'']),
        ],200);
    }
}
