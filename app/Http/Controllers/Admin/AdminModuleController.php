<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import Str
use Illuminate\Support\Facades\Storage; // Import Storage

class adminModuleController extends Controller
{
    /**
     * Menampilkan daftar semua modul.
     */
    public function index()
    {
        $modules = Module::orderBy('level_required')->orderBy('title')->get();
        return view('admin.modules.index', compact('modules'));
    }

    /**
     * Menampilkan formulir untuk membuat modul baru.
     */
    public function create()
    {
        return view('admin.modules.create');
    }

    /**
     * [PERBAIKAN] Menyimpan modul baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:modules', // Pastikan judul unik
            'level_required' => 'required|integer|min:1',
            'file_path' => 'required|file|mimes:pdf|max:10240', // PDF, maks 10MB
            'description' => 'required|string|max:500',
        ]);

        // 2. Handle upload file PDF
        // Ini akan menyimpan file di 'storage/app/public/modules'
        // dan mengembalikan path 'modules/namafile.pdf'
        $path = $request->file('file_path')->store('modules', 'public');

        // 3. Buat dan simpan modul
        Module::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']), // Buat slug otomatis
            'level_required' => $validated['level_required'],
            'description' => $validated['description'], // <-- Simpan deskripsi
            'file_path' => $path, // <-- Simpan path file
        ]);

        // 4. Redirect kembali
        return redirect()->route('admin.modules.index')->with('success', 'Modul baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit modul.
     */
    public function edit(Module $module)
    {
        return view('admin.modules.edit', compact('module'));
    }

    /**
     * [PERBAIKAN] Memperbarui modul yang ada di database.
     */
    public function update(Request $request, Module $module)
    {
        // 1. Validasi input
        $validated = $request->validate([
            // Pastikan validasi unik mengabaikan modul saat ini
            'title' => 'required|string|max:255|unique:modules,title,' . $module->id,
            'level_required' => 'required|integer|min:1',
            'file_path' => 'nullable|file|mimes:pdf|max:10240', // PDF opsional saat update
            'description' => 'required|string|max:500',
        ]);

        // Siapkan data untuk diupdate
        $data = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'level_required' => $validated['level_required'],
            'description' => $validated['description'],
        ];

        // 2. Cek jika ada file PDF baru di-upload
        if ($request->hasFile('file_path')) {
            // Hapus file PDF lama
            if ($module->file_path) {
                Storage::disk('public')->delete($module->file_path);
            }
            // Simpan file PDF baru
            $data['file_path'] = $request->file('file_path')->store('modules', 'public');
        }

        // 3. Update modul
        $module->update($data);

        // 4. Redirect kembali
        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil diperbarui.');
    }

    /**
     * Menghapus modul dari database.
     */
    public function destroy(Module $module)
    {
        // 1. Hapus file PDF dari storage
        if ($module->file_path) {
            Storage::disk('public')->delete($module->file_path);
        }

        // 2. Hapus data dari database
        $module->delete();

        // 3. Redirect kembali
        return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil dihapus.');
    }
}
