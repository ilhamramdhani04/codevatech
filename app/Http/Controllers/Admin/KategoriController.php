<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $kategoris = Kategori::withCount('kerusakans')->get();
        return view('admin.kategoris.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategoris.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:50', 'unique:kategoris,nama_kategori'],
        ]);

        $kategori = Kategori::create($validated);

        $this->logActivity('created', $kategori, "Menambahkan kategori: {$kategori->nama_kategori}");

        return redirect(panel_route('kategoris.index'))
                         ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategoris.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:50', 'unique:kategoris,nama_kategori,' . $kategori->id],
        ]);

        $oldName = $kategori->nama_kategori;
        $kategori->update($validated);

        $this->logActivity('updated', $kategori, "Mengubah kategori '{$oldName}' menjadi '{$kategori->nama_kategori}'", [
            'before' => ['nama_kategori' => $oldName],
            'after'  => ['nama_kategori' => $kategori->nama_kategori],
        ]);

        return redirect(panel_route('kategoris.index'))
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->kerusakans()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki data kerusakan.');
        }

        $nama = $kategori->nama_kategori;
        $this->logActivity('deleted', $kategori, "Menghapus kategori: {$nama}");

        $kategori->delete();

        return redirect(panel_route('kategoris.index'))
                         ->with('success', 'Kategori berhasil dihapus.');
    }
}
