<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kerusakan;
use App\Models\Penyebab;
use Illuminate\Http\Request;

class PenyebabController extends Controller
{
    public function create(Kerusakan $kerusakan)
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Akses ditolak. Hanya admin yang dapat mengelola penyebab.');

        return view('admin.penyebabs.create', compact('kerusakan'));
    }

    public function store(Request $request, Kerusakan $kerusakan)
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Akses ditolak. Hanya admin yang dapat mengelola penyebab.');

        $validated = $request->validate([
            'deskripsi' => ['required', 'string'],
        ]);

        $kerusakan->penyebabs()->create($validated);

        return redirect(panel_route('kerusakans.show', $kerusakan))
                         ->with('success', 'Penyebab berhasil ditambahkan.');
    }

    public function edit(Kerusakan $kerusakan, Penyebab $penyebab)
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Akses ditolak. Hanya admin yang dapat mengelola penyebab.');
        abort_if($penyebab->kerusakan_id !== $kerusakan->id, 404);

        return view('admin.penyebabs.edit', compact('kerusakan', 'penyebab'));
    }

    public function update(Request $request, Kerusakan $kerusakan, Penyebab $penyebab)
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Akses ditolak. Hanya admin yang dapat mengelola penyebab.');
        abort_if($penyebab->kerusakan_id !== $kerusakan->id, 404);

        $validated = $request->validate([
            'deskripsi' => ['required', 'string'],
        ]);

        $penyebab->update($validated);

        return redirect(panel_route('kerusakans.show', $kerusakan))
                         ->with('success', 'Penyebab berhasil diperbarui.');
    }

    public function destroy(Kerusakan $kerusakan, Penyebab $penyebab)
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Akses ditolak. Hanya admin yang dapat mengelola penyebab.');
        abort_if($penyebab->kerusakan_id !== $kerusakan->id, 404);

        $penyebab->delete();

        return redirect(panel_route('kerusakans.show', $kerusakan))
                         ->with('success', 'Penyebab berhasil dihapus.');
    }
}
