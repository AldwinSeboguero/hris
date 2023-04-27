<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Holiday
 * 
 * @property int $id
 * @property string|null $description
 * @property Carbon|null $holidate
 * @property string|null $holidayam
 * @property string|null $holidaypm
 * @property string|null $fromto
 * @property Carbon|null $fromtime
 * @property Carbon|null $totime
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Holiday extends Model
{
	protected $table = 'holidays';

	protected $fillable = [
		'description',
		'holidate',
		'holidayam',
		'holidaypm',
		'fromto',
		'fromtime',
		'totime'
	];
}
