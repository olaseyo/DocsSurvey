<?php

/**
* Created by Reliese Model.
*/

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;
use Illuminate\Support\Str;
/**
* Class SurveyTemplate
*
* @property string $id
* @property bool $global
* @property string $name
* @property string $surveyStatus
* @property Carbon|null $lastEvent
* @property int|null $practiceId
* @property int|null $userId
* @property Carbon $createdAt
* @property Carbon $updatedAt
*
* @property Collection|Branding[] $brandings
* @property Collection|SurveyQuestionInputOption[] $survey_question_input_options
* @property Collection|SurveyQuestionInput[] $survey_question_inputs
* @property Collection|SurveyQuestion[] $survey_questions
* @property Collection|SurveySection[] $survey_sections
* @property Collection|SurveySubSection[] $survey_sub_sections
*
* @package App\Models
*/
class SurveyTemplate extends Model
{
	protected static function boot()
	{
		parent::boot();
		$model=new SurveyTemplate();

		$model->setKeyType('string');

		$model->setIncrementing(false);

		$model->setAttribute($model->getKeyName(), Str::uuid());
		//print_r($model);die;
	}

	//use UsesUuid;
	protected $table = 'survey_templates';
	//protected $primaryKey='id';
	public $incrementing = false;
	public $timestamps = false;


	protected $casts = [
		'global' => 'bool',
		'practiceId' => 'int',
		'userId' => 'int'
	];

	protected $dates = [
		'lastEvent',
		'createdAt',
		'updatedAt'
	];

	protected $fillable = [
		'id',
		'global',
		'name',
		'surveyStatus',
		'lastEvent',
		'practiceId',
		'userId',
		'createdAt',
		'updatedAt'
	];


	public function brandings()
	{
		return $this->hasOne(Branding::class, 'templateId');
	}

	public function survey_question_input_options()
	{
		return $this->hasMany(SurveyQuestionInputOption::class, 'templateId');
	}

	public function survey_question_inputs()
	{
		return $this->hasMany(SurveyQuestionInput::class, 'templateId');
	}

	public function survey_questions()
	{
		return $this->hasMany(SurveyQuestion::class, 'templateId');
	}

	public function survey_sections()
	{
		return $this->hasMany(SurveySection::class, 'templateId');
	}

	public function survey_sub_sections()
	{
		return $this->hasMany(SurveySubSection::class, 'templateId');
	}
}
