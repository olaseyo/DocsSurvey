<?php

/**
* Created by Reliese Model.
*/

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
* Class Branding
*
* @property string $id
* @property string $templateId
* @property string|null $logo
* @property string|null $logoCaption
* @property string $bannerTitle
* @property string $bannerSubtext
* @property Carbon $createdAt
* @property Carbon $updatedAt
*
* @property SurveyTemplate $survey_template
*
* @package App\Models
*/
class Branding extends Model
{
	protected $table = 'brandings';
	public $incrementing = false;
	public $timestamps = false;

	protected $dates = [
		'createdAt',
		'updatedAt'
	];

	protected $fillable = [
		'templateId',
		'logo',
		'logoCaption',
		'bannerTitle',
		'bannerSubtext',
		'createdAt',
		'updatedAt'
	];

	public function survey_template()
	{
		return $this->belongsTo(SurveyTemplate::class, 'templateId');
	}
}
