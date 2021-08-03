<?php

/**
* Created by Reliese Model.
*/

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
* Class SurveyQuestionInputOption
*
* @property string $id
* @property string $templateId
* @property string $surveySectionId
* @property string $surveySubSectionId
* @property string $surveyQuestionId
* @property string $surveyQuestionInputId
* @property string $display
* @property string $value
* @property int $order
* @property bool $isDefault
* @property Carbon $createdAt
* @property Carbon $updatedAt
*
* @property SurveyQuestion $survey_question
* @property SurveyQuestionInput $survey_question_input
* @property SurveySection $survey_section
* @property SurveySubSection $survey_sub_section
* @property SurveyTemplate $survey_template
*
* @package App\Models
*/
class SurveyQuestionInputOption extends Model
{
	protected $table = 'survey_question_input_options';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'order' => 'int',
		'isDefault' => 'bool'
	];

	protected $dates = [
		'createdAt',
		'updatedAt'
	];

	protected $fillable = [
		'templateId',
		'surveySectionId',
		'surveySubSectionId',
		'surveyQuestionId',
		'surveyQuestionInputId',
		'display',
		'value',
		'order',
		'isDefault',
		'createdAt',
		'updatedAt'
	];

	public function survey_question()
	{
		return $this->belongsTo(SurveyQuestion::class, 'surveyQuestionId');
	}

	public function survey_question_input()
	{
		return $this->belongsTo(SurveyQuestionInput::class, 'surveyQuestionInputId');
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
}
