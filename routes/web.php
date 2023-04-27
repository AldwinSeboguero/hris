<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SeniorCitizen\RegisteredController;
use App\Http\Controllers\SeniorCitizen\NotRegisteredController;
use App\Http\Controllers\SeniorCitizen\AddController;
use App\Http\Controllers\SeniorCitizen\EditController;
use App\Http\Controllers\Pensioner\SSSGSISController;
use App\Http\Controllers\Pensioner\DSWDController;
use App\Http\Controllers\Pensioner\LocalGovernmentController;
use App\Http\Controllers\ConstituentController;

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BarangayController;

use App\Http\Controllers\SitioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Pensioner\PensionerController;
use App\Http\Controllers\AgeController;
use App\Http\Controllers\PensionController;
use App\Http\Controllers\DisabilitiesController;

use App\Http\Controllers\AnnualIncomeController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\HousingController;
use App\Http\Controllers\WaterSanitationController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\EmploymentController;
use App\Http\Controllers\Constituent\PWDController as ConstituentPWD;
use App\Http\Controllers\Constituent\ChidrenController as ConstituentChildren;
use App\Http\Controllers\Constituent\SeniorCitizenController as ConstituentSeniorCitizen;
use App\Http\Controllers\Constituent\SoloParentController as ConstituentSoloParent;
use App\Http\Controllers\Education\EnrolledController as EdiucationEnrolled;
use App\Http\Controllers\Education\OutOfSchoolYouthController as EducationOutOfSchoolYouth;
use App\Http\Controllers\Education\IlliteracyController as EducationIlliteracy;

use App\Http\Controllers\Health\PregnanciesController as HealthPregnancies;
use App\Http\Controllers\Health\NutritionallyChallengedController as HealthNutritionallyChallenged;









use App\Http\Controllers\Constituent\SeniorController;
use App\Http\Controllers\Constituent\UpcomingSeniorController;
use App\Http\Controllers\Constituent\SexagenarianController;
use App\Http\Controllers\Constituent\SeptuagenarianController;
use App\Http\Controllers\Constituent\OctogenarianController;
use App\Http\Controllers\Constituent\NonagenarianController;
use App\Http\Controllers\Constituent\CentegenarianController;
use App\Http\Controllers\Constituent\SupercentegenarianController;
use App\Http\Controllers\Health\PWDController;
use App\Http\Controllers\Health\MortalityController;
use App\Http\Controllers\Housing\InformalSettlerController;
use App\Http\Controllers\Housing\MakeshiftHousingController;
use App\Http\Controllers\Housing\HPAController;
use App\Http\Controllers\WaterSanitation\WithAccessToSafeWaterController;
use App\Http\Controllers\WaterSanitation\WithoutAccessToSafeWaterController;
use App\Http\Controllers\WaterSanitation\WithoutAccessToSanitaryToiletController;
use App\Http\Controllers\WaterSanitation\WithAccessToSanitaryToiletController;
use App\Http\Controllers\Income\BelowPoveryController;
use App\Http\Controllers\Income\BelowFoodController;
use App\Http\Controllers\Employment\EmployedController;
use App\Http\Controllers\Employment\UnemployedController;
use App\Http\Controllers\Employment\SelfEmployedController;
use App\Http\Controllers\Employment\OverseasWorkerController;


Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
      //   'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::group(['middleware' => ['auth:sanctum','verified']], function()
{
    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/getSenior', [DashboardController::class, 'getSenior'])->name('dashboard.getSenior');
    Route::get('/dashboard/getSeniorLastPage', [DashboardController::class, 'getSeniorLastPage'])->name('dashboard.getSeniorLastPage');
    Route::get('/dashboard/getSeniorCount', [DashboardController::class, 'getSeniorCount'])->name('dashboard.getSeniorCount');
    Route::get('/dashboard/getSeniorRegisteredCount', [DashboardController::class, 'getSeniorRegisteredCount'])->name('dashboard.getSeniorRegisteredCount');
    Route::get('/dashboard/getSeniorMaleCount', [DashboardController::class, 'getSeniorMaleCount'])->name('dashboard.getSeniorMaleCount');
    Route::get('/dashboard/getSeniorFemaleCount', [DashboardController::class, 'getSeniorFemaleCount'])->name('dashboard.getSeniorFemaleCount');
    Route::get('/dashboard/getSeniorPensionerCount', [DashboardController::class, 'getSeniorPensionerCount'])->name('dashboard.getSeniorPensionerCount');
    Route::get('/dashboard/getRecentlyRegistered', [DashboardController::class, 'getRecentlyRegistered'])->name('dashboard.getRecentlyRegistered');
    Route::get('/dashboard/getSeniorByAge', [DashboardController::class, 'getSeniorByAge'])->name('dashboard.getSeniorByAge');
    


    //Registered
    Route::get('/senior_citizens/registered', [RegisteredController::class, 'index'])->name('senior_citizens.registered');
    Route::get('/senior_citizens/registered/show', [RegisteredController::class, 'show'])->name('senior_citizens.registered.show');
    Route::get('/registered-senior', [RegisteredController::class, 'pdf'])->name('senior_citizens.registered.pdf');
    Route::get('/registered-senior-count', [RegisteredController::class, 'registeredSeniorCount'])->name('senior_citizens.registered.count');
    Route::get('/registered-senior-json', [RegisteredController::class, 'getJson'])->name('senior_citizens.registered.json');


    //Not Registered
    Route::get('/senior_citizens/not_registered', [NotRegisteredController::class, 'index'])->name('senior_citizens.not_registered');
    Route::get('/senior_citizens/not_registered/show', [NotRegisteredController::class, 'show'])->name('senior_citizens.not_registered.show');
    Route::get('/senior_citizens/add', [AddController::class, 'index'])->name('senior_citizens.add');
    Route::get('/senior_citizens/edit', [EditController::class, 'index'])->name('senior_citizens.edit');
    Route::post('/senior_citizens/edit/senior', [EditController::class, 'update'])->name('senior_citizens.edit.update');
   
    Route::post('/senior_citizens/edit/unregister', [EditController::class, 'unregister'])->name('senior_citizens.edit.unregister');

    Route::get('/notregistered-senior', [NotRegisteredController::class, 'pdf'])->name('senior_citizens.notregistered.pdf');
    Route::get('/notregistered-senior-count', [NotRegisteredController::class, 'notregisteredSeniorCount'])->name('senior_citizens.notregistered.count');
    Route::get('/notregistered-senior-json', [NotRegisteredController::class, 'getJson'])->name('senior_citizens.notregistered.json');


    Route::get('/senior_citizens/view', [App\Http\Controllers\SeniorCitizen\ViewController::class, 'index'])->name('senior_citizens.view');
    Route::get('/senior_citizens/register', [App\Http\Controllers\SeniorCitizen\RegisterController::class, 'index'])->name('senior_citizens.register');

    Route::post('/senior_citizens/register', [AddController::class, 'register'])->name('senior_citizens.register');
    Route::get('/senior_citizens/searhNotRegisterSenior', [AddController::class, 'searhNotRegisterSenior'])->name('senior_citizens.searhNotRegisterSenior');
    
    //Pensioners
    Route::get('/pensioners', [PensionerController::class, 'index'])->name('senior_citizens.pensioners');
    Route::get('/pensioners/show', [PensionerController::class, 'show'])->name('senior_citizens.pensioners.show');
    Route::get('/pensioners-senior', [PensionerController::class, 'pdf'])->name('senior_citizens.pensioners.pdf');
    Route::get('/pensioners-senior-count', [PensionerController::class, 'pensionersSeniorCount'])->name('senior_citizens.pensioners.count');
    Route::get('/pensioners-senior-json', [PensionerController::class, 'getJson'])->name('senior_citizens.pensioners.json');

    //
    Route::get('/constituents/59', [ConstituentController::class, 'index'])->name('constituents');
    Route::get('/constituents/59/show', [ConstituentController::class, 'show'])->name('constituents.show');
    Route::get('/constituent-59-above', [ConstituentController::class, 'pdf'])->name('constituents.pdf');
    Route::get('/getCountByBarangay', [ConstituentController::class, 'getCountByBarangay'])->name('sitio.getCountByBarangay');
    Route::get('/constituent-59-above-count', [ConstituentController::class, 'constituentsCount'])->name('constituents.count');
    Route::get('/constituent-59-above-json', [ConstituentController::class, 'getJson'])->name('constituents.json');

    //Sitio and Barangay
    Route::get('/getBarangayName', [BarangayController::class, 'getBarangayName'])->name('barangay.getBarangayName');
    Route::get('/getSitioName', [SitioController::class, 'getSitioName'])->name('sitio.getSitoName');
    Route::get('/getSitio', [SitioController::class, 'getSitio'])->name('sitio.getSito');

    //Age
    Route::get('/getMaxAge', [AgeController::class, 'getMaxAge'])->name('sitio.getMaxAge');

    //Pension
    Route::get('/getPensions', [PensionController::class, 'getPensions'])->name('sitio.getPensions');
    Route::get('/getDisabilities', [DisabilitiesController::class, 'getDisabilities'])->name('sitio.getDisabilities');


    //AnnualIncome
    Route::get('/getAnnualIncomes', [AnnualIncomeController::class, 'getAnnualIncomes'])->name('sitio.getAnnualIncomes');


    //Healths
    Route::get('/healths', [HealthController::class, 'index'])->name('senior_citizens.health.index');
    Route::get('/healths/getMortality', [HealthController::class, 'getMortality'])->name('senior_citizens.health.getMortality');
    Route::get('/healths/getPWD', [HealthController::class, 'getPWD'])->name('senior_citizens.health.getPWD');
    
    Route::get('/healths/pwd', [PWDController::class, 'index'])->name('senior_citizens.health.pwd.index');
      Route::get('/healths/pwd/show', [PWDController::class, 'show'])->name('senior_citizens.health.pwd.show');
      Route::get('/healths/pwd/senior', [PWDController::class, 'pdf'])->name('senior_citizens.health.pwd.pdf');
      Route::get('/healths/pwd/count', [PWDController::class, 'registeredSeniorCount'])->name('senior_citizens.health.pwd.count');
      Route::get('/healths/pwd/json', [PWDController::class, 'getJson'])->name('senior_citizens.health.pwd.json');
   Route::get('/healths/mortality', [MortalityController::class, 'index'])->name('senior_citizens.health.mortality.index');
      Route::get('/healths/mortality/show', [MortalityController::class, 'show'])->name('senior_citizens.health.mortality.show');
      Route::get('/healths/mortality/senior', [MortalityController::class, 'pdf'])->name('senior_citizens.health.mortality.pdf');
      Route::get('/healths/mortality/count', [MortalityController::class, 'registeredSeniorCount'])->name('senior_citizens.health.mortality.count');
      Route::get('/healths/mortality/json', [MortalityController::class, 'getJson'])->name('senior_citizens.health.mortality.json');

    //Housing
    Route::get('/housing', [HousingController::class, 'index'])->name('senior_citizens.housing.index');
    Route::get('/housing/getInformalSettler', [HousingController::class, 'getInformalSettler'])->name('senior_citizens.housing.getInformalSettler');
    Route::get('/housing/getMakeshiftHousing', [HousingController::class, 'getMakeshiftHousing'])->name('senior_citizens.housing.getMakeshiftHousing');
    Route::get('/housing/getHPA', [HousingController::class, 'getHPA'])->name('senior_citizens.housing.getHPA');
   
    Route::get('/housing/informalsettler', [InformalSettlerController::class, 'index'])->name('senior_citizens.housing.informalsettler.index');
      Route::get('/housing/informalsettler/show', [InformalSettlerController::class, 'show'])->name('senior_citizens.housing.informalsettler.show');
      Route::get('/housing/informalsettler/senior', [InformalSettlerController::class, 'pdf'])->name('senior_citizens.housing.informalsettler.pdf');
      Route::get('/housing/informalsettler/count', [InformalSettlerController::class, 'registeredSeniorCount'])->name('senior_citizens.housing.informalsettler.count');
      Route::get('/housing/informalsettler/json', [InformalSettlerController::class, 'getJson'])->name('senior_citizens.housing.informalsettler.json');
   Route::get('/housing/makeshifthousing', [MakeshiftHousingController::class, 'index'])->name('senior_citizens.housing.makeshifthousing.index');
      Route::get('/housing/makeshifthousing/show', [MakeshiftHousingController::class, 'show'])->name('senior_citizens.housing.makeshifthousing.show');
      Route::get('/housing/makeshifthousing/senior', [MakeshiftHousingController::class, 'pdf'])->name('senior_citizens.housing.makeshifthousing.pdf');
      Route::get('/housing/makeshifthousing/count', [MakeshiftHousingController::class, 'registeredSeniorCount'])->name('senior_citizens.housing.makeshifthousing.count');
      Route::get('/housing/makeshifthousing/json', [MakeshiftHousingController::class, 'getJson'])->name('senior_citizens.housing.makeshifthousing.json');
   Route::get('/housing/hpa', [HPAController::class, 'index'])->name('senior_citizens.housing.hpa.index');
      Route::get('/housing/hpa/show', [HPAController::class, 'show'])->name('senior_citizens.housing.hpa.show');
      Route::get('/housing/hpa/senior', [HPAController::class, 'pdf'])->name('senior_citizens.housing.hpa.pdf');
      Route::get('/housing/hpa/count', [HPAController::class, 'registeredSeniorCount'])->name('senior_citizens.housing.hpa.count');
      Route::get('/housing/hpa/json', [HPAController::class, 'getJson'])->name('senior_citizens.housing.hpa.json');

    //WaterSanitation
    Route::get('/watersanitation', [WaterSanitationController::class, 'index'])->name('senior_citizens.watersanitation.index');
    Route::get('/watersanitation/getWithAccessToWater', [WaterSanitationController::class, 'getWithAccessToWater'])->name('senior_citizens.watersanitation.getWithAccessToWater');
    Route::get('/watersanitation/getWithAccessToSanitaryToilet', [WaterSanitationController::class, 'getWithAccessToSanitaryToilet'])->name('senior_citizens.watersanitation.getWithAccessToSanitaryToilet');
    Route::get('/watersanitation/getWithoutAccessToWater', [WaterSanitationController::class, 'getWithoutAccessToWater'])->name('senior_citizens.watersanitation.getWithoutAccessToWater');
    Route::get('/watersanitation/getWithoutAccessToSanitaryToilet', [WaterSanitationController::class, 'getWithoutAccessToSanitaryToilet'])->name('senior_citizens.watersanitation.getWithoutAccessToSanitaryToilet');
    
   Route::get('/watersanitation/withaccesstowater', [WithAccessToSafeWaterController::class, 'index'])->name('senior_citizens.watersanitation.withaccesstowater.index');
      Route::get('/watersanitation/withaccesstowater/show', [WithAccessToSafeWaterController::class, 'show'])->name('senior_citizens.watersanitation.withaccesstowater.show');
      Route::get('/watersanitation/withaccesstowater/senior', [WithAccessToSafeWaterController::class, 'pdf'])->name('senior_citizens.watersanitation.withaccesstowater.pdf');
      Route::get('/watersanitation/withaccesstowater/count', [WithAccessToSafeWaterController::class, 'registeredSeniorCount'])->name('senior_citizens.watersanitation.withaccesstowater.count');
      Route::get('/watersanitation/withaccesstowater/json', [WithAccessToSafeWaterController::class, 'getJson'])->name('senior_citizens.watersanitation.withaccesstowater.json');
   Route::get('/watersanitation/withaccesstosanitarytoilet', [WithAccessToSanitaryToiletController::class, 'index'])->name('senior_citizens.watersanitation.withaccesstosanitarytoilet.index');
      Route::get('/watersanitation/withaccesstosanitarytoilet/show', [WithAccessToSanitaryToiletController::class, 'show'])->name('senior_citizens.watersanitation.withaccesstosanitarytoilet.show');
      Route::get('/watersanitation/withaccesstosanitarytoilet/senior', [WithAccessToSanitaryToiletController::class, 'pdf'])->name('senior_citizens.watersanitation.withaccesstosanitarytoilet.pdf');
      Route::get('/watersanitation/withaccesstosanitarytoilet/count', [WithAccessToSanitaryToiletController::class, 'registeredSeniorCount'])->name('senior_citizens.watersanitation.withaccesstosanitarytoilet.count');
      Route::get('/watersanitation/withaccesstosanitarytoilet/json', [WithAccessToSanitaryToiletController::class, 'getJson'])->name('senior_citizens.watersanitation.withaccesstosanitarytoilet.json');
   Route::get('/watersanitation/withoutaccesstowater', [WithoutAccessToSafeWaterController::class, 'index'])->name('senior_citizens.watersanitation.withoutaccesstowater.index');
      Route::get('/watersanitation/withoutaccesstowater/show', [WithoutAccessToSafeWaterController::class, 'show'])->name('senior_citizens.watersanitation.withoutaccesstowater.show');
      Route::get('/watersanitation/withoutaccesstowater/senior', [WithoutAccessToSafeWaterController::class, 'pdf'])->name('senior_citizens.watersanitation.withoutaccesstowater.pdf');
      Route::get('/watersanitation/withoutaccesstowater/count', [WithoutAccessToSafeWaterController::class, 'registeredSeniorCount'])->name('senior_citizens.watersanitation.withoutaccesstowater.count');
      Route::get('/watersanitation/withoutaccesstowater/json', [WithoutAccessToSafeWaterController::class, 'getJson'])->name('senior_citizens.watersanitation.withoutaccesstowater.json');
   Route::get('/watersanitation/withoutaccesstosanitarytoilet', [WithoutAccessToSanitaryToiletController::class, 'index'])->name('senior_citizens.watersanitation.withoutaccesstosanitarytoilet.index');
      Route::get('/watersanitation/withoutaccesstosanitarytoilet/show', [WithoutAccessToSanitaryToiletController::class, 'show'])->name('senior_citizens.watersanitation.withoutaccesstosanitarytoilet.show');
      Route::get('/watersanitation/withoutaccesstosanitarytoilet/senior', [WithoutAccessToSanitaryToiletController::class, 'pdf'])->name('senior_citizens.watersanitation.withoutaccesstosanitarytoilet.pdf');
      Route::get('/watersanitation/withoutaccesstosanitarytoilet/count', [WithoutAccessToSanitaryToiletController::class, 'registeredSeniorCount'])->name('senior_citizens.watersanitation.withoutaccesstosanitarytoilet.count');
      Route::get('/watersanitation/withoutaccesstosanitarytoilet/json', [WithoutAccessToSanitaryToiletController::class, 'getJson'])->name('senior_citizens.watersanitation.withoutaccesstosanitarytoilet.json');


     //Income
     Route::get('/income', [IncomeController::class, 'index'])->name('senior_citizens.income.index');
     Route::get('/income/getBelowPoverty', [IncomeController::class, 'getBelowPoverty'])->name('senior_citizens.income.getBelowPoverty');
     Route::get('/income/getBelowFood', [IncomeController::class, 'getBelowFood'])->name('senior_citizens.income.getBelowFood');
     
     Route::get('/income/belowpoverty', [BelowPoveryController::class, 'index'])->name('senior_citizens.income.belowpoverty.index');
      Route::get('/income/belowpoverty/show', [BelowPoveryController::class, 'show'])->name('senior_citizens.income.belowpoverty.show');
      Route::get('/income/belowpoverty/senior', [BelowPoveryController::class, 'pdf'])->name('senior_citizens.income.belowpoverty.pdf');
      Route::get('/income/belowpoverty/count', [BelowPoveryController::class, 'registeredSeniorCount'])->name('senior_citizens.income.belowpoverty.count');
      Route::get('/income/belowpoverty/json', [BelowPoveryController::class, 'getJson'])->name('senior_citizens.income.belowpoverty.json');
   Route::get('/income/belowfood', [BelowFoodController::class, 'index'])->name('senior_citizens.income.belowfood.index');
      Route::get('/income/belowfood/show', [BelowFoodController::class, 'show'])->name('senior_citizens.income.belowfood.show');
      Route::get('/income/belowfood/senior', [BelowFoodController::class, 'pdf'])->name('senior_citizens.income.belowfood.pdf');
      Route::get('/income/belowfood/count', [BelowFoodController::class, 'registeredSeniorCount'])->name('senior_citizens.income.belowfood.count');
      Route::get('/income/belowfood/json', [BelowFoodController::class, 'getJson'])->name('senior_citizens.income.belowfood.json');

     //Employment
    Route::get('/employment', [EmploymentController::class, 'index'])->name('senior_citizens.employment.index');
    Route::get('/employment/getEmployed', [EmploymentController::class, 'getEmployed'])->name('senior_citizens.employment.getEmployed');
    Route::get('/employment/getUnemployed', [EmploymentController::class, 'getUnemployed'])->name('senior_citizens.employment.getUnemployed');
    Route::get('/employment/getSelfEmployed', [EmploymentController::class, 'getSelfEmployed'])->name('senior_citizens.employment.getSelfEmployed');
    Route::get('/employment/getOverseasWorker', [EmploymentController::class, 'getOverseasWorker'])->name('senior_citizens.employment.getOverseasWorker');
    
    Route::get('/employment/employed', [EmployedController::class, 'index'])->name('senior_citizens.employment.employed.index');
      Route::get('/employment/employed/show', [EmployedController::class, 'show'])->name('senior_citizens.employment.employed.show');
      Route::get('/employment/employed/senior', [EmployedController::class, 'pdf'])->name('senior_citizens.employment.employed.pdf');
      Route::get('/employment/employed/count', [EmployedController::class, 'registeredSeniorCount'])->name('senior_citizens.employment.employed.count');
      Route::get('/employment/employed/json', [EmployedController::class, 'getJson'])->name('senior_citizens.employment.employed.json');
   Route::get('/employment/unemployed', [UnemployedController::class, 'index'])->name('senior_citizens.employment.unemployed.index');
      Route::get('/employment/unemployed/show', [UnemployedController::class, 'show'])->name('senior_citizens.employment.unemployed.show');
      Route::get('/employment/unemployed/senior', [UnemployedController::class, 'pdf'])->name('senior_citizens.employment.unemployed.pdf');
      Route::get('/employment/unemployed/count', [UnemployedController::class, 'registeredSeniorCount'])->name('senior_citizens.employment.unemployed.count');
      Route::get('/employment/unemployed/json', [UnemployedController::class, 'getJson'])->name('senior_citizens.employment.unemployed.json');
   Route::get('/employment/selfemployed', [SelfEmployedController::class, 'index'])->name('senior_citizens.employment.selfemployed.index');
      Route::get('/employment/selfemployed/show', [SelfEmployedController::class, 'show'])->name('senior_citizens.employment.selfemployed.show');
      Route::get('/employment/selfemployed/senior', [SelfEmployedController::class, 'pdf'])->name('senior_citizens.employment.selfemployed.pdf');
      Route::get('/employment/selfemployed/count', [SelfEmployedController::class, 'registeredSeniorCount'])->name('senior_citizens.employment.selfemployed.count');
      Route::get('/employment/selfemployed/json', [SelfEmployedController::class, 'getJson'])->name('senior_citizens.employment.selfemployed.json');
   Route::get('/employment/overseasworker', [OverseasWorkerController::class, 'index'])->name('senior_citizens.employment.overseasworker.index');
      Route::get('/employment/overseasworker/show', [OverseasWorkerController::class, 'show'])->name('senior_citizens.employment.overseasworker.show');
      Route::get('/employment/overseasworker/senior', [OverseasWorkerController::class, 'pdf'])->name('senior_citizens.employment.overseasworker.pdf');
      Route::get('/employment/overseasworker/count', [OverseasWorkerController::class, 'registeredSeniorCount'])->name('senior_citizens.employment.overseasworker.count');
      Route::get('/employment/overseasworker/json', [OverseasWorkerController::class, 'getJson'])->name('senior_citizens.employment.overseasworker.json');

     //Constituent
     Route::get('/constituent', [ConstituentController::class, 'index'])->name('senior_citizens.constituent.index');
     Route::get('/constituent/getSenior', [ConstituentController::class, 'getSenior'])->name('senior_citizens.constituent.getSenior');
     Route::get('/constituent/getUpcoming', [ConstituentController::class, 'getUpcoming'])->name('senior_citizens.constituent.getUpcoming');
     Route::get('/constituent/getSexagenarian', [ConstituentController::class, 'getSexagenarian'])->name('senior_citizens.constituent.getSexagenarian');
     Route::get('/constituent/getSeptuagenarian', [ConstituentController::class, 'getSeptuagenarian'])->name('senior_citizens.constituent.getSeptuagenarian');
     Route::get('/constituent/getOctogenarian', [ConstituentController::class, 'getOctogenarian'])->name('senior_citizens.constituent.getOctogenarian');
     Route::get('/constituent/getNonagenarian', [ConstituentController::class, 'getNonagenarian'])->name('senior_citizens.constituent.getNonagenarian');
     Route::get('/constituent/getCentenarian', [ConstituentController::class, 'getCentenarian'])->name('senior_citizens.constituent.getCentenarian');
     Route::get('/constituent/getSupercentenarian', [ConstituentController::class, 'getSupercentenarian'])->name('senior_citizens.constituent.getSupercentenarian');


     Route::get('/constituent/pwds', [ConstituentPWD::class, 'index'])->name('pwds.constituent.pwds.index');
     Route::get('/constituent/pwd/show', [ConstituentPWD::class, 'show'])->name('pwds.constituent.pwds.show');
     Route::get('/constituent/pwd/pdf', [ConstituentPWD::class, 'pdf'])->name('pwds.constituent.pwds.pdf');
     Route::get('/constituent/pwd/count', [ConstituentPWD::class, 'registeredPwdsCount'])->name('pwds.constituent.pwds.count');
     Route::get('/constituent/pwd/json', [ConstituentPWD::class, 'getJson'])->name('pwds.constituent.pwds.json');


   Route::get('/constituent/children', [ConstituentChildren::class, 'index'])->name('pwds.constituent.children.index');
   Route::get('/constituent/children/show', [ConstituentChildren::class, 'show'])->name('pwds.constituent.children.show');
   Route::get('/constituent/children/pdf', [ConstituentChildren::class, 'pdf'])->name('pwds.constituent.children.pdf');
   Route::get('/constituent/children/count', [ConstituentChildren::class, 'registeredPwdsCount'])->name('pwds.constituent.children.count');
   Route::get('/constituent/children/json', [ConstituentChildren::class, 'getJson'])->name('pwds.constituent.children.json');
   
   Route::get('/constituent/seniorcitizen', [ConstituentSeniorCitizen::class, 'index'])->name('pwds.constituent.seniorcitizen.index');
   Route::get('/constituent/seniorcitizen/show', [ConstituentSeniorCitizen::class, 'show'])->name('pwds.constituent.seniorcitizen.show');
   Route::get('/constituent/seniorcitizen/pdf', [ConstituentSeniorCitizen::class, 'pdf'])->name('pwds.constituent.seniorcitizen.pdf');
   Route::get('/constituent/seniorcitizen/count', [ConstituentSeniorCitizen::class, 'registeredPwdsCount'])->name('pwds.constituent.seniorcitizen.count');
   Route::get('/constituent/seniorcitizen/json', [ConstituentSeniorCitizen::class, 'getJson'])->name('pwds.constituent.seniorcitizen.json');
  
   Route::get('/constituent/soloparent', [ConstituentSoloParent::class, 'index'])->name('pwds.constituent.soloparent.index');
   Route::get('/constituent/soloparent/show', [ConstituentSoloParent::class, 'show'])->name('pwds.constituent.soloparent.show');
   Route::get('/constituent/seoloparentpdf', [ConstituentSoloParent::class, 'pdf'])->name('pwds.constituent.soloparent.pdf');
   Route::get('/constituent/soloparent/count', [ConstituentSoloParent::class, 'registeredPwdsCount'])->name('pwds.constituent.soloparent.count');
   Route::get('/constituent/soloparent/json', [ConstituentSoloParent::class, 'getJson'])->name('pwds.constituent.soloparent.json');




   //Basic Education

   Route::get('/education/enrolled', [EdiucationEnrolled::class, 'index'])->name('pwds.education.enrolled.index');
   Route::get('/education/enrolled/show', [EdiucationEnrolled::class, 'show'])->name('pwds.education.enrolled.show');
   Route::get('/education/enrolled/pdf', [EdiucationEnrolled::class, 'pdf'])->name('pwds.education.enrolled.pdf');
   Route::get('/education/enrolled/count', [EdiucationEnrolled::class, 'registeredPwdsCount'])->name('pwds.education.enrolled.count');
   Route::get('/education/enrolled/json', [EdiucationEnrolled::class, 'getJson'])->name('pwds.education.enrolled.json');

   Route::get('/education/outofschoolyouth', [EducationOutOfSchoolYouth::class, 'index'])->name('pwds.education.outofschoolyouth.index');
   Route::get('/education/outofschoolyouth/show', [EducationOutOfSchoolYouth::class, 'show'])->name('pwds.education.outofschoolyouth.show');
   Route::get('/education/outofschoolyouth/pdf', [EducationOutOfSchoolYouth::class, 'pdf'])->name('pwds.education.outofschoolyouth.pdf');
   Route::get('/education/outofschoolyouth/count', [EducationOutOfSchoolYouth::class, 'registeredPwdsCount'])->name('pwds.education.outofschoolyouth.count');
   Route::get('/education/outofschoolyouth/json', [EducationOutOfSchoolYouth::class, 'getJson'])->name('pwds.education.outofschoolyouth.json');

   Route::get('/education/illiteracy', [EducationIlliteracy::class, 'index'])->name('pwds.education.illiteracy.index');
   Route::get('/education/illiteracy/show', [EducationIlliteracy::class, 'show'])->name('pwds.education.illiteracy.show');
   Route::get('/education/illiteracy/pdf', [EducationIlliteracy::class, 'pdf'])->name('pwds.education.illiteracy.pdf');
   Route::get('/education/illiteracy/count', [EducationIlliteracy::class, 'registeredPwdsCount'])->name('pwds.education.illiteracy.count');
   Route::get('/education/illiteracy/json', [EducationIlliteracy::class, 'getJson'])->name('pwds.education.illiteracy.json');

   //health
   Route::get('/health/pregnancies', [HealthPregnancies::class, 'index'])->name('pwds.health.pregnancies.index');
   Route::get('/health/pregnancies/show', [HealthPregnancies::class, 'show'])->name('pwds.health.pregnancies.show');
   Route::get('/health/pregnancies/pdf', [HealthPregnancies::class, 'pdf'])->name('pwds.health.pregnancies.pdf');
   Route::get('/health/pregnancies/count', [HealthPregnancies::class, 'registeredPwdsCount'])->name('pwds.health.pregnancies.count');
   Route::get('/health/pregnancies/json', [HealthPregnancies::class, 'getJson'])->name('pwds.health.pregnancies.json');

   Route::get('/health/nutritionallychallenged', [HealthNutritionallyChallenged::class, 'index'])->name('pwds.health.nutritionallychallenged.index');
   Route::get('/health/nutritionallychallenged/show', [HealthNutritionallyChallenged::class, 'show'])->name('pwds.health.nutritionallychallenged.show');
   Route::get('/health/nutritionallychallenged/pdf', [HealthNutritionallyChallenged::class, 'pdf'])->name('pwds.health.nutritionallychallenged.pdf');
   Route::get('/health/nutritionallychallenged/count', [HealthNutritionallyChallenged::class, 'registeredPwdsCount'])->name('pwds.health.nutritionallychallenged.count');
   Route::get('/health/nutritionallychallenged/json', [HealthNutritionallyChallenged::class, 'getJson'])->name('pwds.health.nutritionallychallenged.json');
     

   //   Route::get('/constituent/seniorcitizen', [SeniorController::class, 'index'])->name('senior_citizens.constituent.seniorcitizen.index');
   //      Route::get('/constituent/seniorcitizen/show', [SeniorController::class, 'show'])->name('senior_citizens.constituent.seniorcitizen.show');
   //      Route::get('/constituent/seniorcitizen/senior', [SeniorController::class, 'pdf'])->name('senior_citizens.constituent.seniorcitizen.pdf');
   //      Route::get('/constituent/seniorcitizen/count', [SeniorController::class, 'registeredSeniorCount'])->name('senior_citizens.constituent.seniorcitizen.count');
   //      Route::get('/constituent/seniorcitizen/json', [SeniorController::class, 'getJson'])->name('senior_citizens.constituent.seniorcitizen.json');

     Route::get('/constituent/upcomingsenior', [UpcomingSeniorController::class, 'index'])->name('senior_citizens.constituent.upcomingsenior.index');
        Route::get('/constituent/upcomingsenior/show', [UpcomingSeniorController::class, 'show'])->name('senior_citizens.constituent.upcomingsenior.show');
        Route::get('/constituent/upcomingsenior/senior', [UpcomingSeniorController::class, 'pdf'])->name('senior_citizens.constituent.upcomingsenior.pdf');
        Route::get('/constituent/upcomingsenior/count', [UpcomingSeniorController::class, 'registeredSeniorCount'])->name('senior_citizens.constituent.upcomingsenior.count');
        Route::get('/constituent/upcomingsenior/json', [UpcomingSeniorController::class, 'getJson'])->name('senior_citizens.constituent.upcomingsenior.json');

     Route::get('/constituent/sexagenarian', [SexagenarianController::class, 'index'])->name('senior_citizens.constituent.sexagenarian.index');
        Route::get('/constituent/sexagenarian/show', [SexagenarianController::class, 'show'])->name('senior_citizens.constituent.sexagenarian.show');
        Route::get('/constituent/sexagenarian/senior', [SexagenarianController::class, 'pdf'])->name('senior_citizens.constituent.sexagenarian.pdf');
        Route::get('/constituent/sexagenarian/count', [SexagenarianController::class, 'registeredSeniorCount'])->name('senior_citizens.constituent.sexagenarian.count');
        Route::get('/constituent/sexagenarian/json', [SexagenarianController::class, 'getJson'])->name('senior_citizens.constituent.sexagenarian.json');

     Route::get('/constituent/septuagenarian', [SeptuagenarianController::class, 'index'])->name('senior_citizens.constituent.septuagenarian.index');
        Route::get('/constituent/septuagenarian/show', [SeptuagenarianController::class, 'show'])->name('senior_citizens.constituent.septuagenarian.show');
        Route::get('/constituent/septuagenarian/senior', [SeptuagenarianController::class, 'pdf'])->name('senior_citizens.constituent.septuagenarian.pdf');
        Route::get('/constituent/septuagenarian/count', [SeptuagenarianController::class, 'registeredSeniorCount'])->name('senior_citizens.constituent.septuagenarian.count');
        Route::get('/constituent/septuagenarian/json', [SeptuagenarianController::class, 'getJson'])->name('senior_citizens.constituent.septuagenarian.json');

     Route::get('/constituent/octogenarian', [OctogenarianController::class, 'index'])->name('senior_citizens.constituent.octogenarian.index');
        Route::get('/constituent/octogenarian/show', [OctogenarianController::class, 'show'])->name('senior_citizens.constituent.octogenarian.show');
        Route::get('/constituent/octogenarian/senior', [OctogenarianController::class, 'pdf'])->name('senior_citizens.constituent.octogenarian.pdf');
        Route::get('/constituent/octogenarian/count', [OctogenarianController::class, 'registeredSeniorCount'])->name('senior_citizens.constituent.octogenarian.count');
        Route::get('/constituent/octogenarian/json', [OctogenarianController::class, 'getJson'])->name('senior_citizens.constituent.octogenarian.json');

     Route::get('/constituent/nonagenarian', [NonagenarianController::class, 'index'])->name('senior_citizens.constituent.nonagenarian.index');
        Route::get('/constituent/nonagenarian/show', [NonagenarianController::class, 'show'])->name('senior_citizens.constituent.nonagenarian.show');
        Route::get('/constituent/nonagenarian/senior', [NonagenarianController::class, 'pdf'])->name('senior_citizens.constituent.nonagenarian.pdf');
        Route::get('/constituent/nonagenarian/count', [NonagenarianController::class, 'registeredSeniorCount'])->name('senior_citizens.constituent.nonagenarian.count');
        Route::get('/constituent/nonagenarian/json', [NonagenarianController::class, 'getJson'])->name('senior_citizens.constituent.nonagenarian.json');

     Route::get('/constituent/centenarian', [CentegenarianController::class, 'index'])->name('senior_citizens.constituent.centenarian.index');
        Route::get('/constituent/centenarian/show', [CentegenarianController::class, 'show'])->name('senior_citizens.constituent.centenarian.show');
        Route::get('/constituent/centenarian/senior', [CentegenarianController::class, 'pdf'])->name('senior_citizens.constituent.centenarian.pdf');
        Route::get('/constituent/centenarian/count', [CentegenarianController::class, 'registeredSeniorCount'])->name('senior_citizens.constituent.centenarian.count');
        Route::get('/constituent/centenarian/json', [CentegenarianController::class, 'getJson'])->name('senior_citizens.constituent.centenarian.json');

     Route::get('/constituent/supercentenarian', [SupercentegenarianController::class, 'index'])->name('senior_citizens.constituent.supercentenarian.index');
        Route::get('/constituent/supercentenarian/show', [SupercentegenarianController::class, 'show'])->name('senior_citizens.constituent.supercentenarian.show');
        Route::get('/constituent/supercentenarian/senior', [SupercentegenarianController::class, 'pdf'])->name('senior_citizens.constituent.supercentenarian.pdf');
        Route::get('/constituent/supercentenarian/count', [SupercentegenarianController::class, 'registeredSeniorCount'])->name('senior_citizens.constituent.supercentenarian.count');
        Route::get('/constituent/supercentenarian/json', [SupercentegenarianController::class, 'getJson'])->name('senior_citizens.constituent.supercentenarian.json');




   // Attendances
   Route::get('/employees', [AttendanceController::class, 'index'])->name('attendances.index');
   Route::get('/employees/show', [AttendanceController::class, 'show'])->name('attendances.show');
   Route::get('/employees/generate', [AttendanceController::class, 'pdf'])->name('attendances.generate');

   //dvivisons
   Route::get('/divisions', [AttendanceController::class, 'getDivisions'])->name('attendances.getDivisions');



});

Route::middleware(['auth:sanctum', 'verified'])->get('/reports', function () {
    return Inertia::render('Reports/Index');
})->name('reports');

Route::middleware(['auth:sanctum', 'verified'])->get('/tables/view', function () {
    return Inertia::render('Profile2/Show');
})->name('tables.view');

// Route::middleware(['auth:sanctum', 'verified'])->get('/attendances', function () {
//    return Inertia::render('Attendance/Index2');
// })->name('attendances');


//Healths








