<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Services\Covid19StatService;
use Illuminate\Console\Command;
use PHPUnit\Framework\Constraint\Count;

class GetCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'covid19:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $service = new Covid19StatService();

        $countries = $service->getCountries();

        $this->info('TOTAL: '.count($countries));
        foreach ($countries as $key => $country) {
            Country::create([
                'code' => $country->code,
                'name' => json_encode($country->name)
            ]);
            $this->line('SAVED '.($key+1). ' FROM '.count($countries).' ('.$country->code.')');
        }
        $this->info('FINISHED'.PHP_EOL);

        return 0;
    }
}
