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
use App\Models\PensionType;
use Illuminate\Support\Str;
use PDF;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr; 
use App\Models\ConstituentSeniorCitizen;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Appliedleafe;
use App\Models\Department;
use App\Models\Division;
use App\Models\Holiday;



use App\Http\Resources\EmployeeCollection;
use Carbon\Carbon;




class AttendanceController extends Controller
{
    public function index(){   
       
       
        return Inertia::render('Attendance/Index2',[
            
        ]);
    }
    public function getDivisions(){
        // $divisions = Division::all();
        $divisions = Employee::select('division')
                ->distinct()
                ->orderBy('division', 'asc')
                ->pluck('division');


        return response()->json([
            'divisions' => $divisions,
            ],200);
    }
    public function show(RS $request)

    {
        // dd($request);
        $per_page =$request->per_page ? $request->per_page : 10;
        $search = $request->search;
        $emptype = $request->emptype;
        $empdivision = $request->empdivision;


        
        // dd( Arr::hasAny($pension, function ($value, $key) {
        //     return $value == "blank";
        // }));
        $employees = new EmployeeCollection(Employee::orderByDesc('updated_at')   
        ->when(
            $search, function ($query) use ($search) {
                $query->where(DB::raw("TRIM(CONCAT(lastname, ' ', firstname, ' ', COALESCE(middlename, ''))) "), 'LIKE', "%".$search."%");
            }
        )
        ->when(
            $emptype, function ($query) use ($emptype) {
                $query->where("emptype",$emptype);
            }
        )
        ->when(
            $empdivision, function ($query) use ($empdivision) {
                $query->where("division",$empdivision);
            }
        )
        ->paginate($per_page));
        return response()->json([
            'employees' => $employees,
            ],200);
    }

    public function pdf(RS $request){
        $data = [
            'title' => 'Welcome!',
            'date' => date('m/d/Y')
        ];
        $dtrDate = $request->dtrDate;


        $today = Carbon::now()->format('n/j/Y');
        $data = $request->data;
$employee = Employee::where('id', $data)->first();

$currentMonth = $dtrDate ? Carbon::create($dtrDate)->format('n') : Carbon::now()->month;
$currentYear = $dtrDate ? Carbon::create($dtrDate)->format('Y') : Carbon::now()->year;

$startDate = Carbon::create($currentYear, $currentMonth, 1)->format('Y-m-d');
$endDate = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth()->format('Y-m-d');
$endDate2 = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth()->format('j');


$attendance = Attendance::where('employeeno', $employee->employeeno)
                        ->whereBetween('dateko', [$startDate, $endDate])
                        ->get()->map(
                            function($inner){
                                return [
                                    'id' => $inner->id,
                                    'loginam' => $inner->loginam,
                                    'logoutam' => $inner->logoutam,
                                    'loginpm' => $inner->loginpm,
                                    'logoutpm' => $inner->logoutpm,
                                    'dateko' => $inner->dateko,
                                    'bypass' => $inner->bypass,
                                    'bypass1' => $inner->bypass1,
                                    'bypass2' => $inner->bypass2,
                                    'bypass3' => $inner->bypass3,
                                    'remarks' => $inner->remarks,



            
                                ];                
                            }
                        );
$days = [];
for ($day = 1; $day <= $endDate2; $day++) {
    $date = Carbon::create($currentYear, $currentMonth, $day);
    $log = $attendance->firstWhere('dateko', $date->format('Y-m-d'));

    $amin = '';
    $amout = '';
    $pmin = '';
    $pmout = '';
    $bypass = '';
    $bypass1 = '';
    $bypass2 = '';
    $bypass3 = '';
    $remarks = '';



    if ($log) {
        $amin = $log['loginam'];
        $amout = $log['logoutam'];
        $pmin = $log['loginpm'];
        $pmout = $log['logoutpm'];
        $bypass = $log['bypass'];
        $bypass1 = $log['bypass1'];
        $bypass2 = $log['bypass2'];
        $bypass3 = $log['bypass3'];
        $remarks = $log['remarks'];



        // dd($amin);

    }
    $days[] = [
        'date' => $day,
        'day' => $date->format('l'),
        'amin' => $amin,
        'amout' => $amout,
        'pmin' => $pmin,
        'pmout' => $pmout,
        'bypass' => $bypass,
        'bypass1' => $bypass1,
        'bypass2' => $bypass2,
        'bypass3' => $bypass3,
        'remarks' => $remarks,
        'isHolidayAM' => Holiday::where('holidate',$date)->get()->first() ? Holiday::where('holidate',$date)->get()->first()->holidayam : '',
        'isHolidayPM' => Holiday::where('holidate',$date)->get()->first() ? Holiday::where('holidate',$date)->get()->first()->holidaypm : '',


    ];

}
// dd($days);

        $month = $dtrDate ? Carbon::create($dtrDate)->format('F, Y'): Carbon::now()->format('F, Y');


        // dd($days);
        
        $pdf = PDF::loadView('pdf/dtr', compact(
            'today',
            'employee',
            'days',
            'currentMonth',
            'currentYear',
            'month'
        ))->setPaper('a4', 'portrait');
        // if($sitio){
    
        
        return $pdf->stream('dtr.pdf');
        // }
        // else{
        //     return response()->json([
        //         'isEmptySitio' => false],200); 
        // }
    }



   
}
