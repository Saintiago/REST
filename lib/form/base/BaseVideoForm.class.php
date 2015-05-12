<?php

/**
 * Video form base class.
 *
 * @method Video getObject() Returns the current form's model object
 *
 * @package    rest
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseVideoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'name'          => new sfWidgetFormInputText(),
      'width'         => new sfWidgetFormInputText(),
      'height'        => new sfWidgetFormInputText(),
      'video_bitrate' => new sfWidgetFormInputText(),
      'audio_bitrate' => new sfWidgetFormInputText(),
      'user_id'       => new sfWidgetFormPropelChoice(array('model' => 'Users', 'add_empty' => false)),
      'filename'      => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'          => new sfValidatorString(array('max_length' => 255)),
      'width'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'height'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'video_bitrate' => new sfValidatorNumber(array('required' => false)),
      'audio_bitrate' => new sfValidatorNumber(array('required' => false)),
      'user_id'       => new sfValidatorPropelChoice(array('model' => 'Users', 'column' => 'id')),
      'filename'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
      'updated_at'    => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('video[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Video';
  }


}
