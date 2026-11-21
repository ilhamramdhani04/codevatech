<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = Brand::withCount('laptopModels');

        if ($request->filled('search')) {
            $query->where('nama_brand', 'like', "%{$request->search}%");
        }

        $brands = $query->orderBy('nama_brand')->paginate(20)->withQueryString();

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_brand' => ['required', 'string', 'max:50', 'unique:brands,nama_brand'],
            'logo_url'   => ['nullable', 'string', 'max:255'],
        ]);

        Brand::create($validated);

        return redirect(panel_route('brands.index'))
                         ->with('success', "Brand \"{$validated['nama_brand']}\" berhasil ditambahkan.");
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'nama_brand' => ['required', 'string', 'max:50', "unique:brands,nama_brand,{$brand->id}"],
            'logo_url'   => ['nullable', 'string', 'max:255'],
        ]);

        $brand->update($validated);

        return redirect(panel_route('brands.index'))
                         ->with('success', "Brand \"{$brand->nama_brand}\" berhasil diperbarui.");
    }

    public function destroy(Brand $brand)
    {
        $name = $brand->nama_brand;
        $brand->delete();

        return redirect(panel_route('brands.index'))
                         ->with('success', "Brand \"{$name}\" berhasil dihapus.");
    }
}
