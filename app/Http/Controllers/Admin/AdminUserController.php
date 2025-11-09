<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * Menampilkan halaman daftar semua pengguna.
     */
    public function index()
    {
        // Ambil semua pengguna, kecuali admin yang sedang login
        $users = User::where('id', '!=', Auth::id())
                     ->orderBy('name')
                     ->paginate(15); // Gunakan pagination

        return view('admin.users.index', compact('users'));
    }

    /**
     * Mengubah role pengguna (dari user ke admin atau sebaliknya).
     */
    public function toggleAdmin(User $user)
    {
        // Keamanan: Pastikan admin tidak mengubah role mereka sendiri
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengubah role Anda sendiri.');
        }

        // Toggle role
        if ($user->isAdmin()) {
            $user->update(['role' => 'user']);
            return redirect()->back()->with('success', $user->name . ' sekarang menjadi User.');
        } else {
            $user->update(['role' => 'admin']);
            return redirect()->back()->with('success', $user->name . ' sekarang menjadi Admin.');
        }
    }

    /**
     * Menghapus pengguna dari database.
     */
    public function destroy(User $user)
    {
        // Keamanan: Pastikan admin tidak menghapus diri sendiri
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Hapus file/data terkait (jika ada) - Model event/cascade lebih baik
        // $user->userPlants()->delete();
        // $user->quizAttempts()->delete();

        // (Asumsi migrasi Anda sudah di-setup dengan onDelete('cascade'))

        $userName = $user->name;
        $user->delete();

        return redirect()->back()->with('success', 'User "' . $userName . '" berhasil dihapus.');
    }
}
