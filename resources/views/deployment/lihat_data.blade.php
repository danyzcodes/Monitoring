@extends('layouts.app')

@section('title', 'Lihat Data')

@section('content')
    <div class="flex flex-col gap-6">

        
        <div class="flex items-center gap-3 text-sm text-slate-500">
        <a href="{{ route('deployment.progress-overview') }}" class="font-bold text-slate-800 text-xs uppercase tracking-wider">Dashboard</a>
        <span class="text-slate-300 font-bold">❯</span>
        <span class="font-bold text-slate-800 text-xs uppercase tracking-wider">lihat data</span>
    </div>
        

        
        <div class="bg-white rounded-2xl shadow-sm border p-5"
            style="border-color:#fde8e8; box-shadow: 0 4px 20px rgba(227,43,43,0.06);" x-data="tagSearch()">

            
            <div class="flex flex-col md:flex-row gap-4 justify-between items-center mb-4">
                
                <div class="flex-1 w-full">
                    <div class="relative group">
                        <div class="flex items-center gap-2 flex-wrap w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 focus-within:ring-2 focus-within:ring-red-100 focus-within:border-red-400 transition"
                            @click="$refs.searchInput.focus()">

                            
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400 flex-shrink-0"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>

                            
                            <template x-for="(tag, index) in tags" :key="index">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-red-100 text-red-700 animate-fade-in">
                                    <span x-text="tag"></span>
                                    <button type="button" @click.stop="removeTag(index)"
                                        class="ml-1.5 text-red-400 hover:text-red-600 focus:outline-none">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </template>

                            
                            <input x-ref="searchInput" type="text" x-model="input" @keydown.enter.prevent="addTag()"
                                @keydown.backspace="handleBackspace()" placeholder="Cari NDE, Starclick, Nama..."
                                class="flex-1 bg-transparent border-none text-sm 
                                        focus:ring-0 focus:outline-none outline-none
                                        placeholder-slate-400 min-w-[200px]">
                        </div>
                    </div>

                    
                    
                </div>

                
                <button type="button" @click="submitSearch()"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 shadow-md hover:shadow-lg transition flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cari
                </button>

                <button @click="showAdvanced = !showAdvanced"
                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter Lanjutan
                    <svg :class="showAdvanced ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-200"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="flex justify-end">
                    <a href="{{ route('deployment.lihat-data.export', request()->query()) }}"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export Data
                    </a>
                </div>

            </div>

            <div x-show="showAdvanced" x-collapse x-cloak class="pt-4 border-t border-slate-100 space-y-4">
                
                <form id="filterForm" method="GET" action="{{ route('deployment.lihat-data') }}">
                    <input type="hidden" name="search" id="hiddenSearchInput" value="{{ request('search') }}">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="w-full rounded-xl border-slate-200 bg-slate-50 text-sm focus:ring-red-500 focus:border-red-500 p-2.5">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                class="w-full rounded-xl border-slate-200 bg-slate-50 text-sm focus:ring-red-500 focus:border-red-500 p-2.5">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                        <div><label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Status Order</label>
                        <select id="f_status_order" name="status_order[]" multiple>
                            @foreach ($filters['status_orders'] as $item)<option value="{{ $item }}" {{ in_array($item,(array)request('status_order',[])) ? 'selected':'' }}>{{ $item }}</option>@endforeach
                        </select></div>
                        <div><label class="block text-xs font-semibold text-slate-500 uppercase mb-1">STO</label>
                        <select id="f_sto" name="sto[]" multiple>
                            @foreach ($filters['stos'] as $item)<option value="{{ $item }}" {{ in_array($item,(array)request('sto',[])) ? 'selected':'' }}>{{ $item }}</option>@endforeach
                        </select></div>
                        <div><label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Jenis Program</label>
                        <select id="f_jenis_program" name="jenis_program[]" multiple>
                            @foreach ($filters['jenis_programs'] as $item)<option value="{{ $item }}" {{ in_array($item,(array)request('jenis_program',[])) ? 'selected':'' }}>{{ $item }}</option>@endforeach
                        </select></div>
                        <div><label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Datel</label>
                        <select id="f_datel" name="datel[]" multiple>
                            @foreach ($filters['datels'] as $item)<option value="{{ $item }}" {{ in_array($item,(array)request('datel',[])) ? 'selected':'' }}>{{ $item }}</option>@endforeach
                        </select></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                        <div><label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Tipe Desain</label>
                        <select id="f_tipe_desain" name="tipe_desain[]" multiple>
                            @foreach ($filters['tipe_desains'] as $item)<option value="{{ $item }}" {{ in_array($item,(array)request('tipe_desain',[])) ? 'selected':'' }}>{{ $item }}</option>@endforeach
                        </select></div>
                        <div><label class="block text-xs font-semibold text-slate-500 uppercase mb-1">CFU</label>
                        <select id="f_cfu" name="cfu[]" multiple>
                            @foreach ($filters['cfus'] as $item)<option value="{{ $item }}" {{ in_array($item,(array)request('cfu',[])) ? 'selected':'' }}>{{ $item }}</option>@endforeach
                        </select></div>
                        <div><label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Progress</label>
                        <select id="f_progres" name="progres[]" multiple>
                            @foreach ($filters['progresses'] as $item)<option value="{{ $item }}" {{ in_array($item,(array)request('progres',[])) ? 'selected':'' }}>{{ $item }}</option>@endforeach
                        </select></div>
                        <div><label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Status Proyek</label>
                        <select id="f_status_proyek" name="status_proyek[]" multiple>
                            @foreach ($filters['status_proyeks'] as $item)<option value="{{ $item }}" {{ in_array($item,(array)request('status_proyek',[])) ? 'selected':'' }}>{{ $item }}</option>@endforeach
                        </select></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <div><label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Nomor Batch</label>
                        <select id="f_nomor_batch" name="nomor_batch[]" multiple>
                            @foreach ($filters['nomor_batches'] as $item)<option value="{{ $item }}" {{ in_array($item,(array)request('nomor_batch',[])) ? 'selected':'' }}>{{ $item }}</option>@endforeach
                        </select></div>
                        <div class="flex items-end col-span-1">
                            <button type="submit" class="w-full bg-red-600 text-white rounded-xl px-4 py-2.5 text-sm font-semibold hover:bg-red-700 transition shadow-sm">Terapkan Filter</button>
                        </div>
                    </div>

                </form>

                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.min.css">
                <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
                <style>
                    .filter-ts .ts-control { border-radius: 0.75rem !important; border-color: #e2e8f0 !important; background: #f8fafc !important; font-size: 0.8rem !important; min-height: 40px; }
                    .filter-ts .ts-control.focus { border-color: #ef4444 !important; box-shadow: 0 0 0 2px #fee2e2 !important; }
                    .filter-ts .ts-dropdown { border-radius: 0.75rem !important; border-color: #e2e8f0 !important; box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important; }
                    .filter-ts .ts-dropdown .option { font-size: 0.8rem; padding: 6px 12px; }
                    .filter-ts .ts-dropdown .option:hover, .filter-ts .ts-dropdown .option.active { background: #fef2f2 !important; color: #dc2626 !important; }
                    .filter-ts .ts-control .item { background: #fee2e2 !important; color: #dc2626 !important; border-radius: 6px !important; font-weight: 600; font-size: 0.75rem !important; padding: 2px 6px !important; }
                    .filter-ts .ts-control .item .remove { color: #dc2626 !important; border-left-color: #fca5a5 !important; }
                </style>
                <script>
                    function initFilterTS() {
                        ['f_status_order','f_sto','f_jenis_program','f_datel','f_tipe_desain','f_cfu','f_progres','f_status_proyek','f_nomor_batch'].forEach(function(id) {
                            const el = document.getElementById(id);
                            if (el && !el.tomselect) {
                                new TomSelect(el, {
                                    plugins: ['remove_button'],
                                    maxOptions: 300,
                                    create: false,
                                    wrapperClass: 'ts-wrapper filter-ts',
                                    placeholder: '— Semua —',
                                    dropdownParent: 'body',
                                });
                            }
                        });
                    }
                    document.addEventListener('DOMContentLoaded', initFilterTS);
                    document.addEventListener('turbo:load', initFilterTS);
                </script>
            </div>
        </div>

        
        <div class="bg-white rounded-2xl shadow-sm border overflow-hidden"
            style="border-color:#fde8e8; box-shadow: 0 4px 20px rgba(227,43,43,0.06);">
            <div id="table-container" class="relative">
                
                <div id="tableLoading" class="hidden absolute inset-0 bg-white/90 z-20 flex items-center justify-center">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-8 h-8 border-4 rounded-full animate-spin"
                            style="border-color:#fde8e8; border-top-color:#e32b2b;"></div>
                        <span class="text-sm font-medium text-slate-500">Memuat data...</span>
                    </div>
                </div>
                @include('deployment.partials.lihat-data-table', ['rows' => $rows])
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function tagSearch() {
                return {
                    input: '',
                    tags: [],
                    showAdvanced: false,

                    init() {
                        const searchParams = new URLSearchParams(window.location.search);
                        const search = searchParams.get('search');
                        if (search) {
                            this.tags = search.split(',').filter(item => item.trim() !== '');
                        }
                    },

                    addTag() {
                        if (this.input.trim() !== '' && !this.tags.includes(this.input.trim())) {
                            this.tags.push(this.input.trim());
                            this.input = '';
                        }
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

                    submitSearch() {
                        if (this.input.trim() !== '') {
                            this.addTag();
                        }
                        this.doSearch();
                    },

                    doSearch() {
                        const tableContainer = document.getElementById('table-container');
                        const loading = document.getElementById('tableLoading');
                        const query = this.tags.join(',');

                        const hiddenInput = document.getElementById('hiddenSearchInput');
                        if (hiddenInput) hiddenInput.value = query;

                        if (loading) loading.classList.remove('hidden');

                        const url = `{{ route('deployment.lihat-data') }}?search=${encodeURIComponent(query)}`;

                        fetch(url, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(res => res.text())
                            .then(html => {
                                if (loading) loading.classList.add('hidden');
                                const existingLoading = tableContainer.querySelector('#tableLoading');
                                tableContainer.innerHTML = html;
                                if (existingLoading) tableContainer.prepend(existingLoading);
                                bindPaginationLinks();

                                const newUrl = query ?
                                    `{{ route('deployment.lihat-data') }}?search=${encodeURIComponent(query)}` :
                                    `{{ route('deployment.lihat-data') }}`;
                                window.history.replaceState({}, '', newUrl);
                            })
                            .catch(() => {
                                if (loading) loading.classList.add('hidden');
                            });
                    }
                }
            }

            
            function ajaxFetch(url) {
                const tableContainer = document.getElementById('table-container');
                const loading = document.getElementById('tableLoading');

                if (loading) loading.classList.remove('hidden');

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.text())
                    .then(html => {
                        if (loading) loading.classList.add('hidden');
                        tableContainer.innerHTML = html;
                        bindPaginationLinks();
                    })
                    .catch(() => {
                        if (loading) loading.classList.add('hidden');
                    });
            }

            function bindPaginationLinks() {
                const tableContainer = document.getElementById('table-container');
                if (!tableContainer) return;
                tableContainer.querySelectorAll('a[href]').forEach(link => {
                    // Only intercept pagination links (contain ?page= or &page=)
                    if (link.href.includes('page=')) {
                        link.addEventListener('click', function(e) {
                            e.preventDefault();
                            ajaxFetch(this.href);
                        });
                    }
                });
            }

            document.addEventListener('turbo:load', function() {
                bindPaginationLinks();
            });
        </script>
    @endpush
@endsection
