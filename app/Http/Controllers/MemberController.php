<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Departemen;
use App\Models\PeriodeKepengurusan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with(['user', 'department', 'generation', 'media']);

        // Filter & Search
        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%')
                ->orWhere('npm', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        $members = $query->latest()->paginate(10);
        $departments = Departemen::all();

        return view('admin.members.index', compact('members', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:8',
            'full_name'     => 'required|string|max:100',
            'npm'           => 'required|unique:members,npm',
            'department_id' => 'required|exists:departments,id',
            'generation_id' => 'required|exists:generations,id',
            'photo'         => 'nullable|image|max:2048',
            'role'          => 'required|exists:roles,name'
        ]);

        return DB::transaction(function () use ($request) {
            // 1. Buat Akun User
            $user = User::create([
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'no_hp'    => $request->no_hp,
            ]);

            $user->assignRole($request->role);

            // 2. Buat Profil Member
            $member = Member::create([
                'user_id'       => $user->id,
                'department_id' => $request->department_id,
                'generation_id' => $request->generation_id,
                'full_name'     => $request->full_name,
                'npm'           => $request->npm,
                'is_active'     => true,
            ]);

            // 3. Media Library (Ganti Storage::storeAs manual)
            if ($request->hasFile('photo')) {
                $member->addMediaFromRequest('photo')->toMediaCollection('avatars');
            }

            return redirect()->route('members.index')->with('success', 'Member dan Akun berhasil dibuat.');
        });
    }

    public function destroy(Member $member)
    {
        return DB::transaction(function () use ($member) {
            // Menghapus member akan menghapus user karena onDelete('cascade') di database
            // Media juga otomatis dihapus oleh Spatie Media Library
            $member->user->delete();
            $member->delete();

            return redirect()->back()->with('success', 'Member berhasil dihapus.');
        });
    }
}
