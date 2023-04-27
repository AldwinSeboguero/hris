<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Employee
 * 
 * @property int $id
 * @property string|null $employeeno
 * @property string|null $lastname
 * @property string|null $middlename
 * @property string|null $firstname
 * @property string|null $suffixname
 * @property string|null $emptype
 * @property string|null $sposition
 * @property string|null $cposition
 * @property Carbon|null $terminated
 * @property string|null $retired
 * @property string|null $department
 * @property string|null $detailed
 * @property string|null $division
 * @property string|null $officialtime
 * @property string|null $timetype
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Employee extends Model
{
	protected $table = 'employees';

	protected $casts = [
		'terminated' => 'datetime'
	];

	protected $fillable = [
		'employeeno',
		'lastname',
		'middlename',
		'firstname',
		'suffixname',
		'emptype',
		'sposition',
		'cposition',
		'terminated',
		'retired',
		'department',
		'detailed',
		'division',
		'officialtime',
		'timetype'
	];
}
