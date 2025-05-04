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

        $server = '18.142.250.134';
        $port = 1883;
        $clientId = 'php-client-' . uniqid();
        $username = 'Website';
        $password = 'website123';


        // Lokasi CA certificate jika diperlukan
        $caFile = storage_path('app/certificates/isrgrootx1.pem');

        // Pengaturan koneksi TLS
        $connectionSettings = (new ConnectionSettings)
        ->setUsername($username)
        ->setPassword($password)
        ->setUseTls(false)// Tidak pakai TLS
        ->setTlsVerifyPeer(false) // Bisa coba true jika sertifikat valid
        ->setTlsCertificateAuthorityFile($caFile);



        $mqtt = new MqttClient($server, $port, $clientId, MqttClient::MQTT_3_1);

        try {
            $mqtt->connect($connectionSettings, true);
            echo "✅ Connected to MQTT broker\n";
            $topic = 'sensor/data';

            // Contoh subscribe atau publish
            $mqtt->subscribe('sensor/data', function ($topic, $message) {
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
            echo "❌ Gagal konek: " . $e->getMessage() . "\n";
        }
    }
}
