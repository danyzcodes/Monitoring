@extends('layouts.app')
@section('title', 'Upload Data ')


@section('content')
<div class="flex flex-col gap-6">

    
    <div class="flex items-center gap-3 text-sm text-slate-500">
        <a href="{{ route('deployment.progress-overview') }}" class="font-bold text-slate-800 text-xs uppercase tracking-wider">Dashboard</a>
        <span class="text-slate-300 font-bold">❯</span>
        <span class="font-bold text-slate-800 text-xs uppercase tracking-wider">upload</span>
    </div>
    
    

    
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border relative" style="border-color:#fde8e8; box-shadow: 0 20px 40px rgba(227,43,43,0.08);">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-red-600"></div>
        
        <div class="p-4 sm:p-8">
            <form id="importForm" action="{{ route('ebis.import') }}" method="POST" enctype="multipart/form-data" class="relative">
                @csrf
                
                <input type="file" name="file" id="fileInput" class="hidden" accept=".xlsx,.xls" onchange="handleFileSelect(this)">

                <div id="dropZone" 
                     class="group relative w-full rounded-2xl border-2 border-dashed border-red-300 bg-red-50/30
                            flex flex-col items-center justify-center text-center cursor-pointer
                            hover:border-red-400 hover:bg-red-50/50 transition-all duration-300"
                     style="min-height: 180px; padding: 2rem 1rem;"
                     ondragover="handleDragOver(event)"
                     ondragleave="handleDragLeave(event)"
                     ondrop="handleDrop(event)"
                     onclick="document.getElementById('fileInput').click()">

                    
                    <div class="w-14 h-14 rounded-full bg-white shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 transition duration-300 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                        </svg>
                    </div>

                    
                    <div class="space-y-1">
                        <p class="text-base font-semibold text-slate-700">
                            Klik atau Drag File Excel ke Sini
                        </p>
                        <p class="text-xs text-slate-500">
                            Format yang didukung: .xlsx, .xls
                        </p>
                    </div>
                </div>

                
                <div id="uploadLoading" class="absolute inset-0 bg-white/80 backdrop-blur-sm rounded-2xl flex flex-col items-center justify-center hidden z-10 transition-opacity">
                    <div class="w-12 h-12 border-4 border-red-200 border-t-red-600 rounded-full animate-spin mb-3"></div>
                    <p class="font-semibold text-slate-700">Mengupload data...</p>
                    <p class="text-xs text-slate-500 mt-1">Mohon tunggu sebentar</p>
                </div>
            </form>
        </div>
    </div>

    
    <div class="bg-white rounded-3xl shadow-sm border overflow-hidden" style="border-color:#fde8e8; box-shadow: 0 4px 20px rgba(227,43,43,0.06);">
        
        <div class="p-5" style="border-bottom: 1px solid #fef2f2;">
            <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
                <h3 class="font-bold text-slate-800 text-lg flex-shrink-0">Riwayat Data Upload</h3>

                
                <div class="flex-1 w-full max-w-xl" x-data="uploadTagSearch()" x-init="init()">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2 flex-wrap flex-1 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 focus-within:ring-2 focus-within:ring-red-100 focus-within:border-red-400 transition"
                             @click="$refs.searchInput.focus()">
                            
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>

                            
                            <template x-for="(tag, index) in tags" :key="index">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-red-100 text-red-700 animate-fade-in">
                                    <span x-text="tag"></span>
                                    <button type="button" @click.stop="removeTag(index)" class="ml-1.5 text-red-400 hover:text-red-600 focus:outline-none">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    </button>
                                </span>
                            </template>

                            
                            <input x-ref="searchInput" type="text"
                                   x-model="input"
                                   @keydown.enter.prevent="addTagAndSearch()"
                                   @keydown.backspace="handleBackspace()"
                                   placeholder="Cari data upload..."
                                   class="flex-1 bg-transparent border-none text-sm focus:ring-0 focus:outline-none outline-none placeholder-slate-400 min-w-[150px]">
                        </div>

                        
                        <button type="button" @click="addTagAndSearch()"
                                class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 shadow-md hover:shadow-lg transition flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Cari
                        </button>
                    </div>
                </div>
            </div>
        </div>

        
        <div id="table-container" class="relative">
            
            <div id="tableLoading" class="hidden absolute inset-0 bg-white/70 backdrop-blur-sm z-20 flex items-center justify-center">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-8 h-8 border-4 rounded-full animate-spin" style="border-color:#fde8e8; border-top-color:#e32b2b;"></div>
                    <span class="text-sm font-medium text-slate-500">Memuat data...</span>
                </div>
            </div>
            @include('deployment.partials.table', ['rows' => $rows])
        </div>
    </div>

</div>

<div id="errorToast" class="fixed top-24 right-5 z-50 hidden animate-fade-in-down">
    <div class="flex items-start gap-3 bg-white border-l-4 border-red-500 shadow-xl rounded-xl p-4 w-80">
        <div class="flex-shrink-0 text-red-500">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <div class="flex-1">
            <p class="font-semibold text-slate-800 text-sm">Gagal Mengupload</p>
            <p class="text-xs text-slate-600 mt-1" id="errorToastMessage">Format file tidak sesuai.</p>
        </div>
        <button onclick="document.getElementById('errorToast').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">✕</button>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ===== TURBO: Paksa halaman ini selalu fresh (tidak di-cache Turbo) =====
    (function() {
        let meta = document.querySelector('meta[name="turbo-cache-control"]');
        if (!meta) {
            meta = document.createElement('meta');
            meta.name = 'turbo-cache-control';
            document.head.appendChild(meta);
        }
        meta.content = 'no-cache';

        document.addEventListener('turbo:load', function() {
            if (typeof Turbo !== 'undefined' && Turbo.clearCache) {
                Turbo.clearCache();
            }
        }, { once: true });
    })();

    function handleDragOver(e) {
        e.preventDefault();
        e.currentTarget.classList.add('border-red-500', 'bg-red-50');
    }

    function handleDragLeave(e) {
        e.preventDefault();
        e.currentTarget.classList.remove('border-red-500', 'bg-red-50');
    }

    function handleDrop(e) {
        e.preventDefault();
        const dropZone = e.currentTarget;
        dropZone.classList.remove('border-red-500', 'bg-red-50');
        
        const files = e.dataTransfer.files;
        if(files.length > 0) {
            validateAndSubmit(files[0]);
        }
    }

    function handleFileSelect(input) {
        if(input.files.length > 0) {
            validateAndSubmit(input.files[0]);
        }
    }

    function validateAndSubmit(file) {
        const allowedExtensions = ['xlsx', 'xls'];
        const fileName = file.name;
        const ext = fileName.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes(ext)) {
            showError('Hanya file Excel (.xlsx, .xls) yang diperbolehkan!');
            return;
        }

        // Show loading
        document.getElementById('uploadLoading').classList.remove('hidden');
        document.getElementById('uploadLoading').classList.add('flex');
        
        // Submit form
        const form = document.getElementById('importForm');
        // If file comes from drag & drop, we need to assign it to the input
        const fileInput = document.getElementById('fileInput');
        if (!fileInput.value) {
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;
        }
        
        form.submit();
    }

    function showError(msg) {
        const toast = document.getElementById('errorToast');
        document.getElementById('errorToastMessage').innerText = msg;
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 4000);
    }

    
    function uploadTagSearch() {
        return {
            input: '',
            tags: [],

            init() {
                const searchParams = new URLSearchParams(window.location.search);
                const search = searchParams.get('search');
                if (search) {
                    this.tags = search.split(',').filter(item => item.trim() !== '');
                }
            },

            addTagAndSearch() {
                if (this.input.trim() !== '' && !this.tags.includes(this.input.trim())) {
                    this.tags.push(this.input.trim());
                    this.input = '';
                }
                this.doSearch();
            },

            removeTag(index) {
                this.tags.splice(index, 1);
                this.doSearch();
            },

            handleBackspace() {
                if (this.input === '' && this.tags.length > 0) {
                    this.tags.pop();
                    this.doSearch();
                }
            },

            doSearch() {
                const tableContainer = document.getElementById('table-container');
                const loading = document.getElementById('tableLoading');
                const query = this.tags.join(',');

                if (loading) loading.classList.remove('hidden');

                fetch(`{{ route('deployment.upload') }}?search=${encodeURIComponent(query)}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.text())
                .then(html => {
                    if (loading) loading.classList.add('hidden');
                    // Replace only the inner content, keep the loading overlay
                    const temp = document.createElement('div');
                    temp.innerHTML = html;
                    const existingLoading = tableContainer.querySelector('#tableLoading');
                    tableContainer.innerHTML = html;
                    // Re-append loading overlay
                    if (existingLoading) tableContainer.prepend(existingLoading);
                })
                .catch(() => {
                    if (loading) loading.classList.add('hidden');
                });
            }
        }
    }
</script>
<style>
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fadeInDown 0.3s ease-out forwards;
    }
</style>
@endpush