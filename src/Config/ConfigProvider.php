<?php

namespace Igancev\WorkReporter\Config;

interface ConfigProvider
{
    public function get(): Config;
}
