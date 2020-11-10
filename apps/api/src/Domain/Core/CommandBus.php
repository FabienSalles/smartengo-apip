<?php

namespace Smartengo\Domain\Core;

interface CommandBus
{
    /**
     * @todo should return void but we can't do it now because API Platform need the returned object in order to render a response
     *
     * @param mixed $command
     *
     * @return mixed
     */
    public function handle($command);
}
