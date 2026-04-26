<?php

namespace Igancev\WorkReporter\Config\DestinationConfig;

readonly class DestinationsConfig
{
    public function __construct(
        public ?YouTrackConfig $youTrack = null,
    ) {
    }
}
