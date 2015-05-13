<?php

    class ffmpegUtil
    {
        public static function getVideoInfo($file)
        {
            $info = array(
                "width" => getFileWidth($file),
                "height" => getFileHeight($file),
                "audio_bitrate" => getFileAudioBitrate($file),
                "video_bitrate" => getFileVideoBitrate($file),
            );
            return $info;
        }
        
        private static function getVideoWidth($file)
        {
            // @TODO return video width
            return "640";    
        }
        
        private static function getVideoHeight($file)
        {
            // @TODO return video height
            return "480";    
        }
        
        private static function getVideoAudioBitrate($file)
        {
            // @TODO return audio bitrate
            return "1024";    
        }
        
        private static function getVideoVideoBitrate($file)
        {
            // @TODO return video bitrate
            return "2048";    
        }
        
    } // Utils
