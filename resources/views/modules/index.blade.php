@extends('layouts.app')

@section('title', 'Daftar Modul - AgroWaste Academy')

@section('content')
<!-- Header -->
<div class="bg-gradient-to-b from-green-700 to-green-600 text-white px-8 py-12">
    <h1 class="text-3xl font-bold mb-2">Modul Pembelajaran</h1>
    <p class="text-sm text-green-100">Jelajahi berbagai modul tentang pengelolaan limbah pertanian</p>
</div>

<!-- Search & Filter -->
<div class="px-8 py-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6 flex items-center gap-4">
        <div class="flex-1 flex items-center gap-2 border border-gray-300 rounded-md px-3 py-2 bg-neutral-50">
            <span class="text-gray-400">🔍</span>
            <input type="text" id="searchInput" placeholder="Cari modul pembelajaran..." class="flex-1 bg-transparent border-0 outline-none text-sm placeholder:text-gray-400" />
        </div>
        <div class="flex gap-2">
            <button onclick="filterModules('all')" class="filter-btn px-4 py-2 rounded-md text-xs font-medium transition bg-green-600 text-white" data-filter="all">Semua</button>
            <button onclick="filterModules('pemula')" class="filter-btn px-4 py-2 rounded-md text-xs font-medium transition bg-neutral-100 text-gray-700 hover:bg-neutral-200" data-filter="pemula">Pemula</button>
            <button onclick="filterModules('menengah')" class="filter-btn px-4 py-2 rounded-md text-xs font-medium transition bg-neutral-100 text-gray-700 hover:bg-neutral-200" data-filter="menengah">Menengah</button>
            <button onclick="filterModules('lanjutan')" class="filter-btn px-4 py-2 rounded-md text-xs font-medium transition bg-neutral-100 text-gray-700 hover:bg-neutral-200" data-filter="lanjutan">Lanjutan</button>
        </div>
    </div>
    
    <h2 class="font-semibold mb-4"><span id="moduleCount">{{ $modules->count() }}</span> Modul Tersedia</h2>
    
    @if($modules->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="modulesGrid">
            @foreach($modules as $module)
                @php
                    $badges = [
                        1 => ['label' => 'Pemula', 'color' => 'bg-blue-100 text-blue-700'],
                        2 => ['label' => 'Menengah', 'color' => 'bg-orange-100 text-orange-700'],
                        3 => ['label' => 'Lanjutan', 'color' => 'bg-red-100 text-red-700'],
                    ];
                    $badge = $badges[$module->order] ?? $badges[1];
                @endphp
                <div class="module-card bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition" data-level="{{ strtolower($badge['label']) }}" data-title="{{ strtolower($module->title) }}" data-summary="{{ strtolower($module->description) }}">
                    <div class="relative h-40 bg-gradient-to-br from-green-400 to-blue-500 flex items-center justify-center">
                        <span class="text-5xl opacity-20">🌱</span>
                        <span class="absolute top-3 left-3 px-2 py-1 rounded text-[10px] font-medium {{ $badge['color'] }}">{{ $badge['label'] }}</span>
                    </div>
                    <div class="p-5">
                        <h3 class="font-semibold mb-2 text-sm">{{ $module->title }}</h3>
                        <p class="text-xs text-gray-600 leading-relaxed mb-4">{{ $module->description }}</p>
                        <div class="flex items-center gap-3 text-[11px] text-gray-500 mb-4">
                            <span class="flex items-center gap-1">🕐 {{ ($loop->index + 1) * 45 }} menit</span>
                            <span class="flex items-center gap-1">📘 Materi Lengkap</span>
                        </div>
                        
                        @php
                            $progress = $userProgress[$module->id] ?? null;
                        @endphp
                        
                        @if($progress)
                            <div class="mb-4">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-600">Progress</span>
                                    <span class="text-green-600 font-semibold">{{ $progress->getProgressPercentage() }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                    <div class="bg-green-600 h-1.5 rounded-full" style="width: {{ $progress->getProgressPercentage() }}%"></div>
                                </div>
                            </div>
                        @endif
                        
                        <a href="{{ route('modules.show', $module->slug) }}" class="block w-full text-center bg-green-600 hover:bg-green-500 text-white py-2 rounded-md text-xs font-medium">Mulai Belajar</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div id="noResults" class="hidden text-center py-12 text-gray-500 text-sm">Tidak ada modul yang sesuai dengan pencarian.</div>
    @else
        <div class="text-center py-12 text-gray-500 text-sm">Belum ada modul tersedia.</div>
    @endif
</div>

<!-- CTA Banner -->
<div class="px-8 pb-12">
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg p-8 text-white flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold mb-2">Butuh Panduan Belajar?</h3>
            <p class="text-xs text-orange-100">Hubungi mentor kami untuk bantuan pembelajaran yang lebih personal</p>
        </div>
        <button class="px-5 py-2 bg-white text-orange-600 rounded-md text-xs font-semibold hover:bg-orange-50">Hubungi Mentor</button>
    </div>
</div>

<script>
let currentFilter = 'all';

function filterModules(level) {
    currentFilter = level;
    
    // Update button states
    document.querySelectorAll('.filter-btn').forEach(btn => {
        if (btn.dataset.filter === level) {
            btn.className = 'filter-btn px-4 py-2 rounded-md text-xs font-medium transition bg-green-600 text-white';
        } else {
            btn.className = 'filter-btn px-4 py-2 rounded-md text-xs font-medium transition bg-neutral-100 text-gray-700 hover:bg-neutral-200';
        }
    });
    
    applyFilters();
}

function applyFilters() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.module-card');
    let visibleCount = 0;
    
    cards.forEach(card => {
        const cardLevel = card.dataset.level;
        const cardTitle = card.dataset.title;
        const cardSummary = card.dataset.summary;
        
        const matchesFilter = currentFilter === 'all' || cardLevel === currentFilter;
        const matchesSearch = searchTerm === '' || cardTitle.includes(searchTerm) || cardSummary.includes(searchTerm);
        
        if (matchesFilter && matchesSearch) {
            card.classList.remove('hidden');
            visibleCount++;
        } else {
            card.classList.add('hidden');
        }
    });
    
    document.getElementById('moduleCount').textContent = visibleCount;
    document.getElementById('noResults').classList.toggle('hidden', visibleCount > 0);
    document.getElementById('modulesGrid').classList.toggle('hidden', visibleCount === 0);
}

document.getElementById('searchInput').addEventListener('input', applyFilters);
</script>
@endsection
