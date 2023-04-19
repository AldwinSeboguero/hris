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
use Carbon\Carbon;
use App\Models\PensionType;
class ViewController extends Controller
{
    public function index(){
       
        $search = Request::input('senior');
        // dd($senior);
        return Inertia::render('SeniorCitizens/View',[
            'pensions' => PensionType::orderBy('id')->get()->map(function($inner){ 
                return [
                    "logo" =>"images/pension/".$inner->id.".png", 
                    "code" => $inner->code,
                    "id" => $inner->id,
                ];}),  
            'civil_status' => CivilStatus::orderBy('id')->get(),
            'blood_types' => BloodType::orderBy('id')->get(),
            'educational_attainments' => EducationalAttainment::orderBy('id')->get(),
            'health_conditions' => HealthCondition::orderBy('id')->get(),
            'seniorCitizens' => Constituent::orderBy('birthdate')
            ->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] )->withCount('seniors')->having('seniors_count','>',0)->paginate()->total(),
            'seniorCitizensMale' => Constituent::orderBy('birthdate')
            ->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] )->withCount('seniors')->having('seniors_count','>',0)->paginate()->total(),
            'seniorCitizensFemale' => Constituent::orderBy('birthdate')
            ->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] )->withCount('seniors')->having('seniors_count','>',0)->paginate()->total(),
            'seniorCitizensUnknown' => Constituent::orderBy('birthdate')
            ->whereNull('sex')->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] )->withCount('seniors')->having('seniors_count','>',0)->paginate()->total(),
            'senior' => $search ? Constituent::orderBy('sex')->orderBy('birthdate')
            ->where('id',$search)->get()->map(function($inner){
                return [
                    'id' => $inner->id,
                    'full_name' => $inner->full_name,
                    'hcn' => $inner->household->hhinfo->hhcontrol_num,
                    'lastname' => $inner->surname,
                    'first_name' => $inner->firstname,
                    'middlename' => $inner->middlename,
                    'dob_date' => $inner->birthdate ? $inner->birthdate->toDateString() : '',
                    'sx' => $inner->sex,
                    'blood_type' => $inner->health->bloodtype ? $inner->health->bloodtype->id : '',
                    'weight' => $inner->health->weight ? $inner->health->weight.' kg' : '',
                    'height' => $inner->health->height ? $inner->health->height.' cm' : '',
                    'civil_status_id' => $inner->characteristic ? ($inner->characteristic->civilstatus ? $inner->characteristic->civilstatus->id : '') : '',
                    'education_attainment' => $inner->education ? ($inner->education->educattainment ? $inner->education->educattainment->id : '') : '',
                    'occupation' => $inner->income ? ($inner->income->occupation ? $inner->income->occupation : '') : '',
                    'address' => $inner->address,
                    'health_conditions' => ConstituentHealthCondition::where('constituent_id',$inner->id)->get('healthcondition_id'),
                    'pension' => $inner->pensions ? $inner->pensions->map(function($inner){ return $inner->id;}) : [],
                ];
            }) : [],
            'senior'
        ]);
    }
}
