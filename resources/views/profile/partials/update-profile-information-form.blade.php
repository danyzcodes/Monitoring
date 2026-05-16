<section>
    <header>
        <h3 class="text-lg font-semibold text-slate-800">Informasi Profil</h3>
        <p class="mt-1 text-sm text-slate-500">
            Perbarui nama dan alamat email akun Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        
        <div>
            <label for="name" class="block text-sm font-medium text-slate-600 mb-1">Nama</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                required autofocus autocomplete="name"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                       focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition">
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        
        <div>
            <label for="email" class="block text-sm font-medium text-slate-600 mb-1">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                required autocomplete="username"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                       focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition">
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-slate-600">
                        Email Anda belum diverifikasi.
                        <button form="send-verification"
                            class="underline text-sm text-red-600 hover:text-red-700 font-medium">
                            Klik di sini untuk mengirim ulang link verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            Link verifikasi baru telah dikirim ke email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        
        <div>
            <label for="telegram_phone" class="block text-sm font-medium text-slate-600 mb-1">Nomor Telegram (Opsional)</label>
            <input id="telegram_phone" name="telegram_phone" type="text" value="{{ old('telegram_phone', $user->telegram_phone) }}"
                placeholder="Contoh: 081234567890"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                       focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition">
            <p class="mt-1 text-xs text-slate-500">Gunakan nomor yang terdaftar di Telegram untuk menerima notifikasi otomatis.</p>
            @error('telegram_phone')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        
        <div class="flex items-center gap-4">
            <button type="submit"
                class="px-5 py-2 rounded-lg bg-red-600 text-white text-sm font-medium
                       hover:bg-red-700 transition">
                Simpan
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium">
                    Tersimpan!
                </p>
            @endif
        </div>
    </form>
</section>
