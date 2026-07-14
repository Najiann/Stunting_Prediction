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
        // Diambil dari config/services.php, dengan fallback ke URL default FastAPI lokal
        $this->baseUrl = config('services.stunting_ml.url', 'http://127.0.0.1:8001');
    }

    /**
     * Kirim data balita ke API FastAPI untuk diprediksi.
     *
     * @param  array  $payload  Data balita yang sudah divalidasi & di-cast dari controller.
     * @return array{prediction_code:int, prediction_status:string, probability_stunting_percent:float|null}
     *
     * @throws Exception Jika API tidak bisa dihubungi atau mengembalikan response yang tidak valid.
     */
    public function predict(array $payload): array
    {
        try {
            $response = Http::timeout(10)->post($this->baseUrl.'/predict', $payload);
        } catch (ConnectionException $e) {
            throw new Exception(
                'Tidak dapat terhubung ke API prediksi FastAPI di '.$this->baseUrl.
                '. Pastikan server FastAPI sedang berjalan.'
            );
        }

        if ($response->failed()) {
            throw new Exception(
                'API prediksi mengembalikan status error ('.$response->status().'): '.
                ($response->json('detail') ?? $response->body())
            );
        }

        $result = $response->json();

        if (! is_array($result) || ! array_key_exists('prediction_code', $result)) {
            throw new Exception('Format respons dari API prediksi tidak sesuai yang diharapkan.');
        }

        $predictionCode = (int) $result['prediction_code'];

        return [
            'prediction_code'              => $predictionCode,
            'prediction_status'            => $result['prediction_status'] ?? ($predictionCode === 1 ? 'Stunting' : 'Tidak Stunting'),
            'probability_stunting_percent' => isset($result['probability_stunting_percent'])
                ? round((float) $result['probability_stunting_percent'], 2)
                : null,
        ];
    }
}