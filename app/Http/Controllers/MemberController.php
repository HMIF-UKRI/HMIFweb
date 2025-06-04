<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function index()
    {
        $members = Members::all();
        return view('struktur-pengurus', compact('members'));
    }

    public function create()
    {
        $members = Members::all();
        return view('page.member.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'student_id_number' => 'required|string|max:20|unique:members,student_id_number',
            'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'position' => 'required|string|max:50',
            'organization_periods_id' => 'required',
            'departments_id' => 'required',
        ]);

        $member = new Members();
        $member->name = $validatedData['name'];
        $member->student_id_number = $validatedData['student_id_number'];
        $member->position = $validatedData['position'];
        $member->organization_periods_id = $validatedData['organization_periods_id'];
        $member->departments_id = $validatedData['departments_id'];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = Str::slug($validatedData['student_id_number']) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('photos/members', $fileName, 'public');
            $member->image = $path;
        } else {
            $member->image = null;
        }

        try {
            $member->save();

            return redirect()->route('members.index')->with('success', 'Data pengurus berhasil ditambahkan!');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data pengurus: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function edit(Members $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Members $member)
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
            $path = $file->storeAs('photos/members', $fileName, 'public');
            $member->image = $path;
        }

        $member->save();

        return response()->json([
            'success' => true,
            'message' => 'Data pengurus berhasil diperbarui!',
            'data' => $member,
        ]);
    }

    public function destroy(Members $member)
    {
        if ($member->image) {
            Storage::disk('public')->delete($member->image);
        }

        $member->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data pengurus berhasil dihapus!',
        ]);
    }
}
