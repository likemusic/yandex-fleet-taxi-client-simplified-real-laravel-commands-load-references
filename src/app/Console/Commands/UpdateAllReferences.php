<?php

namespace Likemusic\Yandex\FleetTaxi\Client\Simplified\Real\Laravel\Commands\Console\Commands;

use Illuminate\Console\Command;

class UpdateAllReferences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fleet:all-references:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate car (brands and models) and driver (countries) references  data by Yandex-provided data.';

    public function handle()
    {
        $this->call(UpdateDriverReferences::class);
        $this->call(UpdateCarReferences::class);
    }
}
