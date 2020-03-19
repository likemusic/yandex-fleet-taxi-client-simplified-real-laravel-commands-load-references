<?php

namespace Likemusic\Yandex\FleetTaxi\Client\Simplified\Real\Laravel\Commands\Console\Commands;

use Illuminate\Console\Command;
use Likemusic\Yandex\FleetTaxi\Client\Simplified\Real\Laravel\Commands\Console\Commands\UpdateCarReferences\BrandModelsGenerator;
use Likemusic\Yandex\FleetTaxi\Client\Simplified\Real\Laravel\Commands\Console\Commands\UpdateCarReferences\BrandsGenerator;
use Likemusic\Yandex\FleetTaxi\Client\Simplified\Real\Laravel\Commands\Console\Commands\UpdateCarReferences\ColorsGenerator;
use Likemusic\YandexFleetTaxiClientSimplified\Contracts\ClientInterface as YandexClientInterface;

class UpdateCarReferences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fleet:car-references:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate car references (brands and models) data by Yandex-provided data.';

    /**
     * @var BrandsGenerator
     */
    private $brandsGenerator;

    /**
     * @var BrandModelsGenerator
     */
    private $brandModelsGenerator;

    /**
     * @var ColorsGenerator
     */
    private $colorsGenerator;

    /**
     * @var YandexClientInterface
     */
    private $yandexClient;

    /**
     * Create a new command instance.
     *
     * @param ColorsGenerator $colorsGenerator
     * @param BrandsGenerator $carBrandsGenerator
     * @param BrandModelsGenerator $carBrandModelsGenerator
     * @param YandexClientInterface $yandexClient
     */
    public function __construct(
        ColorsGenerator $colorsGenerator,
        BrandsGenerator $carBrandsGenerator,
        BrandModelsGenerator $carBrandModelsGenerator,
        YandexClientInterface $yandexClient
    )
    {
        $this->colorsGenerator = $colorsGenerator;
        $this->brandsGenerator = $carBrandsGenerator;
        $this->brandModelsGenerator = $carBrandModelsGenerator;
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
        $yandexClient = $this->yandexClient;

        $vehiclesCardData = $yandexClient->getVehiclesCardData();

        $this->generateColors($vehiclesCardData);

        $brands = $this->generateBrands($vehiclesCardData);
        $this->generateModelsForBrands($yandexClient, $brands);

        return true;
    }

    private function generateColors(array $vehiclesCardData)
    {
        return $this->colorsGenerator->generate($vehiclesCardData);
    }

    private function generateBrands(array $vehiclesCardData)
    {
        return $this->brandsGenerator->generate($vehiclesCardData);
    }

    private function generateModelsForBrands($yandexClient, $brands)
    {
        $this->brandModelsGenerator->generateBrandsModels($yandexClient, $brands);
    }
}
