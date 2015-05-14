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
                "file" => new sfValidatorFile(
                    array(
                        "required" => true, 
                        "mime_types" => 
                            array(
                                "video/mpeg",
                                "video/mp4",
                                "video/ogg",
                                "video/quicktime",
                                "video/webm",
                                "video/x-ms-wmv",
                                "video/x-flv",
                                "video/x-msvideo"
                            )
                    )
                )
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
            $videoPath = sfConfig::get('app_video_path');
            $fileName = $videoPath . $sfValidatedFile->generateFilename();
            return $sfValidatedFile->save($fileName);
        }
    }

