<?php
    class Converter extends sfBaseTask
    {
        public function configure()
        {
            $this->namespace = 'converter';
            $this->name = 'check-queue';
            
            $this->addOptions(array(
                new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'environment', 'dev'),
                new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
            ));
        }
        
        public function execute($arguments = array(), $options = array())
        {
            $databaseManager = new sfDatabaseManager(sfProjectConfiguration::getApplicationConfiguration('frontend', $options['env'], true));
            $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
            
            $slots = QueuePeer::getFreeSlots();
            if ($slots > 0)
            {
                $queue = QueuePeer::GetQueue($slots);
                foreach ($queue as $queueItem)
                {
                    $videoId = $queueItem->getVideoId();
                    $video = VideoPeer::retrieveByPK($videoId);
                    $queueItem->setStatus(StatusPeer::IN_PROGRESS);
                    $queueItem->save();
                    $result = FfmpegUtil::convertFlvToMp4($video);
                    if ($result == true)
                    {
                        if ($converted = VideoPeer::AddConverted($video))
                        {
                            if (VideoLinkPeer::AddLink($video, $converted))
                                $queueItem->setStatus(StatusPeer::SUCCESS);
                        }
                    }
                    else
                    {
                        $queueItem->setStatus(StatusPeer::FAILURE);
                    }
                        
                    $queueItem->save();
                }
            }
        }

    }
