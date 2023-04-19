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

class HealthController extends Controller
{
    public function index(){

        return Inertia::render('Health/Index', [
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
          
           'totalSeniorDeath' => Constituent::orderBy('birthdate')
            ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->withCount('death')->having('death_count','>','0')->paginate(5)->total(),
           'totalSeniorDeathMale' => Constituent::orderBy('birthdate')
           ->where('sex','male') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->withCount('death')->having('death_count','>','0')->paginate(5)->total(),
           'totalSeniorDeathFemale' => Constituent::orderBy('birthdate')
           ->where('sex','female') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->withCount('death')->having('death_count','>','0')->paginate(5)->total(),
           
           'totalSeniorPWD' => Constituent::orderBy('birthdate')
            ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas(
                'characteristic', function ($q) {
                    $q ->where('pwd', true);
                }
            )->paginate(5)->total(),
           'totalSeniorPWDMale' => Constituent::orderBy('birthdate')
           ->where('sex','male') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas(
                'characteristic', function ($q) {
                    $q ->where('pwd', true);
                }
            )->paginate(5)->total(),
           'totalSeniorPWDFemale' => Constituent::orderBy('birthdate')
           ->where('sex','female') ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->whereHas(
                'characteristic', function ($q) {
                    $q ->where('pwd', true);
                }
            )->paginate(5)->total(),
           
            
        ]);
    }
    public function getMortality(RS $request){
        
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
                )->withCount('death')->having('death_count','>','0')->paginate(5)->total(),
                // 'female' =>  Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) > ?', [100]  )->paginate(5)->total(),
    
            ],200);
        
       
    }
    public function getPWD(RS $request){
        
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
            ->whereHas(
                'characteristic', function ($q) use ($request) {
                    $q ->where('pwd', true);
                }
            )->paginate(5)->total(),
            // 'female' =>  Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) > ?', [100]  )->paginate(5)->total(),

        ],200);
    
   
}
}
