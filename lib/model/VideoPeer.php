<?php
    class VideoPeer extends BaseVideoPeer
    {
        const CONVERTED_MARK = " (converted)";
        
        public static function AddConverted(Video $video)
        {
            $filePath = $video->getFilename();
            $convertedPath = FfmpegUtil::getConvertedFilePath($filePath);
            $info = FfmpegUtil::getVideoInfo($filePath);
            
            $converted = new Video;
            $converted->setName($video->getName() . self::CONVERTED_MARK);
            $converted->setFilename($convertedPath);
            $converted->setWidth($info['width']);
            $converted->setHeight($info['height']);
            $converted->setAudioBitrate($info['audio_bitrate']);
            $converted->setVideoBitrate($info['video_bitrate']);
            $converted->setUserId($video->getUserId());
            $converted->save();
            return $converted;
        }
    } // VideoPeer
