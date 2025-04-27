<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use Illuminate\Support\Facades\Log;
use App\Services\CallMeBotService;
use App\Models\WaterLevel;

class MqttSubscribe extends Command
{
    protected $signature = 'mqtt:subscribe';
    protected $description = 'Mendengarkan data dari broker MQTT dan menampilkannya di terminal';

    public function handle()
    {
        Log::debug('📡 Mencoba koneksi ke MQTT...');

        $server   = '9891e057d4c74a2daf57b59b29dde4fb.s1.eu.hivemq.cloud';
        $port     = 8883;
        $clientId = 'WebClientSigma_' . uniqid(); 
        $username = 'sigmaesp';
        $password = 'Sigma123';

        // Lokasi CA certificate jika diperlukan
        $caFile = storage_path('app/certificates/isrgrootx1.pem');

        // Pengaturan koneksi TLS
        $connectionSettings = (new ConnectionSettings)
            ->setUsername($username)
            ->setPassword($password)
            ->setUseTls(true)
            ->setTlsVerifyPeer(false)
            ->setTlsCertificateAuthorityFile($caFile);

        $mqtt = new MqttClient($server, $port, $clientId, MqttClient::MQTT_3_1);

        try {
            $mqtt->connect($connectionSettings, true);
            Log::debug('✅ Koneksi ke MQTT berhasil.');

            $topic = 'sensor/data';

            $mqtt->subscribe($topic, function (string $topic, string $message) {
                Log::info("📩 Pesan diterima dari [$topic]: $message");
                echo "📩 Pesan diterima dari [$topic]: $message\n";
            
                $data = json_decode($message, true);
            
                if (isset($data['tinggi'])) {
                    $height = (int) $data['tinggi'];

                    if ($height > 200) {
                        $status = 'critical';
                    } elseif ($height > 100) {
                        $status = 'warning';
                    } else {
                        $status = 'normal';
                    }

                    WaterLevel::create([
                        'height' => $height,
                        'status' => $status,
                    ]);

                    Log::info("💾 Data disimpan ke database: Height = {$height}, Status = {$status}");

                    if ($status === 'critical' || $status === 'warning') {
                        $callMeBot = new CallMeBotService();
                        $text = "⚠️ *Peringatan Banjir*\nTinggi air saat ini: *{$height}cm*\nSegera ambil tindakan!";
                        $callMeBot->sendMessage($text);
                    }

                }


            }, 0);
            

            echo "🎧 Listening to MQTT topic: $topic...\n";

            $mqtt->loop(true);
        } catch (\Exception $e) {
            Log::error('❌ Gagal koneksi ke MQTT: ' . $e->getMessage());
            echo "❌ Gagal Connected to MQTT broker: " . $e->getMessage() . "\n";
        }
    }
}
