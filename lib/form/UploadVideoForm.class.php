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
            
            $allowedMimes = MimeUtil::GetVideoMimes();
            
            $this->setValidators(array(
                "name" => new sfValidatorString(array("required" => true)),
                "file" => new sfValidatorFile(
                    array(
                        "required" => true, 
                        "mime_types" => $allowedMimes
                    )
                )
            ));
            
            $this->disableCSRFProtection();
            
            $this->getWidgetSchema()->setNameFormat('video[%s]');
        }
        
        protected function doSave($con = null)
        {
            $fileName = $this->moveUploadedFile($this->getValue("file"));
            $userId = $this->getOption('user_id');
            $this->prepareVideoInfo($fileName, $userId);
            
            parent::doSave($con);
        }
        
        private function moveUploadedFile($sfValidatedFile)
        {
            $videoPath = sfConfig::get('app_video_path');
            $fileName = $videoPath . $sfValidatedFile->generateFilename();
            return $sfValidatedFile->save($fileName);
        }
        
        private function prepareVideoInfo($fileName, $userId)
        {
            /** @var array $info */
            $info = FfmpegUtil::getVideoInfo($this->getValue("file"));

            $object = $this->getObject();
            $object->setName($this->getValue("name"));
            $object->setFilename($fileName);
            $object->setWidth($info['width']);
            $object->setHeight($info['height']);
            $object->setAudioBitrate($info['audio_bitrate']);
            $object->setVideoBitrate($info['video_bitrate']);
            $object->setUserId($userId);
        }
        
        private function convertFlvToMp4()
        {
            //
        }
        
    }

