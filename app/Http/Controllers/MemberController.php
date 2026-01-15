<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Departemen;
use App\Models\OrganizationPeriods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with(['organizationPeriod', 'department'])
            ->latest()
            ->paginate(10);

        return view('page.member.index', compact('members'));
    }

    public function create()
    {
        $organizationPeriods = OrganizationPeriods::orderBy('name')->get();
        $departments = Departemen::orderBy('name')->get();

        return view('page.member.create', compact('organizationPeriods', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                   => 'required|string|max:255',
            'student_id_number'      => 'required|string|max:20|unique:members,student_id_number',
            'image'                  => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'position'               => 'required|string|max:255',
            'organization_period_id' => 'required|exists:organization_periods,id',
            'department_id'          => 'required|exists:departemens,id',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), $validated['student_id_number']);
        }

        Member::create($validated);

        return redirect()->route('member.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function edit(Member $member)
    {
        $organizationPeriods = OrganizationPeriods::all();
        $departments = Departemen::all();

        return view('page.member.edit', compact('member', 'organizationPeriods', 'departments'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name'                   => 'required|string|max:255',
            'student_id_number'      => 'required|string|max:20|unique:members,student_id_number,' . $member->id,
            'image'                  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'position'               => 'required|string|max:255',
            'organization_period_id' => 'required|exists:organization_periods,id',
            'department_id'          => 'required|exists:departemens,id',
        ]);

        if ($request->hasFile('image')) {
            if ($member->image) {
                Storage::disk('public')->delete($member->image);
            }
            $validated['image'] = $this->uploadImage($request->file('image'), $validated['student_id_number']);
        }

        $member->update($validated);

        return redirect()->route('member.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy(Member $member)
    {
        if ($member->image) {
            Storage::disk('public')->delete($member->image);
        }

        $member->delete();

        return redirect()->route('member.index')->with('success', 'Anggota berhasil dihapus!');
    }

    private function uploadImage($file, $identifier)
    {
        $fileName = Str::slug($identifier) . '_' . time() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('photos/member', $fileName, 'public');
    }
}
