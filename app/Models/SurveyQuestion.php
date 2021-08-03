<?php

/**
* Created by Reliese Model.
*/

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
* Class SurveyQuestion
*
* @property string $id
* @property string $templateId
* @property string $surveySectionId
* @property string $surveySubSectionId
* @property int $order
* @property string|null $slug
* @property string $prompt
* @property bool $required
* @property Carbon $createdAt
* @property Carbon $updatedAt
*
* @property SurveySection $survey_section
* @property SurveySubSection $survey_sub_section
* @property SurveyTemplate $survey_template
* @property Collection|SurveyQuestionInputOption[] $survey_question_input_options
* @property Collection|SurveyQuestionInput[] $survey_question_inputs
* @property Collection|SurveyResponse[] $survey_responses
*
* @package App\Models
*/
class SurveyQuestion extends Model
{
	protected $table = 'survey_questions';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'order' => 'int',
		'required' => 'bool'
	];

	protected $dates = [
		'createdAt',
		'updatedAt'
	];

	protected $fillable = [
		'templateId',
		'surveySectionId',
		'surveySubSectionId',
		'order',
		'slug',
		'prompt',
		'required',
		'createdAt',
		'updatedAt'
	];

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
		return $this->hasMany(SurveyQuestionInputOption::class, 'surveyQuestionId');
	}

	public function survey_question_inputs()
	{
		return $this->hasMany(SurveyQuestionInput::class, 'surveyQuestionId');
	}

	public function survey_responses()
	{
		return $this->hasMany(SurveyResponse::class, 'surveyQuestionId');
	}
}
