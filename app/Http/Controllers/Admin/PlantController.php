<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlantController extends Controller
{
    public function index()
    {
        $plants = Plant::withCount('missions')->orderBy('name')->get();
        return view('admin.plants.index', compact('plants'));
    }

    public function create()
    {
        return view('admin.plants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'required|image|max:2048', // Validasi gambar
        ]);

        // Upload gambar
        $path = $request->file('image_url')->store('plants', 'public');

        Plant::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image_url' => $path,
        ]);

        return redirect()->route('admin.plants.index')->with('success', 'Tanaman berhasil ditambahkan.');
    }

    public function edit(Plant $plant)
    {
        return view('admin.plants.edit', compact('plant'));
    }

    public function update(Request $request, Plant $plant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'nullable|image|max:2048',
        ]);

        $data = $validated;

        if ($request->hasFile('image_url')) {
            if ($plant->image_url) {
                Storage::disk('public')->delete($plant->image_url);
            }
            $data['image_url'] = $request->file('image_url')->store('plants', 'public');
        } else {
            unset($data['image_url']);
        }

        $plant->update($data);

        return redirect()->route('admin.plants.index')->with('success', 'Tanaman berhasil diperbarui.');
    }

    public function destroy(Plant $plant)
    {
        if ($plant->image_url) {
            Storage::disk('public')->delete($plant->image_url);
        }
        $plant->delete();
        return redirect()->route('admin.plants.index')->with('success', 'Tanaman berhasil dihapus.');
    }
}
