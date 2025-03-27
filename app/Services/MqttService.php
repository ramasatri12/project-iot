<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use Illuminate\Support\Facades\Log;

class MqttService
{
    private $server = '9891e057d4c74a2daf57b59b29dde4fb.s1.eu.hivemq.cloud';
    private $port = 8883;
    private $username = 'sigmaesp';
    private $password = 'Sigma123';
    private $clientId = 'WebClientSigma'; 
    private $topic = 'sensor/data';

    public function subscribe()
    {
        $connectionSettings = (new ConnectionSettings)
            ->setUsername($this->username)
            ->setPassword($this->password)
            ->setUseTls(true)
            ->setTlsVerifyPeer(false); 

        $mqtt = new MqttClient($this->server, $this->port, $this->clientId, MqttClient::MQTT_3_1);

        try {
            $mqtt->connect($connectionSettings, true);
            echo "✅ Connected to MQTT broker.\n";
            echo "🎧 Listening to MQTT topic: {$this->topic}...\n";

            // Subscribe ke topik
            $mqtt->subscribe($this->topic, function (string $topic, string $message) {
                echo "📩 Pesan diterima dari [$topic]: $message\n";
                Log::info("Pesan MQTT diterima: $message");
            }, 0);

            // Loop agar tetap mendengarkan
            $mqtt->loop(true);
        } catch (\Exception $e) {
            Log::error('Gagal koneksi ke MQTT: ' . $e->getMessage());
            echo "❌ Gagal Connected to MQTT broker: " . $e->getMessage() . "\n";
        }
    }
}
