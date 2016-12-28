<?php

try {
    if ($this->eventShouldBeCollected($event)) {
        $this->collectEvent($event);
    }

    $this->fire($event);
} catch (\Exception) {
    // log event errors
}
