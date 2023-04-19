<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barangay;
class BarangayController extends Controller
{
    public function getBarangayName(Request $request){
        return response()->json([
            'barangay' => Barangay::query()
            ->where('id', $request->barangay)
            ->get()->map(
                function ($inner) {
                    return [ 
                    'id' => $inner->id,
                    'name' => $inner->name,
                    ];
                }
            ),
            ],200);
    }
}
