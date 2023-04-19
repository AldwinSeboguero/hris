<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnnualIncome;
class AnnualIncomeController extends Controller
{
    public function getAnnualIncomes(){
        return response()->json([
            'annualincomes' => AnnualIncome::orderBy('id')->get()->map(
                function($inner){
                    return [
                        'id' => $inner->id,
                        'name' => $inner->name,

                    ];                
                }
            ),
        ],200);
    }
}
