<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::orderBy('title')->get();

        return view('modules.index', [
            'modules' => $modules
        ]);
    }

    /**
     * Menampilkan detail satu modul dan link ke kuisnya.
     */
    public function show(Module $module) // <-- Laravel otomatis mencari modul berdasarkan slug
    {
        if (Auth::user()->level < $module->level_required) {
            return redirect()->route('modules.index')
                ->with('error', "Level Anda (Lv. ".Auth::user()->level.") belum cukup untuk membuka modul ini. (Perlu Lv. {$module->level_required})");
        }
        // Memuat relasi 'quiz'
        $module->load('quiz');

        return view('modules.show', [
            'module' => $module
        ]);
    }
}
