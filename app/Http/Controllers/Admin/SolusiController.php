<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kerusakan;
use App\Models\Solusi;
use Illuminate\Http\Request;

class SolusiController extends Controller
{
    public function create(Kerusakan $kerusakan)
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Akses ditolak. Hanya admin yang dapat mengelola solusi.');

        $nextUrutan = $kerusakan->solusis()->max('urutan') + 1;
        return view('admin.solusis.create', compact('kerusakan', 'nextUrutan'));
    }

    public function store(Request $request, Kerusakan $kerusakan)
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Akses ditolak. Hanya admin yang dapat mengelola solusi.');

        $validated = $request->validate([
            'deskripsi' => ['required', 'string'],
            'urutan'    => ['required', 'integer', 'min:1'],
        ]);

        $kerusakan->solusis()->create($validated);

        return redirect(panel_route('kerusakans.show', $kerusakan))
                         ->with('success', 'Solusi berhasil ditambahkan.');
    }

    public function edit(Kerusakan $kerusakan, Solusi $solusi)
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Akses ditolak. Hanya admin yang dapat mengelola solusi.');
        abort_if($solusi->kerusakan_id !== $kerusakan->id, 404);

        return view('admin.solusis.edit', compact('kerusakan', 'solusi'));
    }

    public function update(Request $request, Kerusakan $kerusakan, Solusi $solusi)
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Akses ditolak. Hanya admin yang dapat mengelola solusi.');
        abort_if($solusi->kerusakan_id !== $kerusakan->id, 404);

        $validated = $request->validate([
            'deskripsi' => ['required', 'string'],
            'urutan'    => ['required', 'integer', 'min:1'],
        ]);

        $solusi->update($validated);

        return redirect(panel_route('kerusakans.show', $kerusakan))
                         ->with('success', 'Solusi berhasil diperbarui.');
    }

    public function destroy(Kerusakan $kerusakan, Solusi $solusi)
    {
        abort_if(!auth()->user()->isAdmin(), 403, 'Akses ditolak. Hanya admin yang dapat mengelola solusi.');
        abort_if($solusi->kerusakan_id !== $kerusakan->id, 404);

        $solusi->delete();

        return redirect(panel_route('kerusakans.show', $kerusakan))
                         ->with('success', 'Solusi berhasil dihapus.');
    }
}
