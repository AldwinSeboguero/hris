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

class ConstituentController extends Controller
{
    public function index(){

        return Inertia::render('Constituent/Index', [
            'barangays' =>  Barangay::orderBy('id')->get(),
           'totalSenior' => Constituent::orderBy('birthdate')
           ->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] )->paginate(5)->total(),
           'totalSeniorMale' => Constituent::orderBy('birthdate')
           ->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] )->paginate(5)->total(),
           'totalSeniorFemale' => Constituent::orderBy('birthdate')
           ->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] )->paginate(5)->total(),

            'total' => Constituent::orderBy('birthdate')->paginate(5)->total(),
            'totalMale' => Constituent::orderBy('birthdate')->where('sex','male')->paginate(5)->total(),
            'totalFemale' => Constituent::orderBy('birthdate')->where('sex','female')->paginate(5)->total(),

            'totalSeniorUpcoming' => Constituent::orderBy('birthdate')
            ->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [59] )->paginate(5)->total(),
            'totalSeniorUpcomingFemale' => Constituent::orderBy('birthdate')
            ->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [59] )->paginate(5)->total(),
            'totalSeniorUpcomingMale' => Constituent::orderBy('birthdate')
            ->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [59] )->paginate(5)->total(),

            'totalSeniorSexagenarian' => Constituent::orderBy('birthdate')
            ->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [60,69] )->paginate(5)->total(),
            'totalSeniorSexagenarianMale' => Constituent::orderBy('birthdate')
            ->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [60,69] )->paginate(5)->total(),
            'totalSeniorSexagenarianFemale' => Constituent::orderBy('birthdate')
            ->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [60,69] )->paginate(5)->total(),

            'totalSeniorSeptuagenarian' => Constituent::orderBy('birthdate')
            ->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [70,79] )->paginate(5)->total(),
            'totalSeniorSeptuagenarianFemale' => Constituent::orderBy('birthdate')
            ->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [70,79] )->paginate(5)->total(),
            'totalSeniorSeptuagenarianMale' => Constituent::orderBy('birthdate')
            ->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [70,79] )->paginate(5)->total(),

            'totalSeniorOctogenarian' => Constituent::orderBy('birthdate')
            ->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [80,89] )->paginate(5)->total(),
            'totalSeniorOctogenarianMale' => Constituent::orderBy('birthdate')
            ->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [80,89] )->paginate(5)->total(),
            'totalSeniorOctogenarianFemale' => Constituent::orderBy('birthdate')
            ->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [80,89] )->paginate(5)->total(),

            'totalSeniorNonagenarian' => Constituent::orderBy('birthdate')
            ->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [90,99] )->paginate(5)->total(),
            'totalSeniorNonagenarianFemale' => Constituent::orderBy('birthdate')
            ->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [90,99] )->paginate(5)->total(),
            'totalSeniorNonagenarianMale' => Constituent::orderBy('birthdate')
            ->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [90,99] )->paginate(5)->total(),

            'totalSeniorCentenarian' => Constituent::orderBy('birthdate')
            ->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [100,109] )->paginate(5)->total(),
            'totalSeniorCentenarianMale' => Constituent::orderBy('birthdate')
            ->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [100,109] )->paginate(5)->total(),
            'totalSeniorCentenarianFemale' => Constituent::orderBy('birthdate')
            ->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [100,109] )->paginate(5)->total(),

            'totalSeniorSupercentenarian' => Constituent::orderBy('birthdate')
            ->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [110] )->paginate(5)->total(),
            'totalSeniorSupercentenarianFemale' => Constituent::orderBy('birthdate')
            ->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [110] )->paginate(5)->total(),
            'totalSeniorSupercentenarianMale' => Constituent::orderBy('birthdate')
            ->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [110] )->paginate(5)->total(),
            
        ]);
    }
    public function getSenior(RS $request){
        
            return response()->json([
                'count' =>  Constituent::orderBy('birthdate')->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] )
                ->whereHas(
                    'household.hhinfo.location', function ($q) use ($request) {
                        $q ->where('barangay_id', $request->barangay);
                    }
                )->paginate(5)->total(),
            ],200);
        
       
    }
    public function getUpcoming(RS $request){
        
        return response()->json([
            'count' =>  Constituent::orderBy('birthdate')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [59] )
            ->whereHas(
                'household.hhinfo.location', function ($q) use ($request) {
                    $q ->where('barangay_id', $request->barangay);
                }
            )
            ->paginate(5)->total(),
        ],200);
    
    
    }
    public function getSexagenarian(RS $request){
            
        return response()->json([
            'count' =>  Constituent::orderBy('birthdate')->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [60,69] )
            ->whereHas(
                'household.hhinfo.location', function ($q) use ($request) {
                    $q ->where('barangay_id', $request->barangay);
                }
            )
            ->paginate(5)->total(),
        ],200);


    }
    public function getSeptuagenarian(RS $request){
            
        return response()->json([
            'count' =>  Constituent::orderBy('birthdate')->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [70,79] )
            ->whereHas(
                'household.hhinfo.location', function ($q) use ($request) {
                    $q ->where('barangay_id', $request->barangay);
                }
            )
            ->paginate(5)->total(),
        ],200);


    }

    public function getOctogenarian(RS $request){
            
        return response()->json([
            'count' =>  Constituent::orderBy('birthdate')->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [80,89] )
            ->whereHas(
                'household.hhinfo.location', function ($q) use ($request) {
                    $q ->where('barangay_id', $request->barangay);
                }
            )
            ->paginate(5)->total(),
        ],200);


    }
    public function getNonagenarian(RS $request){

        return response()->json([
            'count' =>  Constituent::orderBy('birthdate')->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [90,99] )
            ->whereHas(
                'household.hhinfo.location', function ($q) use ($request) {
                    $q ->where('barangay_id', $request->barangay);
                }
            )
            ->paginate(5)->total(),
        ],200);


    }
    public function getCentenarian(RS $request){

        return response()->json([
            'count' =>  Constituent::orderBy('birthdate')->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [100,109] )
            ->whereHas(
                'household.hhinfo.location', function ($q) use ($request) {
                    $q ->where('barangay_id', $request->barangay);
                }
            )
            ->paginate(5)->total(),
        ],200);


    }
    public function getSupercentenarian(RS $request){

        return response()->json([
            'count' =>  Constituent::orderBy('birthdate')->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [110] )
            ->whereHas(
                'household.hhinfo.location', function ($q) use ($request) {
                    $q ->where('barangay_id', $request->barangay);
                }
            )
            ->paginate(5)->total(),
        ],200);


    }

}
