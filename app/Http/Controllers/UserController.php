<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:waiting,optima,admin,tif,telkom_akses',
        ]);

        $user = User::findOrFail($id);

        
        if (
            Auth::id() === $user->id &&
            Auth::user()->role === 'admin' &&
            $request->role !== 'admin'
        ) {
            return back()->with('error', 'Anda tidak dapat mengubah role akun sendiri.');
        }

        $user->update([
            'role' => $request->role,
            'requested_role' => null,
        ]);

        return back()->with('success', 'Role berhasil diubah');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }
}
