<section>
    <header>
        <h3 class="text-lg font-semibold text-slate-800">Ubah Password</h3>
        <p class="mt-1 text-sm text-slate-500">
            Pastikan akun Anda menggunakan password yang kuat dan unik.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        
        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-slate-600 mb-1">
                Password Saat Ini
            </label>
            <input id="update_password_current_password" name="current_password" type="password"
                autocomplete="current-password"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                       focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition">
            @error('current_password', 'updatePassword')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        
        <div>
            <label for="update_password_password" class="block text-sm font-medium text-slate-600 mb-1">
                Password Baru
            </label>
            <input id="update_password_password" name="password" type="password"
                autocomplete="new-password"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                       focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition">
            @error('password', 'updatePassword')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-slate-600 mb-1">
                Konfirmasi Password
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                autocomplete="new-password"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                       focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition">
            @error('password_confirmation', 'updatePassword')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        
        <div class="flex items-center gap-4">
            <button type="submit"
                class="px-5 py-2 rounded-lg bg-red-600 text-white text-sm font-medium
                       hover:bg-red-700 transition">
                Simpan Password
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium">
                    Password diperbarui!
                </p>
            @endif
        </div>
    </form>
</section>
