<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use Illuminate\Support\Facades\Log;

class MqttConnect extends Command
{
    protected $signature = 'mqtt:connect';
    protected $description = 'Menguji koneksi MQTT ke HiveMQ Cloud';

    public function handle()
    {
        Log::debug('Mencoba koneksi ke MQTT...');

        // Correct broker hostname and port
        $server   = '9891e057d4c74a2daf57b59b29dde4fb.s1.eu.hivemq.cloud'; // Correct broker hostname
        $port     = 8883; // Use 8883 for TLS connections
        $clientId = 'client123';
        $username = 'sigmaesp';
        $password = 'Sigma123';

        // Use storage_path() to resolve the CA certificate path
        $caFile = storage_path('app/certificates/isrgrootx1.pem');

        // TLS configuration
        $connectionSettings = (new ConnectionSettings)
            ->setUsername($username)
            ->setPassword($password)
            ->setUseTls(true)
            ->setTlsCertificateAuthorityFile($caFile) // Pastikan CA sesuai
            ->setTlsVerifyPeer(true); // Pastikan validasi sertifikat aktif

        $mqtt = new MqttClient($server, $port, $clientId, MqttClient::MQTT_3_1);

        try {
            // Connect to the broker
            $mqtt->connect($connectionSettings, true);
            Log::debug('Koneksi ke MQTT berhasil.');
            echo "Connected to MQTT broker.\n";

            // Disconnect
            $mqtt->disconnect();
        } catch (\Exception $e) {
            // Log and display the error
            Log::error('Gagal koneksi ke MQTT: ' . $e->getMessage());
            echo "Gagal Connected to MQTT broker: " . $e->getMessage() . "\n";
        }
    }
}