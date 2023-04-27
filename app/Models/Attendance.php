<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Attendance
 * 
 * @property int $id
 * @property string|null $employeeno
 * @property string|null $name
 * @property Carbon|null $loginam
 * @property Carbon|null $logoutam
 * @property Carbon|null $loginpm
 * @property Carbon|null $logoutpm
 * @property Carbon|null $loginot
 * @property Carbon|null $logoutot
 * @property float|null $hours
 * @property string|null $status
 * @property Carbon|null $dateko
 * @property string|null $area
 * @property string|null $bypass
 * @property string|null $bypass1
 * @property string|null $bypass2
 * @property string|null $bypass3
 * @property string|null $area1
 * @property string|null $area2
 * @property string|null $area3
 * @property string|null $automatic
 * @property string|null $empaccount
 * @property string|null $overtime
 * @property float|null $approvedot
 * @property string|null $bypassby
 * @property Carbon|null $logtime
 * @property string|null $logpix
 * @property string|null $ciload
 * @property float|null $approvedci
 * @property string|null $nightdiff
 * @property string|null $remarks
 * @property string|null $dayoffot2
 * @property string|null $dayoffot
 * @property string|null $bypass4
 * @property string|null $bypass5
 * @property string|null $loginam1
 * @property string|null $logoutam1
 * @property string|null $loginpm1
 * @property string|null $logoutpm1
 * @property string|null $loginot1
 * @property string|null $logoutot1
 * @property float|null $adjustment
 * @property string|null $shiftsched
 * @property string|null $ordernumber
 * @property string|null $purpose
 * @property string|null $place
 * @property string|null $source
 * @property string|null $cocs
 * @property float|null $approvecoc
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Attendance extends Model
{
	protected $table = 'attendances';

	

	protected $fillable = [
		'employeeno',
		'name',
		'loginam',
		'logoutam',
		'loginpm',
		'logoutpm',
		'loginot',
		'logoutot',
		'hours',
		'status',
		'dateko',
		'area',
		'bypass',
		'bypass1',
		'bypass2',
		'bypass3',
		'area1',
		'area2',
		'area3',
		'automatic',
		'empaccount',
		'overtime',
		'approvedot',
		'bypassby',
		'logtime',
		'logpix',
		'ciload',
		'approvedci',
		'nightdiff',
		'remarks',
		'dayoffot2',
		'dayoffot',
		'bypass4',
		'bypass5',
		'loginam1',
		'logoutam1',
		'loginpm1',
		'logoutpm1',
		'loginot1',
		'logoutot1',
		'adjustment',
		'shiftsched',
		'ordernumber',
		'purpose',
		'place',
		'source',
		'cocs',
		'approvecoc'
	];
}
