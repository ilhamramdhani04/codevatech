<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kerusakan;
use App\Models\Kategori;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class KerusakanController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $query = Kerusakan::with('kategori');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_kerusakan', 'like', "%{$search}%")
                  ->orWhere('nama_kerusakan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $kerusakans = $query->orderBy('kode_kerusakan')->paginate(15)->withQueryString();
        $kategoris  = Kategori::all();

        return view('admin.kerusakans.index', compact('kerusakans', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.kerusakans.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id'    => ['required', 'exists:kategoris,id'],
            'kode_kerusakan' => ['required', 'string', 'max:10', 'unique:kerusakans,kode_kerusakan', 'regex:/^K\d+$/'],
            'nama_kerusakan' => ['required', 'string', 'max:150'],
        ], [
            'kode_kerusakan.regex' => 'Kode kerusakan harus diawali huruf K diikuti angka (contoh: K01).',
        ]);

        $kerusakan = Kerusakan::create($validated);

        $this->logActivity('created', $kerusakan, "Menambahkan kerusakan: {$kerusakan->kode_kerusakan} - {$kerusakan->nama_kerusakan}");

        return redirect(panel_route('kerusakans.index'))
                         ->with('success', 'Kerusakan berhasil ditambahkan.');
    }

    public function show(Kerusakan $kerusakan)
    {
        $kerusakan->load(['kategori', 'penyebabs', 'solusis', 'rules.ruleGejala.gejala']);
        return view('admin.kerusakans.show', compact('kerusakan'));
    }

    public function edit(Kerusakan $kerusakan)
    {
        $kategoris = Kategori::all();
        return view('admin.kerusakans.edit', compact('kerusakan', 'kategoris'));
    }

    public function update(Request $request, Kerusakan $kerusakan)
    {
        $validated = $request->validate([
            'kategori_id'    => ['required', 'exists:kategoris,id'],
            'kode_kerusakan' => ['required', 'string', 'max:10', 'unique:kerusakans,kode_kerusakan,' . $kerusakan->id, 'regex:/^K\d+$/'],
            'nama_kerusakan' => ['required', 'string', 'max:150'],
        ], [
            'kode_kerusakan.regex' => 'Kode kerusakan harus diawali huruf K diikuti angka (contoh: K01).',
        ]);

        $oldData = $kerusakan->only(['kategori_id', 'kode_kerusakan', 'nama_kerusakan']);
        $kerusakan->update($validated);

        $this->logActivity('updated', $kerusakan, "Mengubah kerusakan: {$kerusakan->kode_kerusakan}", [
            'before' => $oldData,
            'after'  => $validated,
        ]);

        return redirect(panel_route('kerusakans.index'))
                         ->with('success', 'Kerusakan berhasil diperbarui.');
    }

    public function destroy(Kerusakan $kerusakan)
    {
        if ($kerusakan->rules()->exists()) {
            return back()->with('error', 'Kerusakan tidak dapat dihapus karena masih memiliki rule diagnosis.');
        }

        $kode = $kerusakan->kode_kerusakan;
        $this->logActivity('deleted', $kerusakan, "Menghapus kerusakan: {$kode}");

        $kerusakan->delete();

        return redirect(panel_route('kerusakans.index'))
                         ->with('success', 'Kerusakan berhasil dihapus.');
    }
}
