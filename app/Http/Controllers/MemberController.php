<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Member;
use App\Models\OrganizationPeriods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MemberController extends Controller
{

    public function index()
    {
        $members = Member::with(['organizationPeriod', 'department'])->get();
        return view('page.member.index', compact('members'));
    }

    public function create()
    {
        $member = Member::all();
        $organizationPeriods = OrganizationPeriods::all();
        $departments = Departemen::all();
        return view('page.member.create', compact([
            'member',
            'organizationPeriods',
            'departments'
        ]));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'student_id_number' => 'required|string|max:20|unique:members',
            'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'position' => 'required|string|max:50',
            'organization_period_id' => 'required',
            'department_id' => 'required',
        ]);


        $member = new Member();
        $member->name = $validatedData['name'];
        $member->student_id_number = $validatedData['student_id_number'];
        $member->position = $validatedData['position'];
        $member->organization_period_id = $validatedData['organization_period_id'];
        $member->department_id = $validatedData['department_id'];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = Str::slug($validatedData['student_id_number']) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('photos/member', $fileName, 'public');
            $member->image = $path;
        } else {
            $member->image = null;
        }

        try {
            $member->save();

            return redirect()->route('organization.index')->with('success', 'Data pengurus berhasil ditambahkan!');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data pengurus: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function edit(Member $member)
    {
        $organizationPeriods = OrganizationPeriods::all();
        $departments = Departemen::all();
        return view('page.member.edit', compact([
            'member',
            'organizationPeriods',
            'departments'
        ]));
    }

    public function update(Request $request, Member $member)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'student_id_number' => 'required|string|max:20|unique:members,student_id_number,' . $member->id,
            'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        $member->name = $validatedData['name'];
        $member->student_id_number = $validatedData['student_id_number'];

        if ($request->hasFile('image')) {
            if ($member->image) {
                Storage::disk('public')->delete($member->image);
            }

            $file = $request->file('image');
            $fileName = Str::slug($validatedData['student_id_number']) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('photos/member', $fileName, 'public');
            $member->image = $path;
        }

        $member->save();

        return redirect()->route('member.index')->with('success', 'Data pengurus berhasil diperbarui!');
    }

    public function destroy(Member $member)
    {
        if ($member->image) {
            Storage::disk('public')->delete($member->image);
        }

        $member->delete();

        return redirect()->route('member.index')->with('success', 'Data pengurus berhasil dihapus!');
    }
}
