<?php

namespace Igancev\WorkReporter\Config\SourceConfig;

readonly class SourcesConfig
{
    public function __construct(
        public ?SuperProductivityConfig $superProductivity = null,
        public ?PlainJsonConfig $plainJson = null,
    ) {
    }
}
