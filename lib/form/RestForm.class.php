<?php

    /**
     * Video form.
     *
     * @package    rest
     * @subpackage form
     * @author     Your name here
     */
    class RestForm extends BaseVideoForm
    {
        public function configure()
        {
            $this->setWidgets(array(
              'name'    => new sfWidgetFormInputText(),
              'file'    => new sfWidgetFormInputFile()
            ));
            
            $this->setValidators(array(
                "name" => new sfValidatorString(array("required" => true)),
                "file" => new sfValidatorFile(array("required" => true))
            ));
            
            $this->addCSRFProtection();
            
            $this->getWidgetSchema()->setNameFormat('video[%s]');
        }

    }

