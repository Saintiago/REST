<?php

    class FfmpegUtil
    {
        const INFO_QUERY = 'ffprobe -v quiet -print_format json -show_format -show_streams %%FILE_PATH%% 2>&1';
        const CONV_QUERY = 'ffmpeg -v quiet -y -i %%INPUT%% %%OUTPUT%%';

        public static function getVideoInfo($filePath)
        {
            $output = shell_exec(sfConfig::get('app_ffmpeg_path') . str_replace('%%FILE_PATH%%', $filePath, self::INFO_QUERY));
            $parsed = json_decode($output, true);
            $info = array();
            if (json_last_error() == JSON_ERROR_NONE)
            {
                $videoStream = $parsed["streams"][0];
                $audioStream = $parsed["streams"][1];
                $videoFormat = $parsed["format"];
                $info = array(
                    "width" => $videoStream["width"],
                    "height" => $videoStream["height"],
                    "audio_bitrate" => $audioStream["bit_rate"],
                    "video_bitrate" => $videoFormat["bit_rate"]
                );
            }
            return $info;
        }
        
        public static function convertFlvToMp4(Video $video)
        {
            $filePath = $video->getFilename();
            $output = self::getConvertedFilePath($filePath);
            
            $query = str_replace('%%INPUT%%', $filePath, self::CONV_QUERY);
            $query = str_replace('%%OUTPUT%%', $output, $query);
            exec(sfConfig::get('app_ffmpeg_path') . $query, $execOutput, $return);
            return $return != 0 ? false : true;
        }
        
        public static function getConvertedFilePath($filePath)
        {
            $pathParts = pathinfo($filePath);
            return $pathParts['dirname'] . '/' . $pathParts['filename'] . '.' . MimeUtil::MP4_EXT;
        }

    } // Utils
