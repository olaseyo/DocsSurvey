<?php

/**
* Created by Reliese Model.
*/

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
* Class SurveySubSection
*
* @property string $id
* @property string $templateId
* @property string $surveySectionId
* @property int $order
* @property string $title
* @property string|null $icon
* @property Carbon $createdAt
* @property Carbon $updatedAt
*
* @property SurveySection $survey_section
* @property SurveyTemplate $survey_template
* @property Collection|SurveyQuestionInputOption[] $survey_question_input_options
* @property Collection|SurveyQuestionInput[] $survey_question_inputs
* @property Collection|SurveyQuestion[] $survey_questions
*
* @package App\Models
*/
class SurveySubSection extends Model
{
	protected $table = 'survey_sub_sections';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'order' => 'int'
	];

	protected $dates = [
		'createdAt',
		'updatedAt'
	];

	protected $fillable = [
		'templateId',
		'surveySectionId',
		'order',
		'title',
		'icon',
		'createdAt',
		'updatedAt'
	];

	public function survey_section()
	{
		return $this->belongsTo(SurveySection::class, 'surveySectionId');
	}

	public function survey_template()
	{
		return $this->belongsTo(SurveyTemplate::class, 'templateId');
	}

	public function survey_question_input_options()
	{
		return $this->hasMany(SurveyQuestionInputOption::class, 'surveySubSectionId');
	}

	public function survey_question_inputs()
	{
		return $this->hasMany(SurveyQuestionInput::class, 'surveySubSectionId');
	}

	public function survey_questions()
	{
		return $this->hasMany(SurveyQuestion::class, 'surveySubSectionId');
	}
}
