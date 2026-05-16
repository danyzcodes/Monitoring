<section class="space-y-6" x-data="{ confirmDelete: false }">
    <header>
        <h3 class="text-lg font-semibold text-slate-800">Hapus Akun</h3>
        <p class="mt-1 text-sm text-slate-500">
            Setelah akun Anda dihapus, semua data dan informasi akan dihapus secara permanen.
            Pastikan Anda sudah mengunduh data yang ingin disimpan sebelum menghapus akun.
        </p>
    </header>

    <button
        @click="confirmDelete = true"
        type="button"
        class="px-5 py-2 rounded-lg bg-red-600 text-white text-sm font-medium
               hover:bg-red-700 transition">
        Hapus Akun
    </button>

    
    <div
        x-show="confirmDelete"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center">

        
        <div
            x-show="confirmDelete"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="confirmDelete = false"
            class="fixed inset-0 bg-black/40"></div>

        
        <div
            x-show="confirmDelete"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">

            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                
                <div class="flex justify-center mb-4">
                    <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                </div>

                <h3 class="text-lg font-semibold text-slate-800 text-center mb-1">
                    Yakin ingin menghapus akun?
                </h3>
                <p class="text-sm text-slate-500 text-center mb-6">
                    Semua data akan dihapus secara permanen. Masukkan password untuk mengonfirmasi.
                </p>

                <div class="mb-6">
                    <label for="delete_password" class="sr-only">Password</label>
                    <input
                        id="delete_password"
                        name="password"
                        type="password"
                        placeholder="Password Anda"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                               focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition">
                    @error('password', 'userDeletion')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button
                        @click.prevent="confirmDelete = false"
                        type="button"
                        class="flex-1 px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100
                               hover:bg-slate-200 rounded-lg transition">
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-600
                               hover:bg-red-700 rounded-lg transition">
                        Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
