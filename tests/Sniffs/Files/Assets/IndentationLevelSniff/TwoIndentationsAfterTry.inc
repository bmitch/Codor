<?php

class TwoIndentationsAfterTry
{
    public function doSomething($event)
    {
        try {
            if ($this->eventShouldBeCollected($event)) {
                $this->collectEvent($event);
            }

            $this->fire($event);
        } catch (\Exception $e) {
            $this->log($e);
        }

        foreach (range(1, 5) as $id) {
            if ($id > 2) {
                $this->fireTheAlarms($event);
            }
        }
    }
}
