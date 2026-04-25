@extends('layouts.app')

@section('title', 'Edit Data ')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- ================= HEADER ================= -->
    <div class="flex items-center justify-between">
    <div class="flex items-center gap-3 text-slate-500 mb-2">

        <a href="{{ route('deployment.progress-overview') }}"
           class="font-bold text-slate-800 text-xs uppercase tracking-wider hover:text-red-600 transition">
           Progress Overview
        </a>

        <span class="text-slate-300 font-bold">❯</span>

        <a href="{{ route('deployment.update') }}"
           class="font-bold text-slate-800 text-xs uppercase tracking-wider hover:text-red-600 transition">
           Update Data
        </a>

        <span class="text-slate-300 font-bold">❯</span>

        <span class="font-bold text-slate-800 text-xs uppercase tracking-wider">
           Edit Deployment
        </span>

    </div>
</div>

    <form action="{{ route('deployment.update.process', $data->id) }}" method="POST" enctype="multipart/form-data" data-turbo="false"
          x-data="editForm()" x-init="initForm()">
        @csrf
        @method('PUT')

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg shadow-sm animate-fade-in">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h4 class="text-sm font-bold text-red-800 uppercase tracking-wider">Perhatian: Terjadi Kesalahan</h4>
                </div>
                <ul class="list-disc list-inside text-xs text-red-600 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-lg shadow-sm animate-fade-in">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-sm font-bold text-emerald-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- ================= LEFT COLUMN: CUSTOMER INFO ================= -->
            <div class="space-y-6">
                
                <!-- CARD INFO -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-red-600"></div>
                    
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Data Pelanggan
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Nama Pelanggan</label>
                            <div class="font-medium text-slate-800 text-base border-b border-slate-100 pb-2">
                                {{ $data->nama_customer }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Starclick ID</label>
                            <div class="font-mono text-slate-600 text-sm bg-slate-50 px-3 py-2 rounded-lg border border-slate-100">
                                {{ $data->star_click_id }}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Datel</label>
                                <div class="font-medium text-slate-700">{{ $data->datel }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">STO</label>
                                <div class="font-medium text-slate-700">{{ $data->sto }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD TEKNIS -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                        Info Teknis
                    </h3>

                    <div class="space-y-4">
                         <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Status Order</label>
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                {{ optional($data->planning)->status_order ?? '-' }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tipe Desain</label>
                            <div class="font-medium text-slate-700">{{ optional($data->planning)->tipe_desain ?? '-' }}</div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ================= RIGHT COLUMN: UPDATE FORM ================= -->
            <div class="lg:col-span-2 space-y-6">
                 
                <!-- FORM CARD -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
                    <h2 class="text-xl font-bold text-slate-800 mb-6">Update Progres Deployment</h2>
                    
                    <div class="space-y-8">
                        
                        <!-- PROGRES DROPDOWN -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Status Progres Terbaru <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="progres" id="progres" x-model="currentProgress" @change="renderDynamicFields()"
                                    class="w-full appearance-none rounded-xl border border-slate-300 bg-white px-4 py-3 pr-10 text-base focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100 transition shadow-sm">
                                    <option value="">-- Pilih Status --</option>
                                    @foreach ([
                                        'ON DESK','SURVEY','PERIJINAN','DRM','APPROVED BY EBIS',
                                        'MATDEV','INSTALASI','SELESAI FISIK','GOLIVE',
                                        'PS','KENDALA','UJI TERIMA','REKON'
                                    ] as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-4 top-3.5 h-5 w-5 text-slate-400 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>

                         <!-- TANGGAL PROGRESS SELANJUTNYA -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Komitmen Progress Selanjutnya
                            </label>
                            <input type="date" name="commitment_date"
                                value="{{ old('commitment_date', $data->data['commitment_date'] ?? '') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100 transition shadow-sm">
                        </div>


                        <!-- DYNAMIC FIELDS CONTAINER -->
                        <div id="dynamic-fields" class="p-6 bg-slate-50 rounded-xl border border-slate-100 space-y-4 animate-fade-in">
                            <p class="text-sm text-slate-400 italic text-center">Pilih status progres untuk melihat form detail.</p>
                        </div>


                        <!-- KETERANGAN -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Keterangan Tambahan
                            </label>
                            <textarea name="keterangan" rows="3"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100 transition shadow-sm"
                                placeholder="Tambahkan catatan jika diperlukan...">{{ old('keterangan', $data->keterangan) }}</textarea>
                        </div>

                        <!-- ACTIONS -->
                        <div class="flex justify-end gap-4 pt-6 border-t border-slate-100">
                            <a href="{{ route('deployment.update') }}" 
                               class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 transition">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-8 py-2.5 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 hover:shadow-lg transition transform active:scale-95">
                                Update Data
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function editForm() {
        return {
            currentProgress: "{{ old('progres', $data->progres) }}",
            existingData: @json($data->data ?? []),

            initForm() {
                if (this.currentProgress) {
                    this.renderDynamicFields();
                }
            },

            renderDynamicFields() {
                const container = document.getElementById('dynamic-fields');
                const progress = this.currentProgress;
                
                if (!progress || !progressConfig[progress]) {
                    container.innerHTML = '<p class="text-sm text-slate-400 italic text-center">Pilih status progres untuk melihat form detail.</p>';
                    return;
                }

                let html = '<div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">';
                
                progressConfig[progress].forEach(field => {
                    const value = this.existingData && this.existingData[field.name] ? this.existingData[field.name] : '';

                    // TEXT & NUMBER
                    if (['text', 'number', 'date'].includes(field.type)) {
                        let inputType = field.type;
                        let extraAttr = '';
                        let displayValue = value;

                        if (field.type === 'number') {
                            inputType = 'text';
                            extraAttr = `inputmode="numeric" oninput="let val = this.value.replace(/[^0-9]/g, ''); this.value = val.replace(/\\B(?=(\\d{3})+(?!\\d))/g, '.');"`;
                            
                            if (displayValue) {
                                displayValue = String(displayValue).replace(/\./g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            }
                        }

                       html += `
                            <div class="${field.fullWidth ? 'col-span-2' : ''}">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">${field.label}</label>
                                <input type="${inputType}" name="${field.name}" value="${displayValue}" ${extraAttr}
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition bg-white">
                            </div>
                        `;
                    } 
                    
                    // SELECT
                    else if (field.type === 'select') {
                        const options = field.options.map(opt => 
                            `<option value="${opt}" ${opt === value ? 'selected' : ''}>${opt}</option>`
                        ).join('');
                        
                        html += `
                            <div class="${field.fullWidth ? 'col-span-2' : ''}">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">${field.label}</label>
                                <div class="relative">
                                    <select name="${field.name}" class="w-full appearance-none rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition bg-white">
                                        <option value="">-- Pilih --</option>
                                        ${options}
                                    </select>
                                    <svg class="w-4 h-4 absolute right-3 top-3 pointer-events-none text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        `;
                    }

                    // FILE + LINK
                    else if (field.type === 'file') {
                        const linkName = `link_${field.name}`;
                        const linkValue = this.existingData && this.existingData[linkName] ? this.existingData[linkName] : '';

                        html += `
                            <div class="col-span-2 p-4 bg-white rounded-xl border border-slate-200 shadow-sm">
                                <label class="block text-sm font-bold text-slate-700 mb-3 border-b border-slate-100 pb-2">${field.label}</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs text-slate-400 mb-1">Upload Gambar <span class="text-slate-300">(Maks 2MB)</span></label>
                                        <input type="file" name="${field.name}" accept="image/*"
                                            onchange="validateImageFile(this)"
                                            class="w-full text-sm text-slate-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-full file:border-0
                                            file:text-xs file:font-semibold
                                            file:bg-red-50 file:text-red-700
                                            hover:file:bg-red-100">
                                        <p class="text-xs text-slate-400 mt-1">Format: JPG, PNG, GIF, WEBP</p>
                                        <p class="file-error text-xs text-red-500 mt-1 hidden"></p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-slate-400 mb-1">Link Dokumen (Opsional)</label>
                                        <input type="text" name="${linkName}" value="${linkValue}" placeholder="https://"
                                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-red-500 focus:ring-2 focus:ring-red-100 outline-none transition">
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                });

                html += '</div>';
                container.innerHTML = html;
            }
        }
    }

    // CONFIGURATION
    const progressConfig = {
        "ON DESK": [{ name: "boq_on_desk", label: "BoQ On Desk", type: "number" }],
        "SURVEY": [{ name: "boq_survey", label: "BoQ Survey", type: "number" }],
        "PERIJINAN": [{ name: "evidence_perijinan", label: "Evidence Perijinan", type: "file" }],
        "DRM": [{ name: "boq_drm", label: "BoQ DRM", type: "number" }],
        "APPROVED BY EBIS": [{ name: "evidence_approved", label: "Evidence Approved", type: "file" }],
        "MATDEV": [{ name: "evidence_matdev", label: "Evidence Matdev", type: "file" }],
        "INSTALASI": [{ name: "evidence_instalasi", label: "Evidence Instalasi", type: "file" }],
        "SELESAI FISIK": [{ name: "evidence_selesai_fisik", label: "Evidence Selesai Fisik", type: "file" }],
        "GOLIVE": [
            { name: "nama_odp", label: "Nama ODP Golive", type: "text" },
            { name: "id_smallworld", label: "ID Smallworld", type: "text" }
        ],
        "PS": [
            { name: "nomor_order_ps", label: "Nomor Order PS", type: "text" },
            { name: "tanggal_ps", label: "Tanggal PS", type: "date" }
        ],
        "KENDALA": [{ 
            name: "jenis_kendala", 
            label: "Jenis Kendala", 
            type: "select", 
            options: ["PS di SC lain", "Cancel Pelanggan", "Pending Pelanggan", "Perijinan", "Distribusi Habis", "Feeder Habis", "Akses Tidak Layak", "Bisa PT1"] 
        }],
        "UJI TERIMA": [{ 
            name: "status", 
            label: "Status Uji Terima", 
            type: "select", 
            options: ["DITERIMA", "TIDAK DITERIMA"] 
        }],
        "REKON": [{ name: "boq_rekon", label: "BoQ Rekon", type: "number" }]
    };

    function validateImageFile(input) {
        const errorEl = input.parentElement.querySelector('.file-error');
        const maxSize = 2 * 1024 * 1024; // 2MB
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if (errorEl) errorEl.classList.add('hidden');

        if (input.files.length === 0) return;

        const file = input.files[0];

        if (!allowedTypes.includes(file.type)) {
            if (errorEl) {
                errorEl.textContent = 'Hanya file gambar (JPG, PNG, GIF, WEBP) yang diperbolehkan.';
                errorEl.classList.remove('hidden');
            }
            input.value = '';
            return;
        }

        if (file.size > maxSize) {
            if (errorEl) {
                errorEl.textContent = `Ukuran file terlalu besar (${(file.size / 1024 / 1024).toFixed(1)}MB). Maksimal 2MB.`;
                errorEl.classList.remove('hidden');
            }
            input.value = '';
            return;
        }
    }
</script>
<style>
    .animate-fade-in { animation: fadeIn 0.3s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush
@endsection