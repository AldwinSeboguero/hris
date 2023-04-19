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

class EmploymentController extends Controller
{
    public function index(){

        return Inertia::render('Employment/Index', [
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
           'totalSeniorEmployed' =>Constituent::orderBy('birthdate')
            ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.incomes', function($q){
                   $q->where( 'employed', true);
               })->paginate(5)->total(),
           'totalSeniorEmployedFemale' =>Constituent::orderBy('birthdate')
            ->where('sex','female') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.incomes', function($q){
                   $q->where( 'employed', true);
               })->paginate(5)->total(),
           'totalSeniorEmployedMale' =>Constituent::orderBy('birthdate')
            ->where('sex','male') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.incomes', function($q){
                   $q->where( 'employed', true);
               })->paginate(5)->total(),
           'totalSeniorUnemployed' =>Constituent::orderBy('birthdate')
            ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.incomes', function($q){
                   $q->where( 'employed', false)->where('occupation',null);
               })->paginate(5)->total(),
           'totalSeniorUnemployedMale' =>Constituent::orderBy('birthdate')
            ->where('sex','male') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.incomes', function($q){
                   $q->where( 'employed', false)->where('occupation',null);
               })->paginate(5)->total(),
           'totalSeniorUnemployedFemale' =>Constituent::orderBy('birthdate')
            ->where('sex','female') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.incomes', function($q){
                   $q->where( 'employed', false)->where('occupation',null);
               })->paginate(5)->total(),
           'totalSeniorSelfEmployed' =>Constituent::orderBy('birthdate')
            ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0) ->whereHas('household.incomes', function($q){
                            $q->whereIn( 'employed', [false,null])->where('occupation','!=',null);
                        })->paginate(5)->total(),
           'totalSeniorSelfEmployedFemale' =>Constituent::orderBy('birthdate')
            ->where('sex','female') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0) ->whereHas('household.incomes', function($q){
                            $q->whereIn( 'employed', [false,null])->where('occupation','!=',null);
                        })->paginate(5)->total(),
           'totalSeniorSelfEmployedMale' =>Constituent::orderBy('birthdate')
            ->where('sex','male') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0) ->whereHas('household.incomes', function($q){
                            $q->whereIn( 'employed', [false,null])->where('occupation','!=',null);
                        })->paginate(5)->total(),
           'totalSeniorOverseasworker' =>Constituent::orderBy('birthdate')
            ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.characteristic', function($q){
                   $q->where( 'overseasworker', true);
               })->paginate(5)->total(),
           'totalSeniorOverseasworkerMale' =>Constituent::orderBy('birthdate')
            ->where('sex','male') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.characteristic', function($q){
                   $q->where( 'overseasworker', true);
               })->paginate(5)->total(),
           'totalSeniorOverseasworkerFemale' =>Constituent::orderBy('birthdate')
            ->where('sex','female') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas('household.characteristic', function($q){
                   $q->where( 'overseasworker', true);
               })->paginate(5)->total(),
            
        ]);
    }
    public function getEmployed(RS $request){
        
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
                ->whereHas('household.incomes', function($q){
                    $q->where( 'employed', true);
                })->paginate(5)->total(),
            ],200);
        
       
    }
    public function getUnemployed(RS $request){
        
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
            ->whereHas('household.incomes', function($q){
                $q->where( 'employed', false)->where('occupation',null);
            })->paginate(5)->total(),
        ],200);
    
   
}
public function getSelfEmployed(RS $request){
        
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
        ->whereHas('household.incomes', function($q){
            $q->whereIn( 'employed', [false,null])->where('occupation','!=',null);
        })->paginate(5)->total(),
    ],200);


}
public function getOverseasWorker(RS $request){
        
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
        ->whereHas('household.characteristic', function($q){
            $q->where( 'overseasworker', true);
        })->paginate(5)->total(),
    ],200);


}
}
