<?php

namespace Igancev\WorkReporter\Config\SourceConfig;

readonly class SuperProductivityConfig
{
    public function __construct(
        public string $syncFilePath,
    ) {
    }
}
