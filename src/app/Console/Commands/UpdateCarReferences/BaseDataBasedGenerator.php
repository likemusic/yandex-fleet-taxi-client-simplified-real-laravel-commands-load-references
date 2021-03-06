<?php

namespace Likemusic\Yandex\FleetTaxi\Client\Simplified\Real\Laravel\Commands\Console\Commands\UpdateCarReferences;

use Likemusic\Yandex\FleetTaxi\Client\Simplified\Real\Laravel\Commands\Helpers\FilenamesProvider;

abstract class BaseDataBasedGenerator
{
    /**
     * @var FilenamesProvider
     */
    protected $filenamesProvider;

    public function __construct(FilenamesProvider $filenamesProvider)
    {
        $this->filenamesProvider = $filenamesProvider;
    }

    public function generate(array $data)
    {
        $items = $this->getItemsByData($data);
        $this->saveItems($items);

        return $items;
    }

    abstract protected function getItemsByData(array $data);

    private function saveItems(array $items)
    {
        $file = $this->getItemsFullFilename();
        $json = json_encode($items);

        file_put_contents($file, $json);
    }

    abstract protected function getItemsFullFilename();
}
