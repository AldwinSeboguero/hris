<?php

namespace App\Http\Controllers\SeniorCitizen;
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
use App\Models\CivilStatus;
use App\Models\BloodType;
use App\Models\ConstituentHealthCondition;
use App\Models\EducationalAttainment;
use App\Models\HealthCondition;
use App\Models\ConstituentSeniorCitizen;
use App\Models\ConstituentPwd;

use App\Models\PensionType;
use App\Models\DisabilityType;



class AddController extends Controller
{
  
    public function index(){
       
        $search = Request::input('search');

        return Inertia::render('SeniorCitizens/Add',[
            'civil_status' => CivilStatus::orderBy('id')->get(),
            'blood_types' => BloodType::orderBy('id')->get(),
            'disabilities' => DisabilityType::orderBy('id')->get()->map(
                function($inner){
                    return [
                        'id' => $inner->id,
                        'name' => $inner->name,
                        'code' => $inner->code,
                    ];
                }
            ),       
            'educational_attainments' => EducationalAttainment::orderBy('id')->get(),
            'health_conditions' => HealthCondition::orderBy('id')->get(),
            'seniorCitizens' => Constituent::orderBy('birthdate')
              ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->paginate()->total(),
            'seniorCitizensMale' => Constituent::orderBy('birthdate')
            ->where('sex','male')  ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->paginate()->total(),
            'seniorCitizensFemale' => Constituent::orderBy('birthdate')
            ->where('sex','female')  ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->paginate()->total(),
            'seniorCitizensUnknown' => Constituent::orderBy('birthdate')
            ->whereNull('sex')  ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)->paginate()->total(),
            'senior' => $search ? Constituent::orderBy('sex')->orderBy('birthdate')
             ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
            ->when( 
                $search, function ($query) use ($search) {
                    $query->where(DB::raw("CONCAT(surname, ' ', firstname, ' ', COALESCE(middlename, '')) "), 'LIKE', "%".$search."%")
                    ->orWhereHas(
                        'household.hhinfo', function ($q) use ($search) {
                            $q->where('hhcontrol_num', 'LIKE', "%".$search."%");
                        }
                    );
                }
            )
             ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count','>',0)
            ->withCount('seniors')->having('seniors_count','=',0)
            ->limit(5)->get()->map(function($inner){
                return [
                    'full_name' => $inner->full_name,
                    'hcn' => $inner->household->hhinfo->hhcontrol_num,
                    'surname' => $inner->surname,
                    'firstname' => $inner->firstname,
                    'middlename' => $inner->middlename,
                    'birthdate' => $inner->birthdate,
                    'sex' => $inner->sex,
                    'blood_type' => $inner->health->bloodtype ? $inner->health->bloodtype->id : '',
                    'civil_status' => $inner->characteristic ? ($inner->characteristic->civilstatus ? $inner->characteristic->civilstatus->id : '') : '',
                    'education_attainment' => $inner->education ? ($inner->education->educattainment ? $inner->education->educattainment->id : '') : '',
                    'occupation' => $inner->income ? ($inner->income->occupation ? $inner->income->occupation : '') : '',


                ];
            }) : [],
        ]);
    }
    public function searhNotRegisterSenior(RS $request){
        $search = $request->search;
        // dd($search);
        return response()->json([
            'senior' => $search ? Constituent::orderBy('sex')->orderBy('birthdate')
             ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )->withCount('pwds')->having('pwds_count',0)
            ->when( 
                $search, function ($query) use ($search) {
                    $query->where(DB::raw("CONCAT(surname, ' ', firstname, ' ', COALESCE(middlename, '')) "), 'LIKE', "%".$search."%")
                    ->orWhereHas(
                        'household.hhinfo', function ($q) use ($search) {
                            $q->where('hhcontrol_num', 'LIKE', "%".$search."%");
                        }
                    );
                }
            )
             ->whereHas(
                'characteristic', function ($q) {
                    $q->where('pwd', true);
                }
            )
            ->withCount('pwds')->having('pwds_count',0)
            ->limit(5)->get()->map(function($inner){
                return [
                    'id' => $inner->id,
                    'full_name' => $inner->full_name,
                    'hcn' => $inner->household->hhinfo->hhcontrol_num,
                    'surname' => $inner->surname,
                    'firstname' => $inner->firstname,
                    'middlename' => $inner->middlename,
                    'birthdate' => $inner->birthdate,
                    'sex' => $inner->sex,
                    'blood_type' => $inner->health->bloodtype ? $inner->health->bloodtype->id : '',
                    'weight' => $inner->health->weight ? $inner->health->weight.' kg' : '',
                    'height' => $inner->health->height ? $inner->health->height.' cm' : '',
                    'civil_status' => $inner->characteristic ? ($inner->characteristic->civilstatus ? $inner->characteristic->civilstatus->id : '') : '',
                    'education_attainment' => $inner->education ? ($inner->education->educattainment ? $inner->education->educattainment->id : '') : '',
                    'occupation' => $inner->income ? ($inner->income->occupation ? $inner->income->occupation : '') : '',
                    'address' => $inner->address,
                    'pensions' => $inner->pensions ? $inner->pensions->map(function($inner){ return $inner->id;}) : [],
                    'health_conditions' => ConstituentHealthCondition::where('constituent_id',$inner->id)->get('healthcondition_id'),
                ];
            }) : [],
        ]);

    }

    public function register(RS $request){
        //  dd($request->disabilities); 
        $registered = ConstituentPwd::where('constituent_id', $request->senior)->get();
        
        if($registered->count() == 0){
            ConstituentPwd::create([
                'constituent_id' => $request->senior,
                'pwd_id' => $request->pwd_id,
                'active' => true,
                'registered' => true,
                'createdby' => Auth::user()->id,

                
            ]);

           Constituent::find($request->senior)->disabilities()->detach(DisabilityType::get('id'));
           Constituent::find($request->senior)->disabilities()->attach($request->disabilities);
        return redirect()->route('senior_citizens.registered')->with('success', Constituent::where("id",$request->senior)->first()->full_name.' is now officially registered.');

        }
    }
   
}


