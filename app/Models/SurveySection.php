<?php

/**
* Created by Reliese Model.
*/

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
* Class SurveySection
*
* @property string $id
* @property string $templateId
* @property int $order
* @property string $title
* @property string $subtext
* @property string|null $icon
* @property Carbon $createdAt
* @property Carbon $updatedAt
*
* @property SurveyTemplate $survey_template
* @property Collection|SurveyQuestionInputOption[] $survey_question_input_options
* @property Collection|SurveyQuestionInput[] $survey_question_inputs
* @property Collection|SurveyQuestion[] $survey_questions
* @property Collection|SurveySubSection[] $survey_sub_sections
*
* @package App\Models
*/
class SurveySection extends Model
{
	protected $table = 'survey_sections';
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
		'order',
		'title',
		'subtext',
		'icon',
		'createdAt',
		'updatedAt'
	];

	public function survey_template()
	{
		return $this->belongsTo(SurveyTemplate::class, 'templateId');
	}

	public function survey_question_input_options()
	{
		return $this->hasMany(SurveyQuestionInputOption::class, 'surveySectionId');
	}

	public function survey_question_inputs()
	{
		return $this->hasMany(SurveyQuestionInput::class, 'surveySectionId');
	}

	public function survey_questions()
	{
		return $this->hasMany(SurveyQuestion::class, 'surveySectionId');
	}

	public function survey_sub_sections()
	{
		return $this->hasMany(SurveySubSection::class, 'surveySectionId');
	}
}
