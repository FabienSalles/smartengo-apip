<?php

namespace Smartengo\Domain\Core;

interface QueryBus
{
    /**
     * @param mixed $query
     *
     * @return mixed
     */
    public function handle($query);
}
