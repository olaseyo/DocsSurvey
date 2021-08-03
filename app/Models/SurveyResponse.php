<?php

/**
* Created by Reliese Model.
*/

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
* Class SurveyResponse
*
* @property string $id
* @property string $surveyQuestionId
* @property string $value
* @property Carbon $createdAt
* @property Carbon $updatedAt
*
* @property SurveyQuestion $survey_question
*
* @package App\Models
*/
class SurveyResponse extends Model
{
	protected $table = 'survey_responses';
	public $incrementing = false;
	public $timestamps = false;

	protected $dates = [
		'createdAt',
		'updatedAt'
	];

	protected $fillable = [
		'id',
		'surveyQuestionId',
		'templateId',
		'value',
		'createdAt',
		'updatedAt'
	];

	public function survey_question()
	{
		return $this->belongsTo(SurveyQuestion::class, 'surveyQuestionId');
	}
}
