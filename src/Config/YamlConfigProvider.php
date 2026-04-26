<?php

namespace Igancev\WorkReporter\Config;

use Igancev\WorkReporter\Config\DestinationConfig\DestinationsConfig;
use Igancev\WorkReporter\Config\DestinationConfig\YouTrackConfig;
use Igancev\WorkReporter\Config\SourceConfig\PlainJsonConfig;
use Igancev\WorkReporter\Config\SourceConfig\SourcesConfig;
use Igancev\WorkReporter\Config\SourceConfig\SuperProductivityConfig;
use Igancev\WorkReporter\Destination\DestinationType;
use Igancev\WorkReporter\Source\SourceType;
use RuntimeException;
use Symfony\Component\Yaml\Yaml;

class YamlConfigProvider implements ConfigProvider
{
    private ?Config $config = null;

    public function __construct(
        private readonly string $configPath = "~/.config/work-reporter/config.yaml"
    ) {
    }

    public function get(): Config
    {
        if ($this->config !== null) {
            return $this->config;
        }

        $path = str_replace("~", (string)getenv("HOME"), $this->configPath);

        if (!file_exists($path)) {
            throw new RuntimeException(sprintf("Configuration file not found at: %s", $path));
        }

        $data = Yaml::parseFile($path);

        $this->config = new Config(
            SourceType::from($data["source"]),
            DestinationType::from($data["destination"]),
            new SourcesConfig(
                isset($data["sources"]["superProductivity"])
                    ? new SuperProductivityConfig($data["sources"]["superProductivity"]["syncFilePath"])
                    : null,
                isset($data["sources"]["plainJson"])
                    ? new PlainJsonConfig($data["sources"]["plainJson"]["filePath"])
                    : null
            ),
            new DestinationsConfig(
                isset($data["destinations"]["youTrack"])
                    ? new YouTrackConfig(
                        $data["destinations"]["youTrack"]["url"],
                        $data["destinations"]["youTrack"]["token"]
                    )
                    : null
            )
        );

        return $this->config;
    }
}
