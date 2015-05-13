<?php

    /**
     * Video form.
     *
     * @package    rest
     * @subpackage form
     * @author     Your name here
     */
    class UploadVideoForm extends BaseVideoForm
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
        
        protected function doSave($con = null)
        {
            /*
             * 1. move uploaded file
             * <id>.<extension>
             * <extension> must be validated
             * $this->moveUploadedFile();
             *
             * 2. run ffmpeg via shell_exec
             *
             * 3. get info from ffmpeg
             * $info = $this->getVideoInfo();
             *
             * 4. save to db
             * parent::doSave($con);
             */
             
            $fileName = $this->moveUploadedFile($this->getValue("file"));
            $userID = $this->getUserId();
            
            $this->prepareVideoInfo($fileName, $userID);
            
            parent::doSave($con);
        }

        private function convertFlvToMp4()
        {
            //
        }

        /**
         * @return array
         */
        private function prepareVideoInfo($fileName, $userID)
        {
            /** @var array $info */
            $info = ffmpegUtil::getVideoInfo($this->getValue("file"));

            $object = $this->getObject();
            $object->setName($this->getValue("name"));
            $object->setFilename($fileName);
            $object->setWidth($info['width']);
            $object->setHeight($info['height']);
            $object->setAudioBitrate($info['audio_bitrate']);
            $object->setVideoBitrate($info['video_bitrate']);
            $object->setUserId($userID);
        }
        
        private static function getUserId()
        {
            // @TODO return current user ID
            return "1";    
        }
        
        private function moveUploadedFile($sfValidatedFile)
        {
            // @TODO generate filename: <id>.<extension>
            $filename = $sfValidatedFile->getOriginalName();
            return $sfValidatedFile->save(sfConfig::get('app_video_path') . $filename);
        }

    }

