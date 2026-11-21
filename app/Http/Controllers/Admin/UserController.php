<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'string', Rule::in(['admin', 'teknisi'])],
        ]);

        if ($validated['role'] === 'admin' && User::where('role', 'admin')->exists()) {
            return back()->withInput()->withErrors([
                'role' => 'Sistem hanya mengizinkan 1 Super Admin. Akun baru harus berupa Teknisi Lab.'
            ]);
        }

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        $this->logActivity('created', $user, "Menambahkan user baru: {$user->name} ({$user->role})");

        return redirect(panel_route('users.index'))
                         ->with('success', "User '{$user->name}' dengan role {$user->role} berhasil ditambahkan.");
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'string', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'string', Rule::in(['admin', 'teknisi'])],
        ]);

        if ($user->role === 'teknisi' && $validated['role'] === 'admin') {
            return back()->withInput()->withErrors([
                'role' => 'Akses ditolak: Akun Teknisi Lab tidak dapat diubah menjadi Super Admin.'
            ]);
        }

        if ($user->role === 'admin' && $validated['role'] === 'teknisi') {
            return back()->withInput()->withErrors([
                'role' => 'Akses ditolak: Akun Super Admin Utama tidak dapat diubah rolenya menjadi Teknisi.'
            ]);
        }

        $data = [
            'name'  => $validated['name'],
            'email' => strtolower($validated['email']),
            'role'  => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $oldName = $user->name;
        $user->update($data);

        $this->logActivity('updated', $user, "Mengubah data user: {$oldName}");

        return redirect(panel_route('users.index'))
                         ->with('success', "User '{$user->name}' berhasil diperbarui.");
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Akun Super Admin Utama tidak dapat dihapus dari sistem.');
        }

        // Hindari admin menghapus akunnya sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $name = $user->name;
        $this->logActivity('deleted', $user, "Menghapus user: {$name}");

        $user->delete();

        return redirect(panel_route('users.index'))
                         ->with('success', "User '{$name}' berhasil dihapus.");
    }
}
