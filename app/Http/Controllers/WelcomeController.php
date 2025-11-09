<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plant;
use App\Models\Module;

class WelcomeController extends Controller
{
    public function index()
    {
        // Ambil 4 tanaman untuk ditampilkan
        $plants = Plant::orderBy('name')->take(4)->get();

        // Ambil 3 modul untuk ditampilkan
        $modules = Module::orderBy('level_required')->orderBy('title')->take(3)->get();

        return view('welcome', [
            'plants' => $plants,
            'modules' => $modules,
        ]);
    }
}
