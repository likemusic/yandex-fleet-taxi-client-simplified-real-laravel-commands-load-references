<?php

namespace Likemusic\Yandex\FleetTaxi\Client\Simplified\Real\Laravel\Commands\Console\Commands\UpdateDriverReferences;

use Likemusic\Yandex\FleetTaxi\Client\Simplified\Real\Laravel\Commands\Helpers\FilenamesProvider;
use Likemusic\YandexFleetTaxiClientSimplified\Contracts\ClientInterface as YandexClientInterface;

class CitiesGenerator
{
    /**
     * @var FilenamesProvider
     */
    private $filenamesProvider;

    public function __construct(FilenamesProvider $filenamesProvider)
    {
        $this->filenamesProvider = $filenamesProvider;
    }

    public function generateItems(YandexClientInterface $yandexClient)
    {
        $yandexData = $yandexClient->getDriversCardData();
        $cities = $this->getItemsByYandexData($yandexData);
        asort($cities);

        $this->saveItems($cities);

        return $cities;
    }

    private function getItemsByYandexData(array $yandexData)
    {
        $countries = $yandexData['data']['references']['countries'];
        $ret = [];

        foreach ($countries as $country) {
            $code = $country['code'];
            $ruName = $country['name_ru'];
            $ret[$code] = $ruName;
        }

        return $ret;
    }

    private function saveItems(array $brands)
    {
        $fullFilename = $this->getFullFilename();
        $json = json_encode($brands);

        file_put_contents($fullFilename, $json);
    }

    private function getFullFilename()
    {
        return $this->filenamesProvider->getDriverLicenseIssueCountriesFullFilename();
    }
}
