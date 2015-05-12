<?php

/**
 * Video filter form base class.
 *
 * @package    rest
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseVideoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'width'         => new sfWidgetFormFilterInput(),
      'height'        => new sfWidgetFormFilterInput(),
      'video_bitrate' => new sfWidgetFormFilterInput(),
      'audio_bitrate' => new sfWidgetFormFilterInput(),
      'user_id'       => new sfWidgetFormPropelChoice(array('model' => 'Users', 'add_empty' => true)),
      'filename'      => new sfWidgetFormFilterInput(),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'name'          => new sfValidatorPass(array('required' => false)),
      'width'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'height'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'video_bitrate' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'audio_bitrate' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'user_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Users', 'column' => 'id')),
      'filename'      => new sfValidatorPass(array('required' => false)),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('video_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Video';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'name'          => 'Text',
      'width'         => 'Number',
      'height'        => 'Number',
      'video_bitrate' => 'Number',
      'audio_bitrate' => 'Number',
      'user_id'       => 'ForeignKey',
      'filename'      => 'Text',
      'created_at'    => 'Date',
      'updated_at'    => 'Date',
    );
  }
}
