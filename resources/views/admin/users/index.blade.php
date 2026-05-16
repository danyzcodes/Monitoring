@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="flex items-center gap-3 text-sm text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="font-bold text-slate-800 text-xs uppercase tracking-wider">Dashboard</a>
            <span class="text-slate-300 font-bold">❯</span>
            <span class="font-bold text-slate-800 text-xs uppercase tracking-wider">kelola akun</span>
        </div>
        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500 font-semibold">
                        <tr>
                            <th class="px-6 py-4">Nama User</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Role Saat Ini</th>
                            <th class="px-6 py-4">Requested Role</th>
                            <th class="px-6 py-4 text-center">Update Role</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @foreach ($users as $user)
                            @php
                                $isSelfAdmin = auth()->id() === $user->id;
                            @endphp

                            <tr class="hover:bg-slate-50 transition group">
                                
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs uppercase border border-slate-200">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-slate-800 flex items-center gap-2">
                                                {{ $user->name }}
                                                @if ($isSelfAdmin)
                                                    <span
                                                        class="text-[10px] px-2 py-0.5 rounded-full bg-red-100 text-red-600 border border-red-200">Anda</span>
                                                @endif
                                            </div>
                                            <div class="text-xs text-slate-400">Bergabung
                                                {{ $user->created_at ? $user->created_at->diffForHumans() : '-' }}</div>
                                        </div>
                                    </div>
                                </td>

                                
                                <td class="px-6 py-4 text-slate-600 font-medium">
                                    {{ $user->email }}
                                </td>

                                
                                <td class="px-6 py-4">
                                    @if ($user->role == 'admin')
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-red-50 text-red-700 text-xs font-semibold border border-red-100">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            Admin
                                        </span>
                                    @elseif($user->role == 'optima')
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-100">
                                            User Optima
                                        </span>
                                    @elseif($user->role == 'tif')
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-cyan-50 text-cyan-700 text-xs font-semibold border border-cyan-100">
                                            TIF
                                        </span>
                                    @elseif($user->role == 'telkom_akses')
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-purple-50 text-purple-700 text-xs font-semibold border border-purple-100">
                                            Telkom Akses
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-orange-50 text-orange-700 text-xs font-semibold border border-orange-100">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Waiting
                                        </span>
            </div>
            @endif
            </td>

            
            <td class="px-6 py-4">
                @if ($user->requested_role)
                    @php
                        $badgeClass = match ($user->requested_role) {
                            'admin' => 'bg-red-50 text-red-700 border-red-100',
                            'optima' => 'bg-blue-50 text-blue-700 border-blue-100',
                            'tif' => 'bg-cyan-50 text-cyan-700 border-cyan-100',
                            'telkom_akses' => 'bg-purple-50 text-purple-700 border-purple-100',
                            default => 'bg-slate-100 text-slate-700 border-slate-200',
                        };
                    @endphp
                    <span
                        class="inline-flex items-center px-2.5 py-1 rounded-lg {{ $badgeClass }} border text-xs font-semibold">
                        {{ strtoupper(str_replace('_', ' ', $user->requested_role)) }}
                    </span>
                @else
                    <span class="text-xs text-slate-400">-</span>
                @endif
            </td>

            
            <td class="px-6 py-4 text-center">
                @if (!$isSelfAdmin)
                    <form action="/admin/users/{{ $user->id }}/role" method="POST">
                        @csrf
                        <select name="role" onchange="this.form.submit()"
                            class="text-xs rounded-lg border-slate-200 py-1.5 pl-2 pr-6 focus:ring-2 focus:ring-red-100 focus:border-red-400 transition cursor-pointer hover:bg-slate-50">
                            <option value="waiting" @selected($user->role == 'waiting')>Waiting</option>
                            <option value="optima" @selected($user->role == 'optima')>User Optima</option>
                            <option value="tif" @selected($user->role == 'tif')>TIF</option>
                            <option value="telkom_akses" @selected($user->role == 'telkom_akses')>Telkom Akses</option>
                            <option value="admin" @selected($user->role == 'admin')>Admin</option>
                        </select>
                    </form>
                @else
                    <span class="text-xs text-slate-400 italic">Tidak dapat diubah</span>
                @endif
            </td>

            
            <td class="px-6 py-4 text-right">
                <div class="flex items-center justify-end gap-2">
                    @if ($user->role === 'waiting')
                        <form action="/admin/users/{{ $user->id }}/role" method="POST">
                            @csrf
                            <input type="hidden" name="role" value="{{ $user->requested_role ?? 'optima' }}">
                            <button type="submit" title="Setujui sebagai {{ $user->requested_role ?? 'User Optima' }}"
                                class="p-2 rounded-lg bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-700 border border-green-200 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                        </form>
                    @endif

                    @if (!$isSelfAdmin)
                        <button type="button" x-data @click="$dispatch('open-confirm-delete-{{ $user->id }}')"
                            class="p-2 rounded-lg bg-white text-slate-400 hover:bg-red-50 hover:text-red-600 border border-slate-200 hover:border-red-200 transition"
                            title="Hapus User">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>

                        <x-confirm-delete id="delete-{{ $user->id }}" title="Hapus User"
                            message="Apakah Anda yakin ingin menghapus user <strong>{{ $user->name }}</strong>? Tindakan ini tidak dapat dibatalkan."
                            action="{{ route('admin.users.destroy', $user->id) }}" />
                    @endif
                </div>
            </td>
            </tr>
            @endforeach
            </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection
