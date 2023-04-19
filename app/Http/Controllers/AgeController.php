<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Constituent;
class AgeController extends Controller
{
    public function getMaxAge(){
        return response()->json([
            'max_age' => Constituent::orderBy('birthdate')->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] )->first()->age,
            ],200);
    }
}
