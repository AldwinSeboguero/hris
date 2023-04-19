<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request as RS;
use App\Models\Constituent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Query\Builder;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Sitio;
use DB;
use App\Models\Barangay;
use App\Http\Resources\SeniorCitizenCollection;
use App\Http\Resources\ConstituentSeniorCollection;
use App\Models\PensionType;
use App\Models\ConstituentPensiontype;
use App\Models\ConstituentSeniorcitizen;
use App\Models\SeniorCitizenAge;
use App\Models\ConstituentPwd;



class DashboardController extends Controller
{
    //
    public function getSeniorCount(RS $request){
        return response()->json([
            'total_senior' => Constituent::orderBy('birthdate')
             ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )
            ->paginate(5)->total(),],200);
    }
    public function getSeniorRegisteredCount(RS $request){
        return response()->json([
            'total_senior_registered' => Constituent::orderBy('birthdate')
              ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->paginate()->total()
        ],200);
    }
    public function getSeniorMaleCount(RS $request){
        return response()->json([
            'total_senior_male' => Constituent::orderBy('birthdate')
            ->where('sex','male') 
            ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
            ->paginate()->total()
        ],200);
    }
    public function getSeniorFemaleCount(RS $request){
        return response()->json([
        'total_senior_female' => Constituent::orderBy('birthdate')
        ->where('sex','female') 
        ->whereHas(
            'characteristic', function ($q) {
                $q->where('pwd', true);
            }
        )->withCount('pwds')->having('pwds_count','>',0)
        ->paginate()->total()
        ],200);
    }

    public function getSeniorPensionerCount(RS $request){
        return response()->json([
            'pensioners' => PensionType::orderBy('id')->get()->map(
                function($inner){
                    return [
                        'code' => $inner->code,
                        'name' => $inner->name,
                        'member_count' => ConstituentPensiontype::where('pension_type_id',$inner->id)->paginate(5)->total(),
                        'logo' => "images/pension/".$inner->id.".png",
                    ];
                }
            )
        ],200);
    }
    public function getRecentlyRegistered(RS $request){
        return response()->json([
            'recently_registered' => new ConstituentSeniorCollection(ConstituentPwd::orderByDesc('created_at')
          
            ->paginate(5))
        ],200);
    }
    public function getSeniorByAge(RS $request){
        if ($request->age==101) {
            return response()->json([
                'male' =>  Constituent::orderBy('birthdate')->whereRaw( 'timestampdiff(year, birthdate, curdate()) > ?', [100] )
                ->whereHas(
                    'characteristic', function ($q) {
                        $q->where('pwd', true);
                    }
                )->withCount('pwds')->having('pwds_count','>',0)->paginate(5)->total(),
                // 'female' =>  Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) > ?', [100]  )->paginate(5)->total(),
    
            ],200);
        }
        else{
            return response()->json([
                'male' =>  Constituent::orderBy('birthdate')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', $request->age )
                ->whereHas(
                    'characteristic', function ($q) {
                        $q->where('pwd', true);
                    }
                )->withCount('pwds')->having('pwds_count','>',0)->paginate(5)->total(),
                // 'female' =>  Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', $request->age  )->paginate(5)->total(),
    
            ],200);
        }
       
    }
    
    public function index(){

        return Inertia::render('Dashboard',[
            // 'total_senior' => Constituent::orderBy('birthdate')
            // ->whereHas(
            //     'characteristic', function ($q) {
            //         $q->where('pwd', true);
            //     }
            // )->paginate()->total(),
            // // 'total_senior_registered' => Constituent::orderBy('birthdate')
            // // ->whereHas(
            //     'characteristic', function ($q) {
            //         $q->where('pwd', true);
            //     }
            // )->withCount('pwds')->having('pwds_count','>',0)->paginate()->total(),
            // // 'total_senior_male' => Constituent::orderBy('birthdate')
            // // ->where('sex','male')->whereHas(
            //     'characteristic', function ($q) {
            //         $q->where('pwd', true);
            //     }
            // )->paginate()->total(),
            // // 'total_senior_female' => Constituent::orderBy('birthdate')
            // // ->where('sex','female')->whereHas(
            //     'characteristic', function ($q) {
            //         $q->where('pwd', true);
            //     }
            // )->paginate()->total(),
            // 'pensioners' => PensionType::orderBy('id')->get()->map(
            //     function($inner){
            //         return [
            //             'code' => $inner->code,
            //             'name' => $inner->name,
            //             'member_count' => SeniorcitizenPensiontype::where('pension_type_id',$inner->id)->paginate(5)->total(),
            //             'logo' => "images/pension/".$inner->id.".png",
            //         ];
            //     }
            // ),
            // 'senior_by_age_male' => SeniorCitizenAge::orderBy('id')->get()->map(
            //     function($inner){
            //         if($inner->age != ">100"){
            //             return 
            //                 Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [$inner->age] )->paginate(5)->total()
            //             ;
            //         }
            //         else{
            //             return 
            //                 Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) > ?', [100] )->paginate(5)->total()
            //             ;
            //         }
                    
            //     }
            // ),
            // 'senior_by_age_female' => SeniorCitizenAge::orderBy('id')->get()->map(
            //     function($inner){
            //         if($inner->age == ">100"){
            //             return 
            //                 Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [$inner->age] )->paginate(5)->total()
            //             ;
            //         }
            //         else{
            //             return 
            //                 Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) > ?', [100] )->paginate(5)->total()
            //             ;
            //         }
                    
            //     }
            // ),
            // 'groupBy' =>  Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) > ?', [60] )->get()->groupBy('age'),
            
            // 'senior_by_age_male' => [
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [60] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [61] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [62] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [63] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [64] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [65] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [66] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [67] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [68] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [69] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [70] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [71] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [71] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [73] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [74] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [75] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [76] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [77] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [78] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [79] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [80] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [81] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [82] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [83] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [84] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [85] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [86] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [87] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [88] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [89] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [90] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [91] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [92] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [93] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [94] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [95] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [96] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [97] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [98] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [99] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [100] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) > ?', [100] )->paginate(5)->total(),
            // ],
            // 'senior_by_age_female' => [
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [60] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [61] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [62] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [63] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [64] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [65] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [66] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [67] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [68] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [69] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [70] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [71] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [71] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [73] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [74] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [75] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [76] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [77] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [78] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [79] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [80] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [81] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [82] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [83] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [84] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [85] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [86] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [87] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [88] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [89] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [90] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [91] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [92] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [93] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [94] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [95] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [96] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [97] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [98] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [99] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) = ?', [100] )->paginate(5)->total(),
            //     Constituent::orderBy('birthdate')->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) > ?', [100] )->paginate(5)->total(),
            // ],
            
        ]);
    }
    public function getSeniorLastPage(){
        return response()->json([
            'last_page' => Constituent::orderBy('birthdate')
             ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->paginate(100)->lastPage(),],200);
    }
    public function getSenior(){
        return response()->json([
            'senior' => Constituent::orderBy('birthdate')
             ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->paginate(100),],200);
    }
}
