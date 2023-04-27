<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Appliedleafe
 * 
 * @property int $id
 * @property string|null $cardno
 * @property string|null $employeeno
 * @property string|null $myname
 * @property string|null $department
 * @property string|null $myposition
 * @property float|null $salary
 * @property string|null $particulars
 * @property Carbon|null $datefiled
 * @property float|null $vearned
 * @property float|null $vminus
 * @property float|null $searned
 * @property float|null $sminus
 * @property string|null $encoderko
 * @property Carbon|null $dateposted
 * @property string|null $leavetype
 * @property string|null $leaveparticulars
 * @property string|null $leavespent
 * @property string|null $spentparticulars
 * @property float|null $daysapplied
 * @property string|null $inclusivedates1
 * @property string|null $commutation
 * @property string|null $approval
 * @property Carbon|null $creditasof
 * @property string|null $approvaldetails
 * @property string|null $disapproved
 * @property string|null $departmenthead
 * @property string|null $chrmo
 * @property string|null $mayor
 * @property string|null $approved1
 * @property string|null $approved2
 * @property string|null $approved3
 * @property string|null $okey1
 * @property string|null $okey2
 * @property string|null $okey3
 * @property float|null $monetizelc
 * @property float|null $monetizesc
 * @property float|null $monetize
 * @property Carbon|null $dateprocessed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Appliedleafe extends Model
{
	protected $table = 'appliedleaves';

	
	protected $fillable = [
		'cardno',
		'employeeno',
		'myname',
		'department',
		'myposition',
		'salary',
		'particulars',
		'datefiled',
		'vearned',
		'vminus',
		'searned',
		'sminus',
		'encoderko',
		'dateposted',
		'leavetype',
		'leaveparticulars',
		'leavespent',
		'spentparticulars',
		'daysapplied',
		'inclusivedates1',
		'commutation',
		'approval',
		'creditasof',
		'approvaldetails',
		'disapproved',
		'departmenthead',
		'chrmo',
		'mayor',
		'approved1',
		'approved2',
		'approved3',
		'okey1',
		'okey2',
		'okey3',
		'monetizelc',
		'monetizesc',
		'monetize',
		'dateprocessed'
	];
}
