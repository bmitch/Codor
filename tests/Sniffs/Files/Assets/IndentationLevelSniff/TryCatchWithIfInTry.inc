<?php declare(strict_types = 1);

class TryCatchWithIfInTry
{
    public function doSomething($event)
    {
        try {
            if ($this->eventShouldBeCollected($event)) {
                $this->collectEvent($event);
            }

            $this->fire($event);
        } catch (\Throwable $e) {
            $this->log($e);
        }
    }
}
