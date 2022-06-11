<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Services\Covid19StatService;
use Illuminate\Console\Command;

class GetStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'covid19:sync {code?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->service = new Covid19StatService();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if($this->argument('code')) {
            $this->syncCountryStats(strtoupper($this->argument('code')));
            return 0;
        }

        foreach (Country::all() as $country) {
            $this->syncCountryStats($country->code);
        }

        return 0;
    }

    private function syncCountryStats($code) {
        $country = Country::where(['code' => $code])
            ->firstOrFail();

        $data = $this->service->getStatistics($code);
        $country->saveStatistics([
            'confirmed' => $data->confirmed,
            'recovered' => $data->recovered,
            'death'     => $data->deaths
        ]);
    }
}
