<?php

namespace App\Http\Controllers\Pensioner;

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
use App\Models\ConstituentSeniorCitizen;

class PensionerController extends Controller
{
    public function index(){
       
        return Inertia::render('Pensioners/Index',[
            'barangays' =>  Barangay::orderBy('id')->get(),
            // 'sitios' =>  Sitio::orderBy('id')->get(),
            'max_age' => Constituent::orderBy('birthdate')->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] )->first()->age,
            'pensions' => PensionType::orderBy('id')->get()->map(
                function($inner){
                    return [
                        'id' => $inner->id,
                        'name' => $inner->name,
                        'code' => $inner->code,
                        'logo' => "../../images/pension/".$inner->id.".png",
                    ];
                }
            ),
            'seniorCitizens' => Constituent::orderBy('birthdate')
            ->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] )->withCount('pensions')->having('pensions_count','>',0)->paginate()->total(),
            'seniorCitizensMale' => Constituent::orderBy('birthdate')
            ->where('sex','male')->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] )->withCount('pensions')->having('pensions_count','>',0)->paginate()->total(),
            'seniorCitizensFemale' => Constituent::orderBy('birthdate')
            ->where('sex','female')->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] )->withCount('pensions')->having('pensions_count','>',0)->paginate()->total(),
            'seniorCitizensUnknown' => Constituent::orderBy('birthdate')
            ->whereNull('sex')->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] )->withCount('pensions')->having('pensions_count','>',0)->paginate()->total(),
            
        ]);
    }
    public function show(RS $request)
    {
        $per_page =$request->per_page ? $request->per_page : 10;
        $search = $request->search;
        $barangay = $request->barangay;
        $sitio = $request->sitio;
        $min = $request->min;
        $max = $request->max;
        $sx = $request->sx;
        $birthday = $request->birthday;
        $pension = $request->pension;
        $annualincome = $request->annualincome;
        $constituents = new SeniorCitizenCollection(Constituent::orderBy('sex')->orderBy('birthdate')
        ->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] )
        ->when(
            $search, function ($query, $search) use ($request) {
                $query->where(DB::raw("TRIM(CONCAT(surname, ' ', firstname, ' ', COALESCE(middlename, ''))) "), 'LIKE', "%".$search."%")
                ->orWhereHas(
                    'household.hhinfo', function ($q) use ($search) {
                        $q ->where('hhcontrol_num', 'LIKE', "%{$search}%");
                    }
                );
            }
        )
        ->when(
            $barangay, function ($query) use ($barangay) {
                $query->whereHas(
                    'household.location.barangay', function ($q) use ($barangay) {
                        $q ->whereIn('id', $barangay);
                    }
                );
            }
        )
        ->when(
            $sitio, function ($query) use ($sitio) {
                $query->whereHas(
                    'household.location.sitio', function ($q) use ($sitio) {
                        $q ->whereIn('id', $sitio);
                    }
                );
            }
        )
        ->when($sx, function($query) use($sx){
            $query->where('sex',Str::lower($sx));
        })
        ->when($birthday, function($query) use($birthday){
            $query->whereBetween('birthdate', $birthday);
        })
        ->when(
            $pension, function ($query) use ($pension) {
                $query->whereHas(
                    'pensions', function ($q) use ($pension) {
                        $q->whereIn('pension_type_id', $pension);
                    }
                );
            }
        )
        ->when(
            $annualincome, function ($query) use ($annualincome) {
                $query->whereHas(
                    'income', function ($q) use ($annualincome) {
                        $q->where('annualincome_id', $annualincome);
                    }
                );
            }
        )
        ->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [$min,$max] )
        ->withCount('pensions')->having('pensions_count','>',0)
        ->paginate($per_page));
        return response()->json([
            'constituents' => $constituents,
            'filtersBarangay' => array_map('intval', Request::input(['barangay'])?Request::input(['barangay']):[]),
            'filtersSitio' => array_map('intval', Request::input(['sitio'])?Request::input(['sitio']):[]),
            'barangays' => Barangay::orderBy('id')->get(),
            'sitios' => Sitio::query()
                ->when(
                    Request::input('barangay'), function ($query, $barangay) {
                        $query ->whereIn('barangay_id', $barangay);
                    }
                )
            ->get()->map(
                function ($inner) {
                    return [ 
                    'id' => $inner->id,
                    'name' => $inner->barangay->name.'-'.$inner->name,
                    ];
                }
            ),
            ],200);
    }
    public function pdf(RS $request){
        $data = [
            'title' => 'Welcome!',
            'date' => date('m/d/Y')
        ];

        $date = date('m/d/Y');
        $search = $request->search;
        $ageFrom = $request->ageFrom;
        $age = $request->age;
        $barangay = $request->barangay;
        $sitio = $request->sitio;
        $min = $request->min;
        $max = $request->max;
        $sx = $request->sx;
        $birthday = $request->birthday;
        $pension = $request->pension;
        $annualincome = $request->annualincome; 

        $sitios = Sitio::orderBy('id')
        ->when($barangay, function($query) use($barangay){
            $query->where('barangay_id',$barangay);
        })
        ->when($barangay == null && $sitio, function($query) use($sitio){
            $query->where('id',$sitio);
        })   
             
        ->get()->map(function($inner) use($search,$age,$request,$barangay,$sx,$birthday,$pension,$annualincome,$min,$max){
            $constituents = Constituent::orderBy('birthdate')
            ->whereHas(
                'household.hhinfo.location', function ($q) use ($inner) {
                    $q ->where('sitio_id', $inner->id);
                }
            )
            ->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] )
            ->when(
                $search, function ($query, $search) use ($request) {
                    $query->where(DB::raw("TRIM(CONCAT(surname, ' ', firstname, ' ', COALESCE(middlename, ''))) "), 'LIKE', "%".$search."%")
                    ->orWhereHas(
                        'household.hhinfo', function ($q) use ($search) {
                            $q ->where('hhcontrol_num', 'LIKE', "%{$search}%");
                        }
                    );
                }
            )
           
            ->when($sx, function($query) use($sx){
                $query->where('sex',Str::lower($sx));
            })
            ->when($birthday, function($query) use($birthday){
                $query->whereBetween('birthdate', $birthday);
            })
            ->when(
                $pension, function ($query) use ($pension) {
                    $query->whereHas(
                        'pensions', function ($q) use ($pension) {
                            $q->whereIn('pension_type_id', $pension);
                        }
                    );
                }
            )
            ->when(
                $annualincome, function ($query) use ($annualincome) {
                    $query->whereHas(
                        'income', function ($q) use ($annualincome) {
                            $q->where('annualincome_id', $annualincome);
                        }
                    );
                }
            )
            ->when($min && $max, function ($query) use ($min,$max) {
                $query->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [$min,$max] );
                 }

            )
            ->when($min==null && $max==null, function ($query) use ($min,$max) {
                $query->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] );
                 }

            )
            
            ->withCount('pensions')->having('pensions_count','>',0)
            ->get()
            ->map(function($inner){
                return [
                'name' => $inner->full_name,
                'hcn' => $inner->household->hhinfo->hhcontrol_num,
                'age' => $inner->age,
                'sex' => ucwords($inner->sex),
                'bday' => $inner->birthdate ? $inner->birthdate->toFormattedDateString() : '',
                ];
            });

            
            if($constituents->count() != 0){
                return [
                    'name' => $inner->name,
                    'barangay' => $inner->barangay->name,
                    'constituents' => $constituents,
        
                ];
            }
            else{
                return null;
            }
            
        })->filter(function ($value, $key) {
            return $value != null;
        });
        
        $pdf = PDF::loadView('pdf/pensioner-senior-citizen', compact(
            'date',
            'sitios'
        ))->setPaper('a4', 'landscape');
        // if($sitio){
        
        return $pdf->stream('pensioner-senior-citizen.pdf');
        // }
        // else{
        //     return response()->json([
        //         'isEmptySitio' => false],200); 
        // }
    }
    public function pensionersSeniorCount(RS $request){
       
        $search = $request->search;
        $ageFrom = $request->ageFrom;
        $age = $request->age;
        $barangay = $request->barangay;
        $sitio = $request->sitio;
        $min = $request->min;
        $max = $request->max;
        $sx = $request->sx;
        $birthday = $request->birthday;
        $pension = $request->pension;
        $annualincome = $request->annualincome;

        $constituents = Constituent::orderBy('birthdate')
            ->when($barangay, function($query) use($barangay){
                $query->whereHas(
                    'household.hhinfo.location', function ($q) use ($barangay) {
                        $q ->where('barangay_id', $barangay);
                    }
                );
            })
            ->when($barangay == null && $sitio, function($query) use($sitio){
                $query->whereHas(
                    'household.hhinfo.location', function ($q) use ($sitio) {
                        $q ->where('sitio_id', $sitio);
                    }
                );
            }) 
            
            ->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] )
            ->when(
                $search, function ($query, $search) use ($request) {
                    $query->where(DB::raw("TRIM(CONCAT(surname, ' ', firstname, ' ', COALESCE(middlename, ''))) "), 'LIKE', "%".$search."%")
                    ->orWhereHas(
                        'household.hhinfo', function ($q) use ($search) {
                            $q ->where('hhcontrol_num', 'LIKE', "%{$search}%");
                        }
                    );
                }
            )
           
            ->when($sx, function($query) use($sx){
                $query->where('sex',Str::lower($sx));
            })
            ->when($birthday, function($query) use($birthday){
                $query->whereBetween('birthdate', $birthday);
            })
            ->when(
                $pension, function ($query) use ($pension) {
                    $query->whereHas(
                        'pensions', function ($q) use ($pension) {
                            $q->whereIn('pension_type_id', $pension);
                        }
                    );
                }
            )
            ->when(
                $annualincome, function ($query) use ($annualincome) {
                    $query->whereHas(
                        'income', function ($q) use ($annualincome) {
                            $q->where('annualincome_id', $annualincome);
                        }
                    );
                }
            )
            ->when($min && $max, function ($query) use ($min,$max) {
                $query->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [$min,$max] );
                 }

            )
            ->when($min==null && $max==null, function ($query) use ($min,$max) {
                $query->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] );
                 }

            )
            
            ->withCount('pensions')->having('pensions_count','>',0)
            ->paginate(5)->total();
           
        
        return response()->json([
            'senior_count' =>$constituents,
        ],200);
        
    }
    public function getJson(RS $request){
        $data = [
            'title' => 'Welcome!',
            'date' => date('m/d/Y')
        ];

        $date = date('m/d/Y');
        $search = $request->search;
        $ageFrom = $request->ageFrom;
        $age = $request->age;
        $barangay = $request->barangay;
        $sitio = $request->sitio;
        $min = $request->min;
        $max = $request->max;
        $sx = $request->sx;
        $birthday = $request->birthday;
        $pension = $request->pension;
        $annualincome = $request->annualincome; 

        // $sitios = Sitio::orderBy('id')
        // ->when($barangay, function($query) use($barangay){
        //     $query->where('barangay_id',$barangay);
        // })
        // ->when($barangay == null && $sitio, function($query) use($sitio){
        //     $query->where('id',$sitio);
        // })   
             
        // ->get()->map(function($inner) use($search,$age,$request,$barangay,$sx,$birthday,$pension,$annualincome,$min,$max){
            $constituents = Constituent::orderBy('birthdate')
             ->when($barangay, function($query) use($barangay){
            $query->whereHas(
                'household.hhinfo.location', function ($q) use ($barangay) {
                    $q ->where('barangay_id', $barangay);
                }
            );
            })
            ->when($barangay == null && $sitio, function($query) use($sitio){
                $query->whereHas(
                    'household.hhinfo.location', function ($q) use ($sitio) {
                        $q ->where('sitio_id', $sitio);
                    }
                );
            }) 
                
            ->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] )
            ->when(
                $search, function ($query, $search) use ($request) {
                    $query->where(DB::raw("TRIM(CONCAT(surname, ' ', firstname, ' ', COALESCE(middlename, ''))) "), 'LIKE', "%".$search."%")
                    ->orWhereHas(
                        'household.hhinfo', function ($q) use ($search) {
                            $q ->where('hhcontrol_num', 'LIKE', "%{$search}%");
                        }
                    );
                }
            )
           
            ->when($sx, function($query) use($sx){
                $query->where('sex',Str::lower($sx));
            })
            ->when($birthday, function($query) use($birthday){
                $query->whereBetween('birthdate', $birthday);
            })
            ->when(
                $pension, function ($query) use ($pension) {
                    $query->whereHas(
                        'pensions', function ($q) use ($pension) {
                            $q->whereIn('pension_type_id', $pension);
                        }
                    );
                }
            )
            ->when(
                $annualincome, function ($query) use ($annualincome) {
                    $query->whereHas(
                        'income', function ($q) use ($annualincome) {
                            $q->where('annualincome_id', $annualincome);
                        }
                    );
                }
            )
            ->when($min && $max, function ($query) use ($min,$max) {
                $query->whereRaw( 'timestampdiff(year, birthdate, curdate()) between ? and ?', [$min,$max] );
                 }

            )
            ->when($min==null && $max==null, function ($query) use ($min,$max) {
                $query->whereRaw( 'timestampdiff(year, birthdate, curdate()) >= ?', [60] );
                 }

            )
            
            ->withCount('pensions')->having('pensions_count','>',0)
            ->get()
            ->map(function($inner){
                return [
                'name' => $inner->full_name,
                'hcn' => $inner->household->hhinfo->hhcontrol_num,
                'age' => $inner->age,
                'sex' => ucwords($inner->sex),
                'bday' => $inner->birthdate ? $inner->birthdate->toFormattedDateString() : '',
                'bday' => $inner->birthdate ? $inner->birthdate->toFormattedDateString() : '',
                'status' => ConstituentSeniorcitizen::where('constituent_id', $inner->id)->get()->first() ? ConstituentSeniorcitizen::where('constituent_id', $inner->id)->get()->first()->active : '',
                'address' => $inner->household->hhinfo->location ? $inner->household->hhinfo->location->barangay->name.', Sitio '.$inner->household->hhinfo->location->sitio->name :'',
                'pensions' => $inner->pensions ? $inner->pensions->map(function($inner){ return $inner->code;}) : '',
                // 'pensions' => ConstituentSeniorcitizen::where('constituent_id', $this->id)->get()->first() ? ConstituentSeniorcitizen::where('constituent_id', $this->id)->first()->pensions->map(function($inner){ return ["logo" =>"images/pension/".$inner->pension_type_id.".png", "name" => PensionType::where('id',$inner->pension_type_id)->first()->code];}) : '',
                'createdby' => ConstituentSeniorcitizen::where('constituent_id', $inner->id)->get()->first() ? (ConstituentSeniorcitizen::where('constituent_id', $inner->id)->get()->first()->createdby ? ConstituentSeniorcitizen::where('constituent_id', $inner->id)->get()->first()->createdBy->name : '') : '',
            
                ];
            });

            
        return response()->json([
            'constituents' => $constituents,
        ],200);
    }
}
