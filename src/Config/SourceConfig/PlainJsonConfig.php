<?php

namespace Igancev\WorkReporter\Config\SourceConfig;

readonly class PlainJsonConfig
{
    public function __construct(
        public string $filePath,
    ) {
    }
}
