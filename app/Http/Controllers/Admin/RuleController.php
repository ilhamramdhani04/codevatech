<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use App\Models\Kerusakan;
use App\Models\Gejala;
use App\Models\RuleGejala;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RuleController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $query = Rule::with('kerusakan');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_rule', 'like', "%{$search}%")
                  ->orWhereHas('kerusakan', fn($q2) => $q2->where('nama_kerusakan', 'like', "%{$search}%"));
            });
        }

        $rules = $query->orderBy('kode_rule')->paginate(15)->withQueryString();

        return view('admin.rules.index', compact('rules'));
    }

    public function create()
    {
        $kerusakans = Kerusakan::orderBy('kode_kerusakan')->get();
        $gejalas    = Gejala::orderBy('kode_gejala')->get();
        return view('admin.rules.create', compact('kerusakans', 'gejalas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kerusakan_id'    => ['required', 'exists:kerusakans,id'],
            'kode_rule'       => ['required', 'string', 'max:10', 'unique:rules,kode_rule', 'regex:/^R\d+$/'],
            'keterangan'      => ['nullable', 'string'],
            'gejala_ids'      => ['required', 'array', 'min:1'],
            'gejala_ids.*'    => ['integer', 'exists:gejalas,id'],
            'is_negated'      => ['nullable', 'array'],
        ], [
            'kode_rule.regex'     => 'Kode rule harus diawali huruf R diikuti angka (contoh: R01).',
            'gejala_ids.required' => 'Pilih minimal satu gejala untuk rule ini.',
        ]);

        $rule = DB::transaction(function () use ($validated, $request) {
            $rule = Rule::create([
                'kerusakan_id' => $validated['kerusakan_id'],
                'kode_rule'    => $validated['kode_rule'],
                'keterangan'   => $validated['keterangan'] ?? null,
            ]);

            $negatedIds = $request->input('is_negated', []);

            foreach ($validated['gejala_ids'] as $gejalaId) {
                RuleGejala::create([
                    'rule_id'    => $rule->id,
                    'gejala_id'  => $gejalaId,
                    'is_negated' => in_array($gejalaId, $negatedIds),
                ]);
            }

            return $rule;
        });

        $this->logActivity('created', $rule, "Menambahkan rule: {$rule->kode_rule}");

        return redirect(panel_route('rules.index'))
                         ->with('success', 'Rule berhasil ditambahkan.');
    }

    public function show(Rule $rule)
    {
        $rule->load('kerusakan', 'ruleGejala.gejala');
        return view('admin.rules.show', compact('rule'));
    }

    public function edit(Rule $rule)
    {
        $rule->load('ruleGejala');
        $kerusakans = Kerusakan::orderBy('kode_kerusakan')->get();
        $gejalas    = Gejala::orderBy('kode_gejala')->get();
        return view('admin.rules.edit', compact('rule', 'kerusakans', 'gejalas'));
    }

    public function update(Request $request, Rule $rule)
    {
        $validated = $request->validate([
            'kerusakan_id'    => ['required', 'exists:kerusakans,id'],
            'kode_rule'       => ['required', 'string', 'max:10', 'unique:rules,kode_rule,' . $rule->id, 'regex:/^R\d+$/'],
            'keterangan'      => ['nullable', 'string'],
            'gejala_ids'      => ['required', 'array', 'min:1'],
            'gejala_ids.*'    => ['integer', 'exists:gejalas,id'],
            'is_negated'      => ['nullable', 'array'],
        ], [
            'kode_rule.regex'     => 'Kode rule harus diawali huruf R diikuti angka (contoh: R01).',
            'gejala_ids.required' => 'Pilih minimal satu gejala untuk rule ini.',
        ]);

        $oldKode = $rule->kode_rule;

        DB::transaction(function () use ($rule, $validated, $request) {
            $rule->update([
                'kerusakan_id' => $validated['kerusakan_id'],
                'kode_rule'    => $validated['kode_rule'],
                'keterangan'   => $validated['keterangan'] ?? null,
            ]);

            // Hapus kondisi lama dan buat ulang
            $rule->ruleGejala()->delete();

            $negatedIds = $request->input('is_negated', []);

            foreach ($validated['gejala_ids'] as $gejalaId) {
                RuleGejala::create([
                    'rule_id'    => $rule->id,
                    'gejala_id'  => $gejalaId,
                    'is_negated' => in_array($gejalaId, $negatedIds),
                ]);
            }
        });

        $this->logActivity('updated', $rule, "Mengubah rule: {$oldKode}");

        return redirect(panel_route('rules.index'))
                         ->with('success', 'Rule berhasil diperbarui.');
    }

    public function destroy(Rule $rule)
    {
        $kode = $rule->kode_rule;
        $this->logActivity('deleted', $rule, "Menghapus rule: {$kode}");

        $rule->delete(); // ruleGejala cascade

        return redirect(panel_route('rules.index'))
                         ->with('success', 'Rule berhasil dihapus.');
    }
}
