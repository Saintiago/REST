<?php
    class QueuePeer extends BaseQueuePeer
    {
        const MAX_SLOTS = 5;
        
        
        public static function getFreeSlots()
        {
            $criteria = new Criteria;
            $criteria->add(QueuePeer::STATUS, StatusPeer::IN_PROGRESS, Criteria::EQUAL);
            $queue = new QueuePeer;
            $slotsInUse = $queue->doCount($criteria);
            return self::MAX_SLOTS - $slotsInUse;
        }
        
        public static function getQueue($limit)
        {
            $criteria = new Criteria;
            $criteria->add(QueuePeer::STATUS, StatusPeer::ON_QUEUE, Criteria::EQUAL);
            $criteria->setLimit($limit);
            $queue = new QueuePeer;
            return $queue->doSelect($criteria);
        }
        
        public static function getQueuedVideoIds($limit)
        {
            $criteria = new Criteria;
            $criteria->add(QueuePeer::STATUS, StatusPeer::ON_QUEUE, Criteria::EQUAL);
            $criteria->setLimit($limit);
            $queue = new QueuePeer;
            $queueItems = $queue->doSelect($criteria);
            $videoIds = array();
            foreach ($queueItems as $queueItem) 
            {
                $videoIds[] = $queueItem->getVideoId();
            }
            return $videoIds;
        }
        
        public static function addToConvertQueue(Video $video)
        {
            $queueElement = new Queue;
            $queueElement->setStatus(1);
            $queueElement->setVideoId($video->getId());
            $queueElement->save();
        }
    } // QueuePeer
