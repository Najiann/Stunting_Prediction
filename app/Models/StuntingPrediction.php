<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StuntingPrediction extends Model
{
    protected $fillable = [
        'user_id',
        'nama_balita',
        'usia_bulan',
        'jenis_kelamin',
        'berat_lahir_kg',
        'panjang_lahir_cm',
        'asi_eksklusif',
        'protein_harian',
        'frekuensi_makan',
        'tinggi_ibu_cm',
        'riwayat_diare',
        'pendapatan_keluarga',
        'sanitasi_layak',
        'imunisasi_lengkap',
        'prediction_code',
        'prediction_status',
        'probability_stunting_percent',
        'predicted_by',
        'ai_recommendation',
    ];

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }
}