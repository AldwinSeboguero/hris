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

class HousingController extends Controller
{
    public function index(){

        return Inertia::render('Housing/Index', [
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
          
           'totalSeniorInformalSettler' => Constituent::orderBy('birthdate')
            ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
           ->whereHas('household.hhinfo.housing',function($q){
            $q->where('informalsettler', true);
             })->paginate(5)->total(),
           'totalSeniorInformalSettlerMale' => Constituent::orderBy('birthdate')
           ->where('sex','male') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
           ->whereHas('household.hhinfo.housing',function($q){
            $q->where('informalsettler', true);
             })
            ->paginate(5)->total(),
           'totalSeniorInformalSettlerFemale' => Constituent::orderBy('birthdate')
           ->where('sex','female') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
           ->whereHas('household.hhinfo.housing',function($q){
            $q->where('informalsettler', true);
             })
             ->paginate(5)->total(),
           
           'totalSeniorMakeshiftHousing' => Constituent::orderBy('birthdate')
            ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
            ->whereHas('household.hhinfo.housing',function($q){
                $q->where('lightmaterial', true);
                 })->paginate(5)->total(),
           'totalSeniorMakeshiftHousingMale' => Constituent::orderBy('birthdate')
           ->where('sex','male') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
            ->whereHas('household.hhinfo.housing',function($q){
                $q->where('lightmaterial', true);
                 })->paginate(5)->total(),
           'totalSeniorMakeshiftHousingFemale' => Constituent::orderBy('birthdate')
           ->where('sex','female') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
            ->whereHas('household.hhinfo.housing',function($q){
                $q->where('lightmaterial', true);
                 })->paginate(5)->total(),

            'totalSeniorHPA' => Constituent::orderBy('birthdate')
             ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
            ->whereHas('household.hhinfo.housing',function($q){
                $q->where('hazardpronearea', true);
                })->paginate(5)->total(),
            'totalSeniorHPAMale' => Constituent::orderBy('birthdate')
            ->where('sex','male') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
            ->whereHas('household.hhinfo.housing',function($q){
                $q->where('hazardpronearea', true);
                })->paginate(5)->total(),
            'totalSeniorHPAFemale' => Constituent::orderBy('birthdate')
            ->where('sex','female') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
            ->whereHas('household.hhinfo.housing',function($q){
                $q->where('hazardpronearea', true);
                })->paginate(5)->total(),
           
            
        ]);
    }
    public function getInformalSettler(RS $request){
        
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
                ->whereHas('household.hhinfo.housing',function($q){
                    $q->where('informalsettler', true);
                    })->paginate(5)->total(),
                // 'female' =>  Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) > ?', [100]  )->paginate(5)->total(),
    
            ],200);
        
       
    }
    public function getMakeshiftHousing(RS $request){
        
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
            ->whereHas('household.hhinfo.housing',function($q){
                $q->where('lightmaterial', true);
                })->paginate(5)->total(),
            // 'female' =>  Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) > ?', [100]  )->paginate(5)->total(),

        ],200);
    
   
}
public function getHPA(RS $request){
        
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
        ->whereHas('household.hhinfo.housing',function($q){
            $q->where('hazardpronearea', true);
            })->paginate(5)->total(),
        // 'female' =>  Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) > ?', [100]  )->paginate(5)->total(),

    ],200);


}
}
