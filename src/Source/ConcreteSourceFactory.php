<?php

declare(strict_types=1);

namespace Igancev\WorkReporter\Source;

use Igancev\WorkReporter\Config\ConfigProvider;
use Igancev\WorkReporter\Source\PlainJson\PlainJsonTimeEntriesSource;
use Igancev\WorkReporter\Source\SuperProductivity\SuperProductivitySyncSource;
use RuntimeException;

final readonly class ConcreteSourceFactory implements TimeEntriesSourceFactory
{
    public function __construct(
        private ConfigProvider $configProvider,
    ) {
    }

    public function build(SourceType $source): TimeEntriesSource
    {
        return match ($source) {
            SourceType::PlainJson => $this->buildPlainJsonSource(),
            SourceType::SuperProductivity => $this->buildFromSuperProductivitySource(),
        };
    }

    private function buildPlainJsonSource(): PlainJsonTimeEntriesSource
    {
        $config = $this->configProvider->get()->sources->plainJson;
        if ($config === null) {
            throw new RuntimeException("PlainJson source configuration is missing");
        }

        return new PlainJsonTimeEntriesSource($config->filePath);
    }

    private function buildFromSuperProductivitySource(): SuperProductivitySyncSource
    {
        $config = $this->configProvider->get()->sources->superProductivity;
        if ($config === null) {
            throw new RuntimeException("SuperProductivity source configuration is missing");
        }

        return new SuperProductivitySyncSource($config->syncFilePath);
    }
}
