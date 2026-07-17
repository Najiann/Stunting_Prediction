<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class StuntingPredictionService
{
    protected string $baseUrl;

    public function __construct()
    {
        // URL API Machine Learning (FastAPI)
        $this->baseUrl = config('services.stunting_ml.url', 'http://127.0.0.1:8001');
    }

    /**
     * Mengirim data balita ke FastAPI untuk prediksi stunting.
     *
     * @throws Exception
     */
    public function predict(array $payload): array
    {
        try {
            $response = Http::timeout(10)
                ->post($this->baseUrl . '/predict', $payload);

        } catch (ConnectionException $e) {
            throw new Exception(
                'Tidak dapat terhubung ke API FastAPI di ' . $this->baseUrl .
                '. Pastikan server FastAPI sedang berjalan.'
            );
        }

        if ($response->failed()) {
            throw new Exception(
                'API Prediksi mengembalikan error (' .
                $response->status() .
                '): ' .
                ($response->json('detail') ?? $response->body())
            );
        }

        $result = $response->json();

        if (!is_array($result) || !array_key_exists('prediction_code', $result)) {
            throw new Exception('Format response dari API prediksi tidak valid.');
        }

        $predictionCode = (int) $result['prediction_code'];

        return [
            'prediction_code' => $predictionCode,
            'prediction_status' => $result['prediction_status']
                ?? ($predictionCode === 1 ? 'Stunting' : 'Tidak Stunting'),

            'probability_stunting_percent' => isset($result['probability_stunting_percent'])
                ? round((float) $result['probability_stunting_percent'], 2)
                : null,
        ];
    }

    /**
     * Mengirim hasil prediksi ke Langflow
     * untuk mendapatkan rekomendasi AI.
     *
     * @throws Exception
     */
    public function generateRecommendation(array $data): string
    {
        $message = <<<PROMPT
            Status Prediksi : {$data['prediction_status']}

            Usia : {$data['usia_bulan']} bulan
            Jenis Kelamin : {$data['jenis_kelamin']}
            Berat Lahir : {$data['berat_lahir_kg']} kg
            Panjang Lahir : {$data['panjang_lahir_cm']} cm
            ASI Eksklusif : {$data['asi_eksklusif']}
            Protein Harian : {$data['protein_harian']} gram
            Frekuensi Makan : {$data['frekuensi_makan']} kali
            Tinggi Ibu : {$data['tinggi_ibu_cm']} cm
            Riwayat Diare : {$data['riwayat_diare']}
            Pendapatan Keluarga : {$data['pendapatan_keluarga']}
            Sanitasi Layak : {$data['sanitasi_layak']}
            Imunisasi Lengkap : {$data['imunisasi_lengkap']}

            Berikan analisis dan rekomendasi yang dipersonalisasi berdasarkan kondisi anak tersebut.
            PROMPT;

        try {

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-api-key' => config('services.langflow.api_key'),
            ])->post(
                config('services.langflow.url')
                . '/api/v1/run/'
                . config('services.langflow.flow_id')
                . '?stream=false',
                [
                    'output_type' => 'chat',
                    'input_type' => 'chat',
                    'input_value' => $message,
                    'session_id' => uniqid(),
                ]
            );

        } catch (ConnectionException $e) {
            throw new Exception('Tidak dapat terhubung ke Langflow.');
        }

        if ($response->failed()) {
            throw new Exception(
                'Langflow mengembalikan error (' .
                $response->status() .
                '): ' .
                $response->body()
            );
        }

        return data_get(
            $response->json(),
            'outputs.0.outputs.0.results.message.text',
            'Rekomendasi AI tidak tersedia.'
        );
    }
}