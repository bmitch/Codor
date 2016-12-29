<?php

class TryWithTwoIndentations
{
    public function doSomething($event)
    {
        try {
            foreach (range(1, 5) as $id) {
                if ($id > 2) {
                    $this->fireTheAlarms($event);
                }
            }

            $this->fire($event);
        } catch (\Exception $e) {
            $this->log($e);
        }
    }
}
