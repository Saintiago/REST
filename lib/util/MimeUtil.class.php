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
        
        private function getVideoMimes()
        {
            return array(MPEG, MP4, OGG, MOV, WEBM, WMV, FLV, AVI);
        }

    } // Utils
