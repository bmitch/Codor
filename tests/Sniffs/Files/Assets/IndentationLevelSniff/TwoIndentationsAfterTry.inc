<?php declare(strict_types = 1);

class TwoIndentationsAfterTry
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

        foreach (range(1, 5) as $id) {
            if ($id > 2) {
                $this->fireTheAlarms($event);
            }
        }
    }
}
