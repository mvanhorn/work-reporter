<?php

declare(strict_types=1);

namespace Igancev\WorkReporter\Destination;

use Amp\Http\Client\Connection\DefaultConnectionFactory;
use Amp\Http\Client\Connection\UnlimitedConnectionPool;
use Amp\Http\Client\HttpClientBuilder;
use Amp\Socket\DnsSocketConnector;
use Igancev\WorkReporter\Config\ConfigProvider;
use Igancev\WorkReporter\Destination\YouTrack\YouTrackDestination;
use RuntimeException;

final readonly class ConcreteDestinationFactory implements DestinationFactory
{
    public function __construct(
        private ConfigProvider $configProvider,
    ) {
    }

    public function build(DestinationType $destination): Destination
    {
        return match ($destination) {
            DestinationType::YouTrack => $this->buildYouTrackDestination(),
        };
    }

    private function buildYouTrackDestination(): YouTrackDestination
    {
        $config = $this->configProvider->get()->destinations->youTrack;
        if ($config === null) {
            throw new RuntimeException("YouTrack destination configuration is missing");
        }

        return new YouTrackDestination(
            new HttpClientBuilder()
                ->usingPool(
                    new UnlimitedConnectionPool(new DefaultConnectionFactory(new DnsSocketConnector()))
                )
                ->build(),
            $config->url,
            $config->token,
        );
    }
}
