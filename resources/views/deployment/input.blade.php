@extends('layouts.app')

@section('title', 'Input Data ')

@section('content')
    <div class="flex flex-col gap-6">

        {{-- BREADCRUMB --}}
        <div class="flex items-center gap-3 text-sm text-slate-500">
            <a href="{{ route('deployment.progress-overview') }}"
                class="font-bold text-slate-800 text-xs uppercase tracking-wider">Dashboard</a>
            <span class="text-slate-300 font-bold">❯</span>
            <span class="font-bold text-slate-800 text-xs uppercase tracking-wider">input data</span>
        </div>


        <!-- ================= FORM CARD ================= -->
        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-red-600 rounded-t-3xl"></div>

            <div class="p-8">
                <form x-data="ebisForm()" x-init="formEl = $el" method="POST"
                    action="{{ route('ebis.manual.store') }}" class="space-y-8" data-turbo="false">
                    @csrf

                    <!-- ================= SECTION 1: IDENTITAS ORDER ================= -->
                    <div>
                        <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800 mb-6">
                            <span
                                class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-sm">1</span>
                            Identitas Order
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- NDE JT -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    Nomor NDE JT
                                </label>
                                <input name="nde_jt" type="text" value="{{ 'NDE-' . date('ymd-His') }}"
                                    class="w-full rounded-xl border-slate-400 bg-slate-100 px-4 py-3 text-sm focus:bg-white text-slate-600
                                       focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition"
                                    placeholder="Contoh: NDE-123/456" readonly>
                            </div>

                            <!-- STARCLICK -->
                            <div data-field-wrapper>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    Starclick ID / NCX <span class="text-red-500">*</span>
                                </label>
                                <select id="star_click_id" name="star_click_id" data-required="true" class="w-full"
                                    placeholder="Ketik untuk mencari ID dari Order...">
                                    <option value="">Ketik ID Starclick...</option>
                                </select>
                                <p x-show="showError && errorField === 'star_click_id'" x-transition
                                    class="text-xs text-red-500 mt-1 font-medium">Wajib diisi</p>
                                @error('star_click_id')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NOMOR BATCH -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    Nomor Batch
                                </label>
                                <input name="nomor_batch" type="text" value="{{ date('Ym') }}"
                                    class="w-full rounded-xl border-slate-400 bg-slate-100 px-4 py-3 text-sm focus:bg-white text-slate-600
                                       focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition"
                                    placeholder="Contoh: 1234">
                                @error('nomor_batch')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="w-full h-px bg-slate-100"></div>

                    <!-- ================= SECTION 2: DATA PELANGGAN ================= -->
                    <div>
                        <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800 mb-6">
                            <span
                                class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-sm">2</span>
                            Data Pelanggan
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- NAMA -->
                            <div data-field-wrapper>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    Nama Pelanggan <span class="text-red-500">*</span>
                                </label>
                                <input name="nama_customer" type="text" data-required="true"
                                    class="w-full rounded-xl border-slate-400 bg-slate-100 px-4 py-3 text-sm focus:bg-white
                                       focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition"
                                    placeholder="Nama Lengkap">
                                <p x-show="showError && errorField === 'nama_customer'" x-transition
                                    class="text-xs text-red-500 mt-1 font-medium">Wajib diisi</p>
                                @error('nama_customer')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- TELEPON -->
                            <div data-field-wrapper>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    Telepon <span class="text-red-500">*</span>
                                </label>
                                <input name="telepon_pelanggan" type="text" data-required="true"
                                    class="w-full rounded-xl border-slate-400 bg-slate-100 px-4 py-3 text-sm focus:bg-white
                                       focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition"
                                    placeholder="08xxxxxxxxxx">
                                <p x-show="showError && errorField === 'telepon_pelanggan'" x-transition
                                    class="text-xs text-red-500 mt-1 font-medium">Wajib diisi</p>
                                @error('telepon_pelanggan')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- ALAMAT -->
                            <div data-field-wrapper class="md:col-span-2" x-data="{
                                gettingAddress: false,
                                getAddress() {
                                    if (!navigator.geolocation) {
                                        alert('Browser Anda tidak mendukung fitur lokasi');
                                        return;
                                    }
                            
                                    this.gettingAddress = true;
                                    navigator.geolocation.getCurrentPosition(
                                        (position) => {
                                            const lat = position.coords.latitude;
                                            const lng = position.coords.longitude;
                            
                                            // Menggunakan OpenStreetMap Nominatim API untuk mendeteksi nama jalan & kota
                                            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                                                .then(res => res.json())
                                                .then(data => {
                                                    if (data && data.display_name) {
                                                        document.querySelector('input[name=\'alamat_pelanggan\']').value = data.display_name;
                                                    } else {
                                                        alert('Alamat tidak ditemukan dari koordinat ini.');
                                                    }
                                                    this.gettingAddress = false;
                                                })
                                                .catch(err => {
                                                    alert('Gagal mengambil detail alamat dari server.');
                                                    this.gettingAddress = false;
                                                });
                                        },
                                        (error) => {
                                            alert('Gagal mengambil lokasi. Pastikan Anda mengizinkan akses lokasi pada browser.');
                                            this.gettingAddress = false;
                                        }, { enableHighAccuracy: true }
                                    );
                                }
                            }">
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    Alamat Lengkap <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input name="alamat_pelanggan" type="text" data-required="true"
                                        class="w-full rounded-xl border-slate-400 bg-slate-100 pl-10 pr-36 py-3 text-sm focus:bg-white
                                           focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition"
                                        placeholder="Jl. Contoh No. 123">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-slate-400 absolute left-3 top-3.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>

                                    <button type="button" @click="getAddress()"
                                        class="absolute right-1.5 top-1.5 bottom-1.5 px-3 rounded-lg bg-blue-50 text-blue-600 font-bold text-xs hover:bg-blue-100 hover:text-blue-700 transition flex items-center gap-1 focus:ring-2 focus:ring-blue-200 outline-none">
                                        <svg x-show="!gettingAddress" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        <svg x-show="gettingAddress" x-cloak class="animate-spin w-4 h-4"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <span x-text="gettingAddress ? 'Mencari...' : 'Klik Lokasi anda'"></span>
                                    </button>
                                </div>
                                <p x-show="showError && errorField === 'alamat_pelanggan'" x-transition
                                    class="text-xs text-red-500 mt-1 font-medium">Wajib diisi</p>
                                @error('alamat_pelanggan')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- TIKOR -->
                            <div data-field-wrapper x-data="{
                                gettingLocation: false,
                                getLocation() {
                                    if (!navigator.geolocation) {
                                        alert('Browser Anda tidak mendukung fitur lokasi');
                                        return;
                                    }
                            
                                    this.gettingLocation = true;
                                    navigator.geolocation.getCurrentPosition(
                                        (position) => {
                                            const lat = position.coords.latitude;
                                            const lng = position.coords.longitude;
                                            document.querySelector('input[name=\'tikor_pelanggan\']').value = lat + ', ' + lng;
                                            this.gettingLocation = false;
                                        },
                                        (error) => {
                                            alert('Gagal mengambil lokasi. Pastikan Anda mengizinkan akses lokasi pada browser.');
                                            this.gettingLocation = false;
                                        }, { enableHighAccuracy: true }
                                    );
                                }
                            }">
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    Titik Koordinat <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input name="tikor_pelanggan" type="text" data-required="true"
                                        class="w-full rounded-xl border-slate-400 bg-slate-100 pl-4 py-3 pr-32 text-sm focus:bg-white font-mono text-slate-600
                                           focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition"
                                        placeholder="-6.xxxxx, 108.xxxxx">

                                    <button type="button" @click="getLocation()"
                                        class="absolute right-1.5 top-1.5 bottom-1.5 px-3 rounded-lg bg-blue-50 text-blue-600 font-bold text-xs hover:bg-blue-100 hover:text-blue-700 transition flex items-center gap-1 focus:ring-2 focus:ring-blue-200 outline-none">
                                        <svg x-show="!gettingLocation" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <svg x-show="gettingLocation" x-cloak class="animate-spin w-4 h-4"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <span x-text="gettingLocation ? 'Mencari...' : 'Klik Lokasi anda'"></span>
                                    </button>
                                </div>
                                <p x-show="showError && errorField === 'tikor_pelanggan'" x-transition
                                    class="text-xs text-red-500 mt-1 font-medium">Wajib diisi</p>
                                @error('tikor_pelanggan')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="w-full h-px bg-slate-100"></div>

                    <!-- ================= SECTION 3: LOKASI & TEKNIS ================= -->
                    <div>
                        <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800 mb-6">
                            <span
                                class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-sm">3</span>
                            Lokasi & Teknis
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- DATEL -->
                            <div id="datel_wrapper" data-field-wrapper x-data="searchableSelect(@js($datels))" class="relative">
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    Datel <span class="text-red-500">*</span>
                                </label>

                                <div class="relative">
                                    <input type="text" x-model="search" @focus="open = true" @click="open = true"
                                        @input="open = true; clearIfEmpty()" @blur="clearIfEmpty()"
                                        class="w-full rounded-xl border-slate-400 bg-slate-100 px-4 py-3 text-sm focus:bg-white
                                              focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition"
                                        placeholder="Pilih Datel">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4 text-slate-400 absolute right-4 top-3.5 pointer-events-none"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                                <input type="hidden" name="datel" x-model="selected" data-required="true">

                                <!-- DROPDOWN -->
                                <div x-show="open" @click.outside="open = false" x-transition.opacity
                                    class="absolute z-50 mt-1 w-full bg-white border border-slate-100 rounded-xl shadow-xl max-h-48 overflow-y-auto">
                                    <template x-for="item in filtered()" :key="item">
                                        <div @click="select(item)"
                                            class="px-4 py-2.5 text-sm cursor-pointer hover:bg-red-50 text-slate-700 hover:text-red-700 transition">
                                            <span x-text="item"></span>
                                        </div>
                                    </template>
                                    <div x-show="filtered().length === 0"
                                        class="px-4 py-3 text-sm text-slate-400 italic text-center">Tidak ditemukan</div>
                                </div>

                                <p x-show="showError && errorField === 'datel'" x-transition
                                    class="text-xs text-red-500 mt-1 font-medium">Wajib dipilih</p>
                            </div>

                            <!-- STO -->
                            <div id="sto_wrapper" data-field-wrapper x-data="searchableSelect(@js($stos))" class="relative">
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    STO <span class="text-red-500">*</span>
                                </label>

                                <div class="relative">
                                    <input type="text" x-model="search" @focus="open = true" @click="open = true"
                                        @input="open = true; clearIfEmpty()" @blur="clearIfEmpty()"
                                        class="w-full rounded-xl border-slate-400 bg-slate-100 px-4 py-3 text-sm focus:bg-white
                                              focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition"
                                        placeholder="Pilih STO">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4 text-slate-400 absolute right-4 top-3.5 pointer-events-none"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                                <input type="hidden" name="sto" x-model="selected" data-required="true">

                                <div x-show="open" @click.outside="open = false" x-transition.opacity
                                    class="absolute z-50 mt-1 w-full bg-white border border-slate-100 rounded-xl shadow-xl max-h-48 overflow-y-auto">
                                    <template x-for="item in filtered()" :key="item">
                                        <div @click="select(item)"
                                            class="px-4 py-2.5 text-sm cursor-pointer hover:bg-red-50 text-slate-700 hover:text-red-700 transition">
                                            <span x-text="item"></span>
                                        </div>
                                    </template>
                                    <div x-show="filtered().length === 0"
                                        class="px-4 py-3 text-sm text-slate-400 italic text-center">Tidak ditemukan</div>
                                </div>

                                <p x-show="showError && errorField === 'sto'" x-transition
                                    class="text-xs text-red-500 mt-1 font-medium">Wajib dipilih</p>
                            </div>
                        </div>

                        <!-- MITRA -->
                        <div class="mt-6">
                            <div data-field-wrapper x-data="searchableSelect(@js($mitras))" class="relative">
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    Mitra Pelaksana <span class="text-red-500">*</span>
                                </label>

                                <div class="relative">
                                    <input type="text" x-model="search" @focus="open = true" @click="open = true"
                                        @input="open = true; clearIfEmpty()" @blur="clearIfEmpty()"
                                        class="w-full rounded-xl border-slate-400 bg-slate-100 px-4 py-3 text-sm focus:bg-white
                                            focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition"
                                        placeholder="Pilih Mitra">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4 text-slate-400 absolute right-4 top-3.5 pointer-events-none"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                                <input type="hidden" name="nama_mitra" x-model="selected" data-required="true">

                                <div x-show="open" @click.outside="open = false" x-transition.opacity
                                    class="absolute z-50 mt-1 w-full bg-white border border-slate-100 rounded-xl shadow-xl max-h-48 overflow-y-auto">
                                    <template x-for="item in filtered()" :key="item">
                                        <div @click="select(item)"
                                            class="px-4 py-2.5 text-sm cursor-pointer hover:bg-red-50 text-slate-700 hover:text-red-700 transition">
                                            <span x-text="item"></span>
                                        </div>
                                    </template>
                                    <div x-show="filtered().length === 0"
                                        class="px-4 py-3 text-sm text-slate-400 italic text-center">Tidak ditemukan</div>
                                </div>

                                <p x-show="showError && errorField === 'nama_mitra'" x-transition
                                    class="text-xs text-red-500 mt-1 font-medium">Wajib dipilih</p>
                                @error('nama_mitra')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- TomSelect styles have been consolidated at the bottom -->

                    <!-- ================= BUTTONS ================= -->
                    <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" onclick="history.back()"
                            class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-semibold text-sm hover:bg-slate-50 transition">
                            Batal
                        </button>
                        <button type="button" @click="initiateSubmit()"
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-red-600 to-red-500 text-white font-semibold text-sm hover:shadow-lg hover:-translate-y-0.5 transition duration-300">
                            Simpan Data
                        </button>
                    </div>

                    {{-- ====================== CONFIRM MODAL ====================== --}}
                    <template x-teleport="body">
                        <div x-show="confirmOpen" x-cloak
                            class="fixed inset-0 z-[100] flex items-end sm:items-center justify-center p-4">

                            {{-- Backdrop --}}
                            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
                                @click="confirmOpen = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0">
                            </div>

                            {{-- Modal Card --}}
                            <div class="relative z-10 w-full max-w-xs"
                                x-transition:enter="transition ease-out duration-250"
                                x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                x-transition:leave-end="opacity-0 translate-y-4 scale-95">

                                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

                                    {{-- ── Gradient Header ── --}}
                                    <div class="relative px-6 pt-6 pb-5 bg-gradient-to-br from-slate-800 to-slate-900 overflow-hidden">
                                        {{-- Decorative --}}
                                        <div class="absolute -top-6 -right-6 w-28 h-28 rounded-full bg-white/5"></div>
                                        <div class="absolute -bottom-4 -left-4 w-20 h-20 rounded-full bg-white/5"></div>

                                        <div class="relative flex items-start gap-4">
                                            {{-- Icon --}}
                                            <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                                </svg>
                                            </div>
                                            <div class="pt-0.5">
                                                <h3 class="text-lg font-bold text-white leading-tight">Konfirmasi Simpan</h3>
                                                <p class="text-sm text-white/60 mt-0.5">Pastikan data sudah benar sebelum disimpan</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ── Data Preview ── --}}
                                   

                                    {{-- ── Action Buttons ── --}}
                                    <div class="px-4 py-4 flex flex-col gap-2">

                                        {{-- Primary: Simpan --}}
                                        <button type="button" @click="finalSubmit()"
                                            :disabled="submitting"
                                            class="group relative w-full flex items-center justify-center gap-2.5
                                                   px-5 py-3 rounded-2xl overflow-hidden
                                                   bg-gradient-to-r from-red-600 to-rose-500
                                                   hover:from-red-700 hover:to-rose-600
                                                   shadow-md shadow-red-500/25
                                                   transition-all duration-200
                                                   disabled:opacity-70 disabled:cursor-not-allowed
                                                   focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2">
                                            {{-- Spinner (muncul saat submitting) --}}
                                            <svg x-show="submitting" class="animate-spin w-4 h-4 text-white shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            {{-- Centang icon (normal) --}}
                                            <svg x-show="!submitting" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                            <span class="text-sm font-bold text-white" x-text="submitting ? 'Menyimpan...' : 'Ya, Simpan Data'"></span>
                                        </button>

                                        {{-- Secondary: Batalkan --}}
                                        <button type="button" @click="confirmOpen = false"
                                            class="group w-full flex items-center justify-between
                                                   px-5 py-3.5 rounded-2xl
                                                   bg-slate-100 hover:bg-slate-200
                                                   transition-all duration-200
                                                   focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-xl bg-slate-200 group-hover:bg-slate-300 flex items-center justify-center transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </div>
                                                <div class="text-left">
                                                    <p class="text-sm font-semibold text-slate-700 leading-tight">Batalkan</p>
                                                    <p class="text-[10px] text-slate-400 leading-none mt-0.5">Kembali untuk periksa data</p>
                                                </div>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                            </svg>
                                        </button>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- Script: populate preview sebelum modal muncul --}}
                    @push('scripts')
                    <script>
                        document.addEventListener('alpine:init', () => {
                            // patch initiateSubmit untuk populate preview
                            const origEbisForm = window.ebisForm;
                            window.ebisFormWithPreview = function() {
                                const base = origEbisForm();
                                const _orig = base.initiateSubmit.bind(base);
                                base.initiateSubmit = function() {
                                    _orig();
                                    if (this.valid) {
                                        // populate preview data
                                        const nama = document.querySelector('input[name="nama_customer"]')?.value || '—';
                                        const starclick = document.querySelector('#star_click_id')?.tomselect?.getValue() ||
                                                          document.querySelector('input[name="nama_customer"]')?.value || '—';
                                        const datel = document.querySelector('input[name="datel"]')?.value ||
                                                      document.querySelector('[name="datel"]')?.value || '—';
                                        const sto   = document.querySelector('input[name="sto"]')?.value ||
                                                      document.querySelector('[name="sto"]')?.value || '—';

                                        document.getElementById('preview_nama').textContent = nama;
                                        document.getElementById('preview_starclick').textContent = starclick;
                                        document.getElementById('preview_lokasi').textContent = datel + ' / ' + sto;
                                    }
                                };
                                return base;
                            };
                        });
                    </script>
                    @endpush

                </form>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.default.min.css">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <style>
        /* StarClick TomSelect overrides (Tailwind matching) */
        .ts-wrapper.starclick-select .ts-control {
            border-radius: 0.75rem !important;
            border: 1px solid #94a3b8 !important;
            background-color: #f1f5f9 !important; /* Tailwind bg-slate-100 */
            padding: 0.85rem 1rem !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            min-height: auto !important;
            box-shadow: none !important;
            transition: all 0.2s ease-in-out;
            color: #475569 !important; /* Tailwind text-slate-600 */
        }

        .ts-wrapper.starclick-select.focus .ts-control {
            background-color: #ffffff !important;
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 2px rgba(254, 226, 226, 1) !important;
        }

        .ts-wrapper.starclick-select .ts-control>input {
            font-weight: 500 !important;
            font-size: 0.875rem !important;
        }

        /* Dropdown yang di-attach ke body */
        .ts-dropdown {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12) !important;
            z-index: 9999 !important;
            overflow: hidden;
            margin-top: 4px !important;
        }

        .ts-dropdown .option {
            padding: 10px 14px;
            font-size: 0.85rem;
            color: #334155;
            cursor: pointer;
        }

        .ts-dropdown .option:hover,
        .ts-dropdown .option.active {
            background: #fef2f2 !important;
            color: #dc2626 !important;
        }

        .ts-dropdown .no-results,
        .ts-dropdown .loading {
            padding: 10px 14px;
            color: #94a3b8;
            font-size: 0.85rem;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function ebisForm() {
            return {
                formEl: null,
                confirmOpen: false,
                submitting: false,
                valid: true,
                showError: false,
                errorField: null,
                invalidField: null,

                checkRequired() {
                    const requiredFields = [...this.formEl.querySelectorAll('[data-required=true]')];
                    this.valid = true;
                    this.invalidField = null;
                    this.errorField = null;

                    // Reset styles
                    this.formEl.querySelectorAll('[data-field-wrapper]').forEach(wrapper => {
                        const input = wrapper.querySelector('input');
                        if (input) input.classList.remove('border-red-500', 'ring-2', 'ring-red-100');
                    });

                    for (let field of requiredFields) {
                        if (!field.value || field.value.trim() === '') {
                            this.valid = false;
                            this.invalidField = field;
                            this.errorField = field.getAttribute('name');

                            // Style the visible input
                            const wrapper = field.closest('[data-field-wrapper]');
                            const target = field.type === 'hidden' ? wrapper?.querySelector('input[type="text"]') : field;

                            target?.classList.add('border-red-500', 'ring-2', 'ring-red-100');
                            break;
                        }
                    }
                },

                scrollToInvalid() {
                    if (!this.invalidField) return;
                    let target = this.invalidField;
                    if (this.invalidField.type === 'hidden') {
                        target = this.invalidField.closest('[data-field-wrapper]')?.querySelector('input[type="text"]');
                    }

                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        setTimeout(() => target.focus(), 500);
                    }
                },

                initiateSubmit() {
                    this.showError = true;
                    this.checkRequired();

                    if (!this.valid) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Data Belum Lengkap',
                            text: 'Mohon lengkapi semua field bertanda bintang (*)',
                            confirmButtonColor: '#dc2626',
                            confirmButtonText: 'OK'
                        }).then(() => this.scrollToInvalid());
                        return;
                    }

                    // Populate preview ringkasan data
                    const nama      = document.querySelector('input[name="nama_customer"]')?.value || '—';
                    const tomselect = document.getElementById('star_click_id')?.tomselect;
                    const starclick = tomselect ? (tomselect.getValue() || '—') : '—';
                    const datel     = document.querySelector('input[name="datel"]')?.value || '—';
                    const sto       = document.querySelector('input[name="sto"]')?.value || '—';

                    const elNama      = document.getElementById('preview_nama');
                    const elStar      = document.getElementById('preview_starclick');
                    const elLokasi    = document.getElementById('preview_lokasi');
                    if (elNama)   elNama.textContent   = nama;
                    if (elStar)   elStar.textContent   = starclick;
                    if (elLokasi) elLokasi.textContent = datel + ' / ' + sto;

                    this.confirmOpen = true;
                },

                finalSubmit() {
                    this.submitting = true;
                    // Beri waktu untuk animasi spinner muncul sebelum form di-submit
                    setTimeout(() => this.formEl.submit(), 300);
                }
            }
        }

        function searchableSelect(items) {
            return {
                open: false,
                search: '',
                selected: '',

                filtered() {
                    return items.filter(item => item.toLowerCase().includes(this.search.toLowerCase()));
                },

                select(item) {
                    this.selected = item;
                    this.search = item;
                    this.open = false;
                },

                clearIfEmpty() {
                    if (this.search.trim() === '') this.selected = '';
                }
            }
        }

        // TomSelect initialization for StarClick AJAX Auto-Complete
        function initTomSelect() {
            if (typeof TomSelect === 'undefined') {
                setTimeout(initTomSelect, 100);
                return;
            }

            const starClickEl = document.getElementById('star_click_id');

            if (!starClickEl) return;

            // 🔥 cegah double init (tanpa ubah desain)
            if (starClickEl.tomselect) {
                starClickEl.tomselect.destroy();
            }

            new TomSelect('#star_click_id', {
                wrapperClass: 'ts-wrapper single starclick-select', 
                valueField: 'id',
                labelField: 'text',
                searchField: ['id', 'text'],
                placeholder: 'Ketik ID Starclick...',
                dropdownParent: 'body',

                preload: true, 

                create: function(input) {
                    return {
                        id: input,
                        text: input
                    };
                },

                load: function(query, callback) {
                    fetch('/deployment/api/search-starclick?q=' + encodeURIComponent(query))
                        .then(r => r.json())
                        .then(json => {
                            // 🔥 pastikan format aman tanpa ubah desain
                            const data = (json || []).map(item => ({
                                id: item.id,
                                text: item.text || item.id,
                                nama_customer: item.nama_customer || ''
                            }));
                            callback(data);
                        })
                        .catch(() => callback());
                },

                onChange: function(value) {
                    const item = this.options[value];
                    if (item && item.id !== item.text) {
                        const nameInput = document.querySelector('input[name="nama_customer"]');
                        if (nameInput && item.nama_customer) {
                            nameInput.value = item.nama_customer;
                        }
                    }
                }
            });
        }

        // event tetap (tidak ubah flow kamu)
        document.addEventListener('DOMContentLoaded', initTomSelect);
        document.addEventListener('turbo:load', initTomSelect);
    </script>
@endsection
