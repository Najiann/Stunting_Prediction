<?php

namespace App\Http\Controllers;

use App\Models\StuntingPrediction;
use App\Services\StuntingPredictionService;
use Illuminate\Http\Request;

class StuntingPredictionController extends Controller
{
    protected StuntingPredictionService $service;

    public function __construct(StuntingPredictionService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $query = StuntingPrediction::where('user_id', auth()->id())->latest();

        // Pencarian nama balita
        if ($search = $request->query('search')) {
            $query->where('nama_balita', 'like', '%'.$search.'%');
        }

        // Filter status stunting (1 = Stunting, 0 = Tidak Stunting)
        if ($request->filled('status') && in_array($request->query('status'), ['0', '1'], true)) {
            $query->where('prediction_code', (int) $request->query('status'));
        }

        $predictions = $query->paginate(15)->withQueryString();

        // Statistik dihitung dari SELURUH data user ini (bukan hanya hasil filter/halaman aktif)
        $totalAll      = StuntingPrediction::where('user_id', auth()->id())->count();
        $totalStunting = StuntingPrediction::where('user_id', auth()->id())->where('prediction_code', 1)->count();
        $totalNormal   = $totalAll - $totalStunting;

        return view('stunting.index', compact('predictions', 'totalAll', 'totalStunting', 'totalNormal'));
    }

    public function create()
    {
        return view('stunting.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_balita'         => 'nullable|string|max:100',
            'usia_bulan'          => 'required|integer|min:0|max:60',
            'jenis_kelamin'       => 'required|in:L,P',
            'berat_lahir_kg'      => 'required|numeric|min:0',
            'panjang_lahir_cm'    => 'required|numeric|min:0',
            'asi_eksklusif'       => 'required|in:Ya,Tidak',
            'protein_harian'      => 'required|numeric|min:0',
            'frekuensi_makan'     => 'required|integer|min:0',
            'tinggi_ibu_cm'       => 'required|numeric|min:0',
            'riwayat_diare'       => 'required|integer|min:0',
            'pendapatan_keluarga' => 'required|numeric|min:0',
            'sanitasi_layak'      => 'required|in:Ya,Tidak',
            'imunisasi_lengkap'   => 'required|in:Ya,Tidak',
        ]);

        try {
            $payload = collect($validated)->except('nama_balita')->toArray();

            $payload['usia_bulan']          = (int)   $payload['usia_bulan'];
            $payload['berat_lahir_kg']      = (float) $payload['berat_lahir_kg'];
            $payload['panjang_lahir_cm']    = (float) $payload['panjang_lahir_cm'];
            $payload['protein_harian']      = (float) $payload['protein_harian'];
            $payload['frekuensi_makan']     = (int)   $payload['frekuensi_makan'];
            $payload['tinggi_ibu_cm']       = (float) $payload['tinggi_ibu_cm'];
            $payload['riwayat_diare']       = (int)   $payload['riwayat_diare'];
            $payload['pendapatan_keluarga'] = (float) $payload['pendapatan_keluarga'];

            $result = $this->service->predict($payload);

            $prediction = StuntingPrediction::create([
                ...$validated,
                'user_id'                      => auth()->id(),
                'prediction_code'              => $result['prediction_code'],
                'prediction_status'            => $result['prediction_status'],
                'probability_stunting_percent' => $result['probability_stunting_percent'] ?? null,
                'predicted_by'                 => auth()->user()?->name ?? 'Guest',
            ]);

            return redirect()
                ->route('stunting.show', $prediction->id)
                ->with('success', 'Prediksi berhasil disimpan!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['api' => 'Gagal menghubungi API prediksi: '.$e->getMessage()]);
        }
    }

    public function show(StuntingPrediction $stunting)
    {
        abort_unless($stunting->user_id === auth()->id(), 403);

        return view('stunting.show', compact('stunting'));
    }

    /**
     * Belum diimplementasikan 
     * COMING SOON (diimplementasikan slay the gods dah tamat)
     */
    public function edit(StuntingPrediction $stunting)
    {
        abort(404);
    }

    public function update(Request $request, StuntingPrediction $stunting)
    {
        abort(404);
    }

    public function destroy(StuntingPrediction $stunting)
    {
        abort_unless($stunting->user_id === auth()->id(), 403);

        $stunting->delete();

        return redirect()
            ->route('stunting.index')
            ->with('success', 'Data prediksi berhasil dihapus.');
    }
}