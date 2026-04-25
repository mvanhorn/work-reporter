<?php

declare(strict_types=1);

namespace Igancev\WorkReporter\Source;

use Igancev\WorkReporter\Source\PlainJson\PlainJsonTimeEntriesSource;
use Igancev\WorkReporter\Source\SuperProductivity\SuperProductivitySyncSource;

final readonly class ConcreteSourceFactory implements TimeEntriesSourceFactory
{
    public function build(string $source): TimeEntriesSource
    {
        return match ($source) {
            'plain-json' => $this->buildPlainJsonSource(),
            'super-productivity' => $this->buildFromSuperProductivitySource(),
            default => throw new \InvalidArgumentException('Unknown source: ' . $source),
        };
    }

    private function buildPlainJsonSource(): PlainJsonTimeEntriesSource
    {
        // todo: load from config
        return new PlainJsonTimeEntriesSource('../jsonList.json');
    }

    private function buildFromSuperProductivitySource(): SuperProductivitySyncSource
    {
        // todo: load from config
        $superProductivitySyncFile = '~/.config/superProductivity/backups/sync/__meta_';

        return new SuperProductivitySyncSource($superProductivitySyncFile);
    }
}
