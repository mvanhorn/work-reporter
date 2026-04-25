<?php

declare(strict_types=1);

namespace Igancev\WorkReporter\Destination;

interface DestinationFactory
{
    public function build(string $destination): Destination;
}
