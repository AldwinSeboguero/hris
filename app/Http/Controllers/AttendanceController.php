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
use App\Http\Resources\EmployeeCollection;
use Carbon\Carbon;



class AttendanceController extends Controller
{
    public function index(){   
       
       
        return Inertia::render('Attendance/Index2',[
            
        ]);
    }
    public function show(RS $request)

    {
        // dd($request);
        $per_page =$request->per_page ? $request->per_page : 10;
        $search = $request->search;
        $emptype = $request->emptype;

        
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
                $query->where("emptype", 'LIKE', "%".$emptype."%");
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
        $employee = Employee::where('id', $data)->get()->first();

       
        $currentMonth = $dtrDate ? Carbon::create($dtrDate)->format('n') :  Carbon::now()->month;
        $currentYear = $dtrDate ? Carbon::create($dtrDate)->format('Y') : Carbon::now()->year;

        $daysInMonth = Carbon::create($currentYear, $currentMonth, 1)->daysInMonth;

        $days = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($currentYear, $currentMonth, $day);
            $days[] = 
              [  'date' => $day,
                'day' => $date->format('l')
        ];
            // $date->format('l');
        }
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
