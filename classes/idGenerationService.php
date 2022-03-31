<?php
class idGenerationService {
    private $lastTimestamp;
    private $sequence;
    private $workerIdShift;
    private $datacenterIdShift;
    private $timestampLeftShift;
    private $sequenceMask;
    private $sequenceBits = 12;
    private $workerId = 6;
    private $datacenterId = 4;
    public $errors = array();
    public $epoch = 1308122327000;

    public function create() {
        $this->workerIdShift = $this->sequenceBits;
        $this->datacenterIdShift = $this->sequenceBits + $this->workerId;
        $this->timestampLeftShift = $this->sequenceBits + $this->workerId + $this->datacenterId;
        $this->sequenceMask = -1 ^ (-1 << $this->sequenceBits);

        $timestamp = $this->getTimestampMiliseconds();
        if($timestamp < $this->lastTimestamp) {
            $errors[] = "Clock moved backwards. Refusing to generate ID for " . ($this->lastTimestamp - $timestamp) . " milliseconds.";
        }
        if($this->lastTimestamp == $timestamp) {
            $this->sequence = ($this->sequence + 1) & $this->sequenceMask;
            if($this->sequence == 0) {
                $timestamp = $this->getNextMillisecond($this->lastTimestamp);
            }
        } else {
            $this->sequence = 0;
        }
        $this->timestampLeftShift = (1 << $timestamp);
        $this->lastTimestamp = $timestamp;
        return ($timestamp << $this->timestampLeftShift) + ($this->datacenterId << $this->datacenterIdShift) + ($this->workerId << $this->workerIdShift) + $this->sequence;
    }

    public function idToTimestamp($currentID) {
        return round((($currentID) - $this->epoch - (4 << 18)+39000)/1000);
    }

    private function getNextMillisecond() {
        $timestamp = $this->getTimestampMiliseconds();
        while($timestamp < $this->lastTimestamp) {
            $timestamp = $this->getTimestampMiliseconds();
        }

        return $timestamp;
    }

    private function getTimestampMiliseconds() {
        return round(microtime(true) * 1000) + $this->epoch;
    }
}
?>