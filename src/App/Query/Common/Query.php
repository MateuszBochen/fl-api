<?php

namespace App\Query\Common;


class Query
{
    private bool $responseAsArray = false;

    public function setResponseAsArray(): self
    {
        $this->responseAsArray = true;

        return $this;
    }

    public function setResponseAsObject(): self
    {
        $this->responseAsArray = false;

        return $this;
    }

    public function isReturnAsArray(): bool
    {
        return $this->responseAsArray;
    }
}
