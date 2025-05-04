<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MqttService;


class ListenToMqtt extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:real';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen to MQTT topic and save sensor data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📡 MQTT subscription started...');
        app(MqttService::class)->subscribe();

    }
}
