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

class IncomeController extends Controller
{
    public function index(){

        return Inertia::render('Income/Index', [
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
          
           'totalSeniorBelowPoverty' => Constituent::orderBy('birthdate')
            ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
           ->whereHas('household.hhinfo.hhincome',function($q){
            $q->where('tothousehold_income','<=',144000);
            })->paginate(5)->total(),
           'totalSeniorBelowPovertyMale' => Constituent::orderBy('birthdate')
           ->where('sex','male') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
           ->whereHas('household.hhinfo.hhincome',function($q){
            $q->where('tothousehold_income','<=',144000);
            })->paginate(5)->total(),
           'totalSeniorBelowPovertyFemale' => Constituent::orderBy('birthdate')
           ->where('sex','female') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
           ->whereHas('household.hhinfo.hhincome',function($q){
            $q->where('tothousehold_income','<=',144000);
            })->paginate(5)->total(),
           
           'totalSeniorBelowFood' => Constituent::orderBy('birthdate')
            ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
            ->whereHas('household.hhinfo.hhincome',function($q){
                $q->where('tothousehold_income','<=',75000);
                })->paginate(5)->total(),
           'totalSeniorBelowFoodMale' => Constituent::orderBy('birthdate')
           ->where('sex','male') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
            ->whereHas('household.hhinfo.hhincome',function($q){
                $q->where('tothousehold_income','<=',75000);
                })->paginate(5)->total(),
           'totalSeniorBelowFoodFemale' => Constituent::orderBy('birthdate')
           ->where('sex','female') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
            ->whereHas('household.hhinfo.hhincome',function($q){
                $q->where('tothousehold_income','<=',75000);
                })->paginate(5)->total(),
           
            
        ]);
    }
    public function getBelowPoverty(RS $request){
        
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
                ->whereHas('household.hhinfo.hhincome',function($q){
                    $q->where('tothousehold_income','<=',144000);
                    })->paginate(5)->total(),
                // 'female' =>  Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) > ?', [100]  )->paginate(5)->total(),
    
            ],200);
        
       
    }
    public function getBelowFood(RS $request){
        
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
            ->whereHas('household.hhinfo.hhincome',function($q){
                $q->where('tothousehold_income','<=',75000);
                })->paginate(5)->total(),
            // 'female' =>  Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) > ?', [100]  )->paginate(5)->total(),

        ],200);
    
   
}
}
