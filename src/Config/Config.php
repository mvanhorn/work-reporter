<?php

namespace Igancev\WorkReporter\Config;

use Igancev\WorkReporter\Config\DestinationConfig\DestinationsConfig;
use Igancev\WorkReporter\Config\SourceConfig\SourcesConfig;
use Igancev\WorkReporter\Source\SourceType;
use Igancev\WorkReporter\Destination\DestinationType;

readonly class Config
{
    public function __construct(
        public SourceType $source,
        public DestinationType $destination,
        public SourcesConfig $sources,
        public DestinationsConfig $destinations,
    ) {
    }
}
