<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\LaptopModel;
use Illuminate\Http\Request;

class LaptopModelController extends Controller
{
    public function index(Request $request)
    {
        $query = LaptopModel::with('brand');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_model', 'like', "%{$search}%")
                  ->orWhere('seri', 'like', "%{$search}%")
                  ->orWhereHas('brand', fn($bq) => $bq->where('nama_brand', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        $models = $query->orderBy('brand_id')->orderBy('nama_model')->paginate(20)->withQueryString();
        $brands = Brand::orderBy('nama_brand')->get();

        return view('admin.laptop-models.index', compact('models', 'brands'));
    }

    public function create()
    {
        $brands = Brand::orderBy('nama_brand')->get();
        return view('admin.laptop-models.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_id'        => ['required', 'exists:brands,id'],
            'nama_model'      => ['required', 'string', 'max:100'],
            'seri'            => ['nullable', 'string', 'max:100'],
            'kategori_laptop' => ['required', 'in:gaming,business,ultrabook,workstation,mainstream'],
            'tahun_rilis'     => ['nullable', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
        ]);

        LaptopModel::create($validated);

        return redirect(panel_route('laptop-models.index'))
                         ->with('success', "Model \"{$validated['nama_model']}\" berhasil ditambahkan.");
    }

    public function edit(LaptopModel $laptop_model)
    {
        $brands = Brand::orderBy('nama_brand')->get();
        return view('admin.laptop-models.edit', compact('laptop_model', 'brands'));
    }

    public function update(Request $request, LaptopModel $laptop_model)
    {
        $validated = $request->validate([
            'brand_id'        => ['required', 'exists:brands,id'],
            'nama_model'      => ['required', 'string', 'max:100'],
            'seri'            => ['nullable', 'string', 'max:100'],
            'kategori_laptop' => ['required', 'in:gaming,business,ultrabook,workstation,mainstream'],
            'tahun_rilis'     => ['nullable', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
        ]);

        $laptop_model->update($validated);

        return redirect(panel_route('laptop-models.index'))
                         ->with('success', "Model \"{$laptop_model->nama_model}\" berhasil diperbarui.");
    }

    public function destroy(LaptopModel $laptop_model)
    {
        $name = $laptop_model->nama_model;
        $laptop_model->delete();

        return redirect(panel_route('laptop-models.index'))
                         ->with('success', "Model \"{$name}\" berhasil dihapus.");
    }
}
