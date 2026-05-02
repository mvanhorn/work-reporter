<?php

namespace Igancev\WorkReporter\Config\DestinationConfig;

readonly class YouTrackConfig
{
    public function __construct(
        public string $url,
        public string $token,
    ) {
    }
}
