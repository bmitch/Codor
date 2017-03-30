<?php declare(strict_types = 1);

class TryCatchWithIfInCatch
{
    public function doSomething()
    {
        try {
            $this->response = $this->guzzle->request($method, $uri, $options);
            // etc..
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 404) {
                throw VacancyIsClosed::forId($vacancyId);
            }
        }
    }
}
