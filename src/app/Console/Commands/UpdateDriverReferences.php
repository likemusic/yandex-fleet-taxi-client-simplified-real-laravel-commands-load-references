<?php

namespace Likemusic\Yandex\FleetTaxi\Client\Simplified\Real\Laravel\Commands\Console\Commands;

use Likemusic\Yandex\FleetTaxi\Client\Simplified\Real\Laravel\Commands\Console\Commands\UpdateDriverReferences\CitiesGenerator;
use Illuminate\Console\Command;
use Likemusic\YandexFleetTaxiClient\Contracts\LanguageInterface;
use Likemusic\YandexFleetTaxiClientSimplified\Contracts\ClientInterface as YandexClientInterface;

class UpdateDriverReferences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fleet:driver-references:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate driver references data (license issue countries) by Yandex-provided data.';

    /**
     * @var CitiesGenerator
     */
    private $driverLicenseIssueCitiesGenerator;

    /**
     * @var YandexClientInterface
     */
    private $yandexClient;

    /**
     * Create a new command instance.
     *
     * @param CitiesGenerator $driverLicenseIssueCitiesGenerator
     * @param YandexClientInterface $yandexClient
     */
    public function __construct(
        CitiesGenerator $driverLicenseIssueCitiesGenerator,
        YandexClientInterface $yandexClient
    ) {
        $this->driverLicenseIssueCitiesGenerator = $driverLicenseIssueCitiesGenerator;
        $this->yandexClient = $yandexClient;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->generateCities($yandexClient);

        return true;
    }

    private function generateCities(YandexClientInterface $yandexClient)
    {
        return $this->driverLicenseIssueCitiesGenerator->generateItems($yandexClient);
    }
}
