<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DisabilityType;
class DisabilitiesController extends Controller
{
    public function getDisabilities(){
        return response()->json([
            'disabilities' => DisabilityType::orderBy('id')->get()->map(
                function($inner){
                    return [
                        'id' => $inner->id,
                        'name' => $inner->name,
                        'code' => $inner->code,
                    ];
                }
            )->prepend(['id' => 'blank','name'=> '','code'=>'']),
        ],200);
    }
}
