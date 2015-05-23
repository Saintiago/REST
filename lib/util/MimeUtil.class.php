<?php

    class MimeUtil
    {
        const MPEG = "video/mpeg";
        const MP4 = "video/mp4";
        const OGG = "video/ogg";
        const MOV = "video/quicktime";
        const WEBM = "video/webm";
        const WMV = "video/x-ms-wmv";
        const FLV = "video/x-flv";
        const AVI = "video/x-msvideo";
        
        const FLV_EXT = 'flv';
        const MP4_EXT = 'mp4';
        
        public static function getVideoMimes()
        {
            return array(self::MPEG, self::MP4, self::OGG, self::MOV, self::WEBM, self::WMV, self::FLV, self::AVI);
        }
        
    } // Utils
