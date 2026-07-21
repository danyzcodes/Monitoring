@extends('layouts.app')

@section('title', 'Input Data ')

@section('content')
    <div class="flex flex-col gap-6">

        
        <div class="flex items-center gap-3 text-sm text-slate-500">
            <a href="{{ route('deployment.progress-overview') }}"
                class="font-bold text-slate-800 text-xs uppercase tracking-wider">Dashboard</a>
            <span class="text-slate-300 font-bold">❯</span>
            <span class="font-bold text-slate-800 text-xs uppercase tracking-wider">input data</span>
        </div>

        
        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 relative">

            <div class="p-8">
                <form x-data="ebisForm()" x-init="formEl = $el" method="POST"
                    action="{{ route('ebis.manual.store') }}" class="space-y-8" data-turbo="false">
                    @csrf

                    
                    <div>
                        <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800 mb-6">
                            Identitas Order
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    Nomor NDE JT
                                </label>
                                <input name="nde_jt" type="text" value="{{ old('nde_jt') }}"
                                    class="w-full rounded-xl border border-slate-400 bg-slate-100 px-4 py-3 text-sm focus:bg-white
                                       focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition"
                                    placeholder="Contoh: NDE-123/456">
                            </div>

                            
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

                            
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    Nomor Batch
                                </label>
                                <select id="nomor_batch" name="nomor_batch" class="w-full" placeholder="Pilih Nomor Batch...">
                                    <option value="">Pilih Nomor Batch...</option>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('nomor_batch')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="w-full h-px bg-slate-100"></div>

                    
                    <div>
                        <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800 mb-6">
                            Data Pelanggan
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            
                            <div data-field-wrapper>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    Nama Pelanggan <span class="text-red-500">*</span>
                                </label>
                                <input name="nama_customer" type="text" data-required="true"
                                    class="w-full rounded-xl border border-slate-400 bg-slate-100 px-4 py-3 text-sm focus:bg-white
                                       focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition"
                                    placeholder="Nama Lengkap">
                                <p x-show="showError && errorField === 'nama_customer'" x-transition
                                    class="text-xs text-red-500 mt-1 font-medium">Wajib diisi</p>
                                @error('nama_customer')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            
                            <div data-field-wrapper>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    Telepon <span class="text-red-500">*</span>
                                </label>
                                <input name="telepon_pelanggan" type="text" data-required="true"
                                    class="w-full rounded-xl border border-slate-400 bg-slate-100 px-4 py-3 text-sm focus:bg-white
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
                            <div data-field-wrapper class="md:col-span-2 relative" x-data="{
                                value: '',
                                suggestions: [],
                                loading: false,
                                open: false,
                                timeout: null,
                                
                                fetchSuggestions() {
                                    if (this.value.trim().length < 4) {
                                        this.suggestions = [];
                                        this.open = false;
                                        return;
                                    }
                                    
                                    this.loading = true;
                                    this.open = true;
                                    
                                    if (this.timeout) clearTimeout(this.timeout);
                                    
                                    this.timeout = setTimeout(() => {
                                        let query = this.value.trim();
                                        if (!query.toLowerCase().includes('jawa barat') && !query.toLowerCase().includes('jabar')) {
                                            query += ', Jawa Barat';
                                        }
                                        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&limit=5`)
                                            .then(res => res.json())
                                            .then(data => {
                                                this.suggestions = data || [];
                                                this.loading = false;
                                            })
                                            .catch(() => {
                                                this.loading = false;
                                            });
                                    }, 600);
                                },
                                
                                select(item) {
                                    this.value = item.display_name;
                                    this.open = false;
                                    this.suggestions = [];
                                    
                                    // Auto-fill coordinates via event dispatch
                                    window.dispatchEvent(new CustomEvent('address-selected', {
                                        detail: { lat: item.lat, lon: item.lon }
                                    }));
                                },

                                fetchIpLocation(reason = '') {
                                    console.log('Using IP Geolocation fallback. Reason:', reason);

                                    const handleIpData = (lat, lon, city = '', region = '') => {
                                        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                                            .then(res => res.json())
                                            .then(data => {
                                                this.value = data.display_name || `${city || ''}, ${region || ''}, Indonesia`;
                                                this.loading = false;
                                                window.dispatchEvent(new CustomEvent('address-selected', {
                                                    detail: { lat: lat, lon: lon }
                                                }));
                                            })
                                            .catch(() => {
                                                this.value = `${city || ''}, ${region || ''}, Indonesia`;
                                                this.loading = false;
                                                window.dispatchEvent(new CustomEvent('address-selected', {
                                                    detail: { lat: lat, lon: lon }
                                                }));
                                            });
                                    };

                                    // First try: ipapi.co
                                    fetch('https://ipapi.co/json/')
                                        .then(res => res.json())
                                        .then(ipData => {
                                            if (ipData.latitude && ipData.longitude) {
                                                handleIpData(ipData.latitude, ipData.longitude, ipData.city, ipData.region);
                                            } else {
                                                throw new Error('IP Location data invalid');
                                            }
                                        })
                                        .catch((err) => {
                                            console.log('ipapi.co failed, trying ipinfo.io...', err);
                                            // Second try: ipinfo.io
                                            fetch('https://ipinfo.io/json')
                                                .then(res => res.json())
                                                .then(ipData => {
                                                    if (ipData.loc) {
                                                        const parts = ipData.loc.split(',');
                                                        const lat = parseFloat(parts[0]);
                                                        const lon = parseFloat(parts[1]);
                                                        handleIpData(lat, lon, ipData.city, ipData.region);
                                                    } else {
                                                        throw new Error('ipinfo.io data invalid');
                                                    }
                                                })
                                                .catch((err2) => {
                                                    console.log('ipinfo.io failed as well:', err2);
                                                    this.loading = false;
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Gagal Mengambil Lokasi',
                                                        text: 'Lokasi GPS tidak dapat diakses dan pencarian lokasi berbasis IP gagal. Silakan isi koordinat secara manual.',
                                                        confirmButtonColor: '#dc2626'
                                                    });
                                                });
                                        });
                                },

                                getCurrentLocation() {
                                    if (!window.isSecureContext) {
                                        this.fetchIpLocation('insecure');
                                        return;
                                    }

                                    if (!navigator.geolocation) {
                                        this.fetchIpLocation();
                                        return;
                                    }
                                    
                                    this.loading = true;
                                    
                                    navigator.geolocation.getCurrentPosition(
                                        (position) => {
                                            const lat = position.coords.latitude;
                                            const lon = position.coords.longitude;
                                            
                                            // Reverse geocode via Nominatim
                                            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                                                .then(res => res.json())
                                                .then(data => {
                                                    this.value = data.display_name || `${lat}, ${lon}`;
                                                    this.loading = false;
                                                    
                                                    // Auto-fill coordinates via event dispatch
                                                    window.dispatchEvent(new CustomEvent('address-selected', {
                                                        detail: { lat: lat, lon: lon }
                                                    }));
                                                })
                                                .catch(() => {
                                                    this.value = `${lat}, ${lon}`;
                                                    this.loading = false;
                                                    window.dispatchEvent(new CustomEvent('address-selected', {
                                                        detail: { lat: lat, lon: lon }
                                                    }));
                                                });
                                        },
                                        (error) => {
                                            console.log('GPS Geolocation failed. Code:', error.code, 'Message:', error.message);
                                            let reason = '';
                                            if (error.code === error.PERMISSION_DENIED) {
                                                reason = 'denied';
                                            }
                                            this.fetchIpLocation(reason);
                                        },
                                        {
                                            enableHighAccuracy: true,
                                            timeout: 10000,
                                            maximumAge: 0
                                        }
                                    );
                                }
                            }">
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Alamat Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <button type="button" @click="getCurrentLocation()"
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold
                                               bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Gunakan Lokasi Saat Ini
                                    </button>
                                </div>
                                <div class="relative">
                                    <input name="alamat_pelanggan" type="text" data-required="true"
                                        x-model="value"
                                        @input="fetchSuggestions()"
                                        @focus="if (suggestions.length > 0) open = true"
                                        @click.outside="open = false"
                                        class="w-full rounded-xl border border-slate-400 bg-slate-100 pl-10 pr-12 py-3 text-sm focus:bg-white
                                           focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition"
                                        placeholder="Ketik alamat pelanggan...">
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-slate-400 absolute left-3 top-3.5 pointer-events-none" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    
                                    <div x-show="loading" x-cloak class="absolute right-4 top-3.5">
                                        <svg class="animate-spin h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                </div>

                                <div x-show="open" x-cloak
                                    style="position: absolute; left: 0; right: 0; z-index: 50; margin-top: 4px;"
                                    class="bg-white border border-slate-100 rounded-xl shadow-xl max-h-60 overflow-y-auto">
                                    <template x-for="item in suggestions" :key="item.place_id">
                                        <div @click="select(item)"
                                            class="px-4 py-3 text-xs cursor-pointer hover:bg-red-50 text-slate-700 hover:text-red-700 transition border-b border-slate-50 last:border-0">
                                            <span x-text="item.display_name"></span>
                                        </div>
                                    </template>
                                    <div x-show="!loading && suggestions.length === 0"
                                        class="px-4 py-3 text-xs text-slate-400 italic text-center">Mengetik alamat... (gunakan minimal 4 karakter)</div>
                                </div>

                                <p x-show="showError && errorField === 'alamat_pelanggan'" x-transition
                                    class="text-xs text-red-500 mt-1 font-medium">Wajib diisi</p>
                                @error('alamat_pelanggan')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
 
                             
                            <div data-field-wrapper x-data="{}"
                            x-on:address-selected.window="if($event.detail.lat && $event.detail.lon) { document.querySelector('input[name=\'tikor_pelanggan\']').value = $event.detail.lat + ', ' + $event.detail.lon }">
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    Titik Koordinat <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input name="tikor_pelanggan" type="text" data-required="true"
                                        class="w-full rounded-xl border border-slate-400 bg-slate-100 px-4 py-3 text-sm focus:bg-white font-mono text-slate-600
                                           focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition"
                                        placeholder="-6.xxxxx, 108.xxxxx">
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

                    
                    <div>
                        <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800 mb-6">
                            Lokasi & Teknis
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div id="datel_wrapper" data-field-wrapper x-data="searchableSelect(@js($datels))" class="relative">
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    Datel <span class="text-red-500">*</span>
                                </label>

                                <div class="relative">
                                    <input type="text" x-model="search" @focus="open = true" @click="open = true"
                                        @input="open = true; updateSelected()" @blur="updateSelected()"
                                        class="w-full rounded-xl border border-slate-400 bg-slate-100 px-4 py-3 text-sm focus:bg-white
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

                                
                                <div x-show="open" @click.outside="open = false"
                                    style="position: absolute; z-index: 50; margin-top: 4px; width: 100%;"
                                    class="bg-white border border-slate-100 rounded-xl shadow-xl max-h-48 overflow-y-auto">
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

                            
                            <div id="sto_wrapper" data-field-wrapper x-data="searchableSelect(@js($stos))" class="relative">
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    STO <span class="text-red-500">*</span>
                                </label>

                                <div class="relative">
                                    <input type="text" x-model="search" @focus="open = true" @click="open = true"
                                        @input="open = true; updateSelected()" @blur="updateSelected()"
                                        class="w-full rounded-xl border border-slate-400 bg-slate-100 px-4 py-3 text-sm focus:bg-white
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

                                <div x-show="open" @click.outside="open = false"
                                    style="position: absolute; z-index: 50; margin-top: 4px; width: 100%;"
                                    class="bg-white border border-slate-100 rounded-xl shadow-xl max-h-48 overflow-y-auto">
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

                        
                        <div class="mt-6">
                            <div data-field-wrapper x-data="searchableSelect(@js($mitras))" class="relative">
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    Mitra Pelaksana <span class="text-red-500">*</span>
                                </label>

                                <div class="relative">
                                    <input type="text" x-model="search" @focus="open = true" @click="open = true"
                                        @input="open = true; clearIfEmpty()" @blur="clearIfEmpty()"
                                        class="w-full rounded-xl border border-slate-400 bg-slate-100 px-4 py-3 text-sm focus:bg-white
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

                                <div x-show="open" @click.outside="open = false"
                                    style="position: absolute; z-index: 50; margin-top: 4px; width: 100%;"
                                    class="bg-white border border-slate-100 rounded-xl shadow-xl max-h-48 overflow-y-auto">
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

                    
                    <template x-teleport="body">
                        <div x-show="confirmOpen" x-cloak
                            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50">

                            
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-6">
                                <h3 class="text-lg font-bold text-slate-800 mb-2">Konfirmasi Simpan</h3>
                                <p class="text-sm text-slate-600 mb-6">Apakah data sudah benar dan ingin disimpan?</p>

                                
                                <div class="flex flex-col gap-3">
                                    <button type="button" @click="finalSubmit()"
                                        :disabled="submitting"
                                        class="w-full py-3 px-4 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span x-text="submitting ? 'Menyimpan...' : 'Ya, Simpan'"></span>
                                    </button>

                                    <button type="button" @click="confirmOpen = false"
                                        class="w-full py-3 px-4 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold">
                                        Batalkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>

                    
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
        
        .ts-wrapper.starclick-select .ts-control,
        .ts-wrapper.batch-select .ts-control {
            border-radius: 0.75rem !important;
            border: 1px solid #94a3b8 !important;
            background-color: #f1f5f9 !important; 
            padding: 0 1rem !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            min-height: 46px !important;
            height: 46px !important;
            display: flex !important;
            align-items: center !important;
            box-shadow: none !important;
            transition: all 0.2s ease-in-out;
            color: #475569 !important; 
        }

        .ts-wrapper.starclick-select.focus .ts-control,
        .ts-wrapper.batch-select.focus .ts-control {
            background-color: #ffffff !important;
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 2px rgba(254, 226, 226, 1) !important;
        }

        .ts-wrapper.starclick-select .ts-control>input,
        .ts-wrapper.batch-select .ts-control>input {
            font-weight: 500 !important;
            font-size: 0.875rem !important;
            margin: 0 !important;
        }
        
        .ts-wrapper.starclick-select .ts-control .item,
        .ts-wrapper.batch-select .ts-control .item {
            margin: 0 !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        
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
                },

                updateSelected() {
                    this.selected = this.search.trim();
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

            if (starClickEl) {
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
                    createOnBlur: true,
                    preload: true,

                    create: function(input) {
                        return {
                            id: input,
                            text: input
                        };
                    },

                    onChange: function(value) {
                        if (!value) return;
                        const option = this.options[value];
                        if (option) {
                            if (option.nama_customer) {
                                const customerInput = document.querySelector('input[name="nama_customer"]');
                                if (customerInput) {
                                    customerInput.value = option.nama_customer;
                                }
                            }
                            window.dispatchEvent(new CustomEvent('starclick-selected', { detail: option }));
                        }
                    },

                    load: function(query, callback) {
                        fetch('/deployment/api/search-starclick?q=' + encodeURIComponent(query))
                            .then(r => r.json())
                            .then(json => {
                                // 🔥 pastikan format aman tanpa ubah desain
                                // Note: API already filters out used Starclick IDs
                                const data = (json || []).map(item => ({
                                    id: item.id,
                                    text: item.text || item.id,
                                    nama_customer: item.nama_customer || '',
                                    datel: item.datel || '',
                                    sto: item.sto || ''
                                }));
                                callback(data);
                            })
                            .catch(() => callback());
                    }
                });
            }

            const nomorBatchEl = document.getElementById('nomor_batch');
            if (nomorBatchEl) {
                if (nomorBatchEl.tomselect) {
                    nomorBatchEl.tomselect.destroy();
                }

                new TomSelect('#nomor_batch', {
                    wrapperClass: 'ts-wrapper single batch-select',
                    create: function(input) {
                        const trimmed = input.trim();
                        // Hanya izinkan input berupa angka (numeric)
                        if (isNaN(trimmed) || trimmed === '') {
                            return false;
                        }
                        return {
                            value: trimmed,
                            text: trimmed
                        };
                    },
                    placeholder: 'Pilih Nomor Batch...',
                    dropdownParent: 'body',
                    createOnBlur: true
                });
            }
        }

        // event tetap (tidak ubah flow kamu)
        document.addEventListener('DOMContentLoaded', initTomSelect);
        document.addEventListener('turbo:load', initTomSelect);
    </script>
@endsection
