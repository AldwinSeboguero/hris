<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sitio;
class SitioController extends Controller
{
    public function getSitioName(Request $request){
        return response()->json([
            'sitio' => Sitio::query()
            ->where('id', $request->sitio)
            ->get()->map(
                function ($inner) {
                    return [ 
                    'id' => $inner->id,
                    'name' => $inner->barangay->name.' - Sitio '.$inner->name,
                    ];
                }
            ),
            ],200);
    }
    public function getSitio(Request $request){
        if ($request->barangay) {
            return response()->json([
                'sitios' => Sitio::query()
                ->whereIn('barangay_id', $request->barangay)
                ->get()->map(
                    function ($inner) {
                        return [ 
                        'id' => $inner->id, 
                        'name' => $inner->barangay->name.' - Sitio '.$inner->name,
                        ];
                    }
                ),
                ],200);
        }
        else {
            return [];
        }
        
    }
}
