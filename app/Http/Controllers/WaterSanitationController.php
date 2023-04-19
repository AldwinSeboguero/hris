<?php

namespace App\Http\Controllers;

use App\Models\HouseholdInformation;
use App\Models\HouseholdDeathList as HouseholdDeath;
use App\Models\HouseholdMember;
use App\Models\HouseholdHousing;
use App\Models\HouseholdLocation;
use App\Models\ConstituentVoter;
use App\Models\ConstituentCharacteristics;
use App\Models\ConstituentEducation;
use App\Models\ConstituentEconomicActivity;
use App\Models\Constituent;
use App\Models\CivilStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Query\Builder;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Statistics;
use App\Models\Barangay;
use App\Models\Sitio;
use App\Models\DeathCause;
use DB;
use App\Models\Pregnant;
use App\Models\Mortality;
use Illuminate\Http\Request as RS;

class WaterSanitationController extends Controller
{
    public function index(){

        return Inertia::render('WaterSanitation/Index', [
            'barangays' =>  Barangay::orderBy('id')->get(),
           'totalSenior' => Constituent::orderBy('birthdate')
            ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->paginate(5)->total(),
           'totalSeniorMale' => Constituent::orderBy('birthdate')
           ->where('sex','male') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->paginate(5)->total(),
           'totalSeniorFemale' => Constituent::orderBy('birthdate')
           ->where('sex','female') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->paginate(5)->total(),
           'totalSeniorWithAccessToWater' =>Constituent::orderBy('birthdate')
            ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.hhinfo.sanitation',function($q){
                        $q->whereIn( 'watersource_id', [1]);
                    })->paginate(5)->total(),
           'totalSeniorWithAccessToWaterFemale' =>Constituent::orderBy('birthdate')
            ->where('sex','female') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.hhinfo.sanitation',function($q){
                        $q->whereIn( 'watersource_id', [1]);
                    })->paginate(5)->total(),
           'totalSeniorWithAccessToWaterMale' =>Constituent::orderBy('birthdate')
            ->where('sex','male') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.hhinfo.sanitation',function($q){
                        $q->whereIn( 'watersource_id', [1]);
                    })->paginate(5)->total(),
           'totalSeniorWithAccessToSanitaryToilet' =>Constituent::orderBy('birthdate')
            ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.hhinfo.sanitation',function($q){
                        $q->where( 'access_sanitarytoilet', true);
                    })->paginate(5)->total(),
           'totalSeniorWithAccessToSanitaryToiletMale' =>Constituent::orderBy('birthdate')
            ->where('sex','male') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.hhinfo.sanitation',function($q){
                        $q->where( 'access_sanitarytoilet', true);
                    })->paginate(5)->total(),
           'totalSeniorWithAccessToSanitaryToiletFemale' =>Constituent::orderBy('birthdate')
            ->where('sex','female') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.hhinfo.sanitation',function($q){
                        $q->where( 'access_sanitarytoilet', true);
                    })->paginate(5)->total(),
           'totalSeniorWithoutAccessToWater' =>Constituent::orderBy('birthdate')
            ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.hhinfo.sanitation',function($q){
                        $q->where( 'watersource_id', '!=', 1);
                    })->paginate(5)->total(),
           'totalSeniorWithoutAccessToWaterFemale' =>Constituent::orderBy('birthdate')
            ->where('sex','female') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.hhinfo.sanitation',function($q){
                        $q->where( 'watersource_id', '!=', 1);
                    })->paginate(5)->total(),
           'totalSeniorWithoutAccessToWaterMale' =>Constituent::orderBy('birthdate')
            ->where('sex','male') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.hhinfo.sanitation',function($q){
                        $q->where( 'watersource_id', '!=', 1);
                    })->paginate(5)->total(),
           'totalSeniorWithoutAccessToSanitaryToilet' =>Constituent::orderBy('birthdate')
            ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.hhinfo.sanitation',function($q){
                        $q->where( 'access_sanitarytoilet', false);
                    })->paginate(5)->total(),
           'totalSeniorWithoutAccessToSanitaryToiletMale' =>Constituent::orderBy('birthdate')
            ->where('sex','male') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.hhinfo.sanitation',function($q){
                        $q->where( 'access_sanitarytoilet', false);
                    })->paginate(5)->total(),
           'totalSeniorWithoutAccessToSanitaryToiletFemale' =>Constituent::orderBy('birthdate')
            ->where('sex','female') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.hhinfo.sanitation',function($q){
                        $q->where( 'access_sanitarytoilet', false);
                    })->paginate(5)->total(),
            
        ]);
    }
    public function getWithAccessToWater(RS $request){
        
            return response()->json([
                'count' =>  Constituent::orderBy('birthdate') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
                ->whereHas(
                    'household.hhinfo.location', function ($q) use ($request) {
                        $q ->where('barangay_id', $request->barangay);
                    }
                )
                ->whereHas('household.hhinfo.sanitation',function($q){
                    $q->whereIn( 'watersource_id', [1]);
                })->paginate(5)->total(),
            ],200);
        
       
    }
    public function getWithAccessToSanitaryToilet(RS $request){
        
        return response()->json([
            'count' =>  Constituent::orderBy('birthdate') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
            ->whereHas(
                'household.hhinfo.location', function ($q) use ($request) {
                    $q ->where('barangay_id', $request->barangay);
                }
            )
            ->whereHas('household.hhinfo.sanitation',function($q){
                $q->where( 'access_sanitarytoilet', true);
            })->paginate(5)->total(),
        ],200);
    
   
}
public function getWithoutAccessToWater(RS $request){
        
    return response()->json([
        'count' =>  Constituent::orderBy('birthdate') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
        ->whereHas(
            'household.hhinfo.location', function ($q) use ($request) {
                $q ->where('barangay_id', $request->barangay);
            }
        )
        ->whereHas('household.hhinfo.sanitation',function($q){
            $q->where( 'watersource_id', '!=', 1);
        })->paginate(5)->total(),
    ],200);


}
public function getWithoutAccessToSanitaryToilet(RS $request){
        
    return response()->json([
        'count' =>  Constituent::orderBy('birthdate') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
        ->whereHas(
            'household.hhinfo.location', function ($q) use ($request) {
                $q ->where('barangay_id', $request->barangay);
            }
        )
        ->whereHas('household.hhinfo.sanitation',function($q){
            $q->where( 'access_sanitarytoilet', false);
        })->paginate(5)->total(),
    ],200);


}
}
