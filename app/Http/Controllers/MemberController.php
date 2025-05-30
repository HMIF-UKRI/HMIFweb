<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function create()
    {
        // Ambil data lain yang mungkin dibutuhkan untuk form (department, position, etc.)
        return view('members.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'student_id_number' => 'required|string|max:20|unique:members,student_id_number',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $member = new Members();
        $member->name = $validatedData['name'];
        $member->student_id_number = $validatedData['student_id_number'];

        if ($request->hasFile('photo')) {
            // 1. Ambil file
            $file = $request->file('photo');

            // 2. Generate nama file unik (opsional tapi direkomendasikan)
            // Format: nim_timestamp.extension
            $fileName = Str::slug($validatedData['student_id_number']) . '_' . time() . '.' . $file->getClientOriginalExtension();

            // 3. Simpan file ke storage/app/public/photos/members
            $path = $file->storeAs('photos/members', $fileName, 'public');

            // 4. Simpan path ke database (path relatif dari storage/app/public)
            $member->image = $path;
        }

        $member->save();

        return redirect()->route('members.index')->with('success', 'Pengurus berhasil ditambahkan!');
    }

    public function edit(Members $member)
    {
        // Ambil data lain yang mungkin dibutuhkan untuk form
        return view('members.edit', compact('member'));
    }

    // Method update() untuk memperbarui anggota
    public function update(Request $request, Members $member)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'student_id_number' => 'required|string|max:20|unique:members,student_id_number,' . $member->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $member->name = $validatedData['name'];
        $member->student_id_number = $validatedData['student_id_number'];

        if ($request->hasFile('photo')) {
            if ($member->photo_path) {
                Storage::disk('public')->delete($member->photo_path);
            }

            $file = $request->file('photo');
            $fileName = Str::slug($validatedData['student_id_number']) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('photos/members', $fileName, 'public');
            $member->photo_path = $path;
        }

        $member->save();

        return redirect()->route('members.index')->with('success', 'Data pengurus berhasil diperbarui!');
    }

    public function destroy(Members $member)
    {
        if ($member->photo_path) {
            Storage::disk('public')->delete($member->photo_path);
        }

        $member->delete();

        return redirect()->route('members.index')->with('success', 'Pengurus berhasil dihapus!');
    }
}
