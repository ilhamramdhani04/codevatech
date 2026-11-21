<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GejalaController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $query = Gejala::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_gejala', 'like', "%{$search}%")
                  ->orWhere('nama_gejala', 'like', "%{$search}%");
            });
        }

        $gejalas = $query->orderBy('kode_gejala')->paginate(20)->withQueryString();

        return view('admin.gejalas.index', compact('gejalas'));
    }

    public function create()
    {
        return view('admin.gejalas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_gejala' => ['required', 'string', 'max:10', 'unique:gejalas,kode_gejala', 'regex:/^G\d+$/'],
            'nama_gejala' => ['required', 'string'],
            'is_frequent' => ['nullable', 'boolean'],
            'diagnosis_group' => ['nullable', Rule::in(array_keys(Gejala::DIAGNOSIS_GROUPS))],
        ], [
            'kode_gejala.regex' => 'Kode gejala harus diawali huruf G diikuti angka (contoh: G01).',
        ]);

        $validated['is_frequent'] = $request->has('is_frequent');

        $gejala = Gejala::create($validated);

        $this->logActivity('created', $gejala, "Menambahkan gejala: {$gejala->kode_gejala} - {$gejala->nama_gejala}");

        return redirect(panel_route('gejalas.index'))
                         ->with('success', 'Gejala berhasil ditambahkan.');
    }

    public function edit(Gejala $gejala)
    {
        return view('admin.gejalas.edit', compact('gejala'));
    }

    public function update(Request $request, Gejala $gejala)
    {
        $validated = $request->validate([
            'kode_gejala' => ['required', 'string', 'max:10', 'unique:gejalas,kode_gejala,' . $gejala->id, 'regex:/^G\d+$/'],
            'nama_gejala' => ['required', 'string'],
            'is_frequent' => ['nullable', 'boolean'],
            'diagnosis_group' => ['nullable', Rule::in(array_keys(Gejala::DIAGNOSIS_GROUPS))],
        ], [
            'kode_gejala.regex' => 'Kode gejala harus diawali huruf G diikuti angka (contoh: G01).',
        ]);

        $validated['is_frequent'] = $request->has('is_frequent');

        $oldData = $gejala->only(['kode_gejala', 'nama_gejala', 'is_frequent', 'diagnosis_group']);
        $gejala->update($validated);

        $this->logActivity('updated', $gejala, "Mengubah gejala: {$gejala->kode_gejala}", [
            'before' => $oldData,
            'after'  => $validated,
        ]);

        return redirect(panel_route('gejalas.index'))
                         ->with('success', 'Gejala berhasil diperbarui.');
    }

    public function updateGroup(Request $request, Gejala $gejala)
    {
        $validated = $request->validate([
            'diagnosis_group' => ['present', 'nullable', Rule::in(array_keys(Gejala::DIAGNOSIS_GROUPS))],
        ]);

        $oldData = $gejala->only('diagnosis_group');
        $gejala->update($validated);

        $this->logActivity('updated', $gejala, "Mengubah kelompok diagnosis gejala: {$gejala->kode_gejala}", [
            'before' => $oldData,
            'after' => $validated,
        ]);

        return back()->with('success', "Kelompok gejala {$gejala->kode_gejala} berhasil diperbarui.");
    }

    public function toggleFrequent(Gejala $gejala)
    {
        $gejala->update([
            'is_frequent' => !$gejala->is_frequent,
        ]);

        $status = $gejala->is_frequent ? 'ditandai sebagai Sering Terjadi 🔥' : 'dihapus dari kategori Sering Terjadi';

        $this->logActivity('updated', $gejala, "Mengubah status gejala sering terjadi: {$gejala->kode_gejala} ({$status})");

        return back()->with('success', "Gejala {$gejala->kode_gejala} berhasil {$status}.");
    }

    public function destroy(Gejala $gejala)
    {
        if ($gejala->ruleGejala()->exists()) {
            return back()->with('error', 'Gejala tidak dapat dihapus karena masih digunakan dalam rule diagnosis.');
        }

        $kode = $gejala->kode_gejala;
        $this->logActivity('deleted', $gejala, "Menghapus gejala: {$kode}");

        $gejala->delete();

        return redirect(panel_route('gejalas.index'))
                         ->with('success', 'Gejala berhasil dihapus.');
    }
}
