<?php

    class FfmpegUtil
    {
        const INFO_QUERY = 'ffprobe.exe -v quiet -print_format json -show_format -show_streams %%FILE_PATH%% 2>&1';

        public static function getVideoInfo($filePath)
        {
            $output = shell_exec(sfConfig::get('app_ffmpeg_path') . str_replace('%%FILE_PATH%%', $filePath, INFO_QUERY));
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

    } // Utils
