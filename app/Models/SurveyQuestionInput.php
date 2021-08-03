<?php

/**
* Created by Reliese Model.
*/

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
* Class SurveyQuestionInput
*
* @property string $id
* @property string $templateId
* @property string $surveySectionId
* @property string $surveySubSectionId
* @property string $surveyQuestionId
* @property string $type
* @property Carbon $createdAt
* @property Carbon $updatedAt
*
* @property SurveyQuestion $survey_question
* @property SurveySection $survey_section
* @property SurveySubSection $survey_sub_section
* @property SurveyTemplate $survey_template
* @property Collection|SurveyQuestionInputOption[] $survey_question_input_options
*
* @package App\Models
*/
class SurveyQuestionInput extends Model
{
	protected $table = 'survey_question_inputs';
	public $incrementing = false;
	public $timestamps = false;

	protected $dates = [
		'createdAt',
		'updatedAt'
	];

	protected $fillable = [
		'templateId',
		'surveySectionId',
		'surveySubSectionId',
		'surveyQuestionId',
		'type',
		'createdAt',
		'updatedAt'
	];

	public function survey_question()
	{
		return $this->belongsTo(SurveyQuestion::class, 'surveyQuestionId');
	}

	public function survey_section()
	{
		return $this->belongsTo(SurveySection::class, 'surveySectionId');
	}

	public function survey_sub_section()
	{
		return $this->belongsTo(SurveySubSection::class, 'surveySubSectionId');
	}

	public function survey_template()
	{
		return $this->belongsTo(SurveyTemplate::class, 'templateId');
	}

	public function survey_question_input_options()
	{
		return $this->hasMany(SurveyQuestionInputOption::class, 'surveyQuestionInputId');
	}
}
