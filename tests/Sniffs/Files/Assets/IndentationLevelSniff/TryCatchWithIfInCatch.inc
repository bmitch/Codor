<?php

try {
    $this->response = $this->guzzle->request(...);
    // etc..
} catch (\GuzzleHttp\Exception\ClientException $e) {
    if ($e->getResponse()->getStatusCode() == 404) {
        throw VacancyIsClosed::forId($vacancyId);
    }
}