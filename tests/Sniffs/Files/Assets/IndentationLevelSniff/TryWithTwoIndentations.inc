<?php declare(strict_types = 1);

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
        } catch (\Throwable $e) {
            $this->log($e);
        }
    }
}
