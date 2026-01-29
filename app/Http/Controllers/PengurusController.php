<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\Bidang;
use App\Models\Departemen;
use App\Models\Member;
use App\Models\Pengurus;
use App\Models\PeriodeKepengurusan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class PengurusController extends Controller
{
    public function index()
    {
        $query = Pengurus::with(['member.generation', 'member.media', 'period', 'department', 'bidang']);

        if (request()->filled('period_id')) {
            $query->where('period_id', request()->period_id);
        }

        $pengurus = $query->orderBy('hierarchy_level', 'asc')->paginate(12);

        return view('admin.pengurus.index', [
            'pengurus' => $pengurus,
            'members' => Member::orderBy('full_name')->get(),
            'periods' => PeriodeKepengurusan::orderBy('start_date', 'desc')->get(),
            'departments' => Departemen::all(),
            'bidangs' => Bidang::all(),
            'generations' => Angkatan::orderBy('year', 'desc')->get(),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $normalizeFields = [
            'new_member_full_name',
            'new_member_npm',
            'new_member_email',
            'new_member_generation_id',
            'new_member_role',
        ];

        foreach ($normalizeFields as $field) {
            $value = $request->input($field);
            if (is_array($value)) {
                $request->merge([$field => $value[0] ?? null]);
            }
        }

        $rules = [
            'member_mode'    => 'required|in:existing,new',
            'member_id'       => 'nullable|exists:members,id',
            'period_id'       => 'required|exists:periods,id',
            'department_id'   => 'required|exists:departments,id',
            'bidang_id'       => 'nullable|exists:bidangs,id',
            'hierarchy_level' => 'required|integer|min:1|max:10',
            'position'        => 'required|string|max:100',
            'card'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'new_member_full_name' => 'required_if:member_mode,new|nullable|string|max:100',
            'new_member_npm' => 'required_if:member_mode,new|nullable|string|max:20|unique:members,npm',
            'new_member_email' => 'required_if:member_mode,new|nullable|email|unique:users,email',
            'new_member_password' => 'nullable|min:8',
            'new_member_generation_id' => 'required_if:member_mode,new|nullable|exists:generations,id',
            'new_member_role' => 'nullable|exists:roles,name',
        ];

        if ((int) $request->input('hierarchy_level') === 3) {
            $rules['bidang_id'] = 'required|exists:bidangs,id';
        }

        $validated = $request->validate($rules);

        return DB::transaction(function () use ($request, $validated) {
            $memberId = $validated['member_id'] ?? null;

            if (!$memberId) {
                $password = $validated['new_member_password'] ?? Str::random(12);

                $user = User::create([
                    'email' => $validated['new_member_email'],
                    'password' => Hash::make($password),
                ]);

                $roleName = $validated['new_member_role'] ?? 'pengurus';
                if (Role::where('name', $roleName)->exists()) {
                    $user->assignRole($roleName);
                }

                $member = Member::create([
                    'user_id' => $user->id,
                    'department_id' => $validated['department_id'],
                    'generation_id' => $validated['new_member_generation_id'],
                    'full_name' => $validated['new_member_full_name'],
                    'npm' => $validated['new_member_npm'],
                    'is_active' => true,
                ]);

                $memberId = $member->id;
            }

            $data = [
                'member_id' => $memberId,
                'period_id' => $validated['period_id'],
                'department_id' => $validated['department_id'],
                'bidang_id' => ((int) $validated['hierarchy_level'] === 3) ? ($validated['bidang_id'] ?? null) : null,
                'hierarchy_level' => $validated['hierarchy_level'],
                'position' => $validated['position'],
            ];

            $pengurus = Pengurus::create($data);

            if ($request->hasFile('card')) {
                $pengurus->addMediaFromRequest('card')
                    ->toMediaCollection('foto_pengurus');
            }

            return redirect()->route('admin.managements.index')->with('success', 'Data pengurus berhasil ditambahkan.');
        });
    }

    public function update(Request $request, Pengurus $management)
    {
        $rules = [
            'member_id'       => 'required|integer|exists:members,id',
            'period_id'       => 'required|integer|exists:periods,id',
            'department_id'   => 'required|integer|exists:departments,id',
            'bidang_id'       => 'nullable|integer|exists:bidangs,id',
            'hierarchy_level' => 'required|integer|min:1|max:10',
            'position'        => 'required|string|max:100',
            'card'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        if ((int) $request->input('hierarchy_level') === 3) {
            $rules['bidang_id'] = 'required|exists:bidangs,id';
        }

        $validated = $request->validate($rules);

        if (!$validated) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $data = [
            'member_id' => $validated['member_id'],
            'period_id' => $validated['period_id'],
            'department_id' => $validated['department_id'],
            'bidang_id' => ((int) $validated['hierarchy_level'] === 3) ? ($validated['bidang_id'] ?? null) : null,
            'hierarchy_level' => $validated['hierarchy_level'],
            'position' => $validated['position'],
        ];

        $management->update($data);

        if ($request->hasFile('card')) {
            $management->clearMediaCollection('foto_pengurus');
            $management->addMediaFromRequest('card')
                ->toMediaCollection('foto_pengurus');
        }

        return redirect()->route('admin.managements.index')->with('success', 'Data pengurus berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengurus = Pengurus::findOrFail($id);
        $pengurus->delete();
        return redirect()->back()->with('success', 'Data pengurus berhasil dihapus.');
    }
}
