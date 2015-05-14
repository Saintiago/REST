<?php

    class ffmpegUtil
    {
        public static function getVideoInfo($file)
        {
            $output = shell_exec(sfConfig::get('app_ffmpeg_path') . 'ffprobe.exe -v quiet -print_format json -show_format -show_streams ' . $file . ' 2>&1');
            $parsed = json_decode($output, true);
            $info = array(
                "width" => $parsed["streams"][0]["width"],
                "height" => $parsed["streams"][0]["height"],
                "audio_bitrate" => $parsed["streams"][1]["bit_rate"],
                "video_bitrate" => $parsed["format"]["bit_rate"]
            );
            return $info;
        }
        
    } // Utils
