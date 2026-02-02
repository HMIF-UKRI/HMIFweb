<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\Member;
use App\Models\Departemen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with(['user.roles', 'department', 'generation', 'media']);

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(full_name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(npm) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        $members = $query->latest()->paginate(12)->withQueryString();
        $departments = Departemen::lazy();
        $generations = Angkatan::orderBy('year', 'desc')->get();
        $roles = Role::lazy();

        return view('admin.member.index', compact('members', 'departments', 'generations', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:8',
            'full_name'     => 'required|string|max:100',
            'npm'           => 'required|unique:members,npm',
            'generation_id' => 'required|exists:generations,id',
            'role'          => 'required|exists:roles,name',
            'avatar'        => 'nullable|image|mimes:jpeg,png,jpg,webp,heic|max:5120',
            'instagram_url' => 'nullable|string',
            'linkedin_url'  => 'nullable|string',
        ]);

        return DB::transaction(function () use ($request, $validated) {
            $user = User::create([
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $user->assignRole($validated['role']);

            $member = Member::create([
                'user_id'       => $user->id,
                'department_id' => null,
                'generation_id' => $validated['generation_id'],
                'full_name'     => $validated['full_name'],
                'npm'           => $validated['npm'],
                'instagram_url' => $validated['instagram_url'],
                'linkedin_url'  => $validated['linkedin_url'],
                'is_active'     => true,
            ]);

            // 2. Upload Spatie Media Library
            if ($request->hasFile('avatar')) {
                $member->addMediaFromRequest('avatar')->toMediaCollection('avatars');
            }

            return redirect()->back()->with('success', 'Anggota berhasil didaftarkan.');
        });
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $validated = $request->validate([
            'email'         => 'required|email|unique:users,email,' . $member->user_id,
            'password'      => 'nullable|min:8',
            'full_name'     => 'required|string|max:100',
            'npm'           => 'required|unique:members,npm,' . $member->id,
            'generation_id' => 'required|exists:generations,id',
            'role'          => 'required|exists:roles,name',
            'avatar'        => 'nullable|image|mimes:jpeg,png,jpg,webp,heic|max:5120',
            'instagram_url' => 'nullable|string',
            'linkedin_url'  => 'nullable|string',
            'is_active'     => 'boolean'
        ]);

        return DB::transaction(function () use ($request, $member, $validated) {
            $userData = ['email' => $validated['email']];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $member->user->update($userData);
            $member->user->syncRoles($validated['role']);

            $member->update([
                'department_id' => null,
                'generation_id' => $validated['generation_id'],
                'full_name'     => $validated['full_name'],
                'npm'           => $validated['npm'],
                'instagram_url' => $validated['instagram_url'],
                'linkedin_url'  => $validated['linkedin_url'],
                'is_active'     => filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN),
            ]);

            if ($request->hasFile('avatar')) {
                $member->clearMediaCollection('avatars');
                $member->addMediaFromRequest('avatar')->toMediaCollection('avatars');
            }

            return redirect()->back()->with('success', 'Data anggota berhasil diperbarui.');
        });
    }

    public function destroy(Member $member)
    {
        return DB::transaction(function () use ($member) {
            if ($member->user) {
                $member->user->delete();
            }
            $member->delete();

            return redirect()->back()->with('success', 'Anggota dan akun terkait berhasil dihapus.');
        });
    }
}
