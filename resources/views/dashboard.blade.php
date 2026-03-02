@extends('layouts.app')

@section('content')
<style>
    .bento-card { 
        background: white; 
        border-radius: 32px; 
        border: 1px solid rgba(226, 232, 240, 0.6); 
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    }
</style>

{{-- TOP BAR: Hello & Search bar dalam satu baris --}}
<div class="flex justify-between items-start mb-10 px-1">
    <div>
        <h1 class="text-3xl font-black tracking-tight text-[#0F172A]">Hello, {{ auth()->user()->name }} 👋</h1>
        <p class="text-slate-400 font-medium text-sm tracking-wide mt-1">
            Selamat datang kembali! Mari pantau aktivitas instalasi hari ini.
        </p>
    </div>

    <div class="flex items-center gap-4 mt-1">
        <div class="bg-white px-6 py-3 rounded-2xl border border-slate-50 shadow-sm flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" placeholder="Search data..." class="bg-transparent border-none outline-none text-sm font-medium w-64 placeholder:text-slate-300">
        </div>
        <div class="w-12 h-12 bg-white rounded-2xl border border-slate-50 shadow-sm flex items-center justify-center font-bold text-slate-400 shrink-0">
            {{ substr(auth()->user()->name, 0, 1) }}
        </div>
    </div>
</div>

<div class="grid grid-cols-12 gap-6">
    {{-- STATS CARDS ROW --}}
    <div class="col-span-12 lg:col-span-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bento-card p-8 flex flex-col justify-between min-h-[160px]">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Clients</span>
            <div class="mt-4 flex items-baseline gap-2">
                {{-- Data riil dari total installations --}}
                <h2 class="text-4xl font-black text-[#0F172A]">{{ $totalClients }}</h2>
                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-lg uppercase">Active</span>
            </div>
        </div>

        <div class="bento-card p-8 flex flex-col justify-between">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Monthly Install</span>
            <div class="mt-4 flex items-baseline gap-2">
                <h2 class="text-4xl font-black text-orange-500">{{ $totalThisMonth }}</h2>
                <span class="text-[10px] font-bold text-orange-500 bg-orange-50 px-2 py-0.5 rounded-lg uppercase">{{ now()->format('M') }}</span>
            </div>
        </div>

        <div class="bento-card p-8 flex flex-col justify-between">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Cable Usage</span>
            <div class="mt-4 flex items-baseline gap-2">
                <h2 class="text-4xl font-black text-blue-900">{{ $usedCableMonth ?? 0 }}</h2>
                <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-lg uppercase">Meter</span>
            </div>
        </div>

        {{-- INSTALLATION ANALYSIS (Dinamis dari Database) --}}
        <div class="col-span-1 md:col-span-3 bento-card p-10 min-h-[400px]">
            <div class="flex flex-wrap justify-between items-center mb-8 gap-4">
                <div>
                    <h3 class="text-xl font-black text-[#0F172A]">Installation Analysis</h3>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Statistik pemasangan unit bulanan {{ now()->year }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <select class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-2 text-[10px] font-bold outline-none cursor-pointer text-slate-600">
                        <option value="{{ now()->year }}" selected>{{ now()->year }}</option>
                    </select>
                </div>
            </div>
            
            <div class="flex items-end justify-between h-64 gap-2 md:gap-4 px-2">
                {{-- Data riil per bulan dari Controller --}}
                @foreach($monthlyData as $count)
                <div class="flex-1 group relative">
                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-[#0F172A] text-white text-[10px] font-bold py-1 px-3 rounded-lg opacity-0 group-hover:opacity-100 transition-all z-10 whitespace-nowrap">
                        {{ $count }} Units
                    </div>
                    <div class="bg-slate-100/50 w-full rounded-2xl transition-all group-hover:bg-slate-200/50 h-64 flex flex-col justify-end overflow-hidden">
                        {{-- Mengasumsikan target maksimal 25 unit per bulan --}}
                        <div class="bg-blue-900 w-full rounded-2xl transition-all group-hover:bg-orange-500" 
                             style="height: {{ $count > 0 ? ($count / 25) * 100 : 0 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="flex justify-between mt-6 px-2 text-[10px] font-black text-slate-300 uppercase tracking-widest">
                <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span><span>Aug</span><span>Sep</span><span>Oct</span><span>Nov</span><span>Dec</span>
            </div>
        </div>
    </div>

    {{-- RIGHT SIDEBAR STATS --}}
    <div class="col-span-12 lg:col-span-4 flex flex-col gap-6">
        <div class="bento-card p-10 flex-1">
            <h3 class="text-lg font-black mb-6">Sales Performance</h3>
            <div class="space-y-6">
                @foreach($salesPerformance as $sales)
                <div class="space-y-2">
                    <div class="flex justify-between text-[10px] font-bold uppercase tracking-wider">
                        <span>{{ $sales['name'] }}</span>
                        <span class="text-blue-900 font-bold">{{ $sales['count'] }} Clients</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        {{-- Warna bar berubah jadi orange sesuai brand --}}
                        <div class="bg-orange-500 h-full rounded-full transition-all duration-500" 
                            style="width: {{ $sales['percentage'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bento-card p-8 bg-[#0F172A] text-white shadow-xl shadow-blue-900/20">
            <h4 class="text-sm font-bold mb-3 italic">"Connect with Excellence"</h4>
            <p class="text-xs text-slate-400 leading-relaxed mb-6">Sistem terintegrasi untuk efisiensi pengerjaan teknisi di lapangan.</p>
            <a href="{{ route('install.create') }}" class="block w-full text-center bg-orange-500 text-white py-4 rounded-2xl font-bold text-[10px] uppercase tracking-[0.2em] hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20">
                + New Activation
            </a>
        </div>
    </div>

    {{-- CORE INVENTORY --}}
    <div class="col-span-12 bento-card p-10">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h3 class="text-xl font-black">Core Inventory</h3>
                <p class="text-xs text-slate-400 mt-1 font-medium">Stok material yang tersedia di gudang</p>
            </div>
            <a href="{{ route('inventory.index') }}" class="text-[10px] font-black text-blue-900 uppercase tracking-widest border-b-2 border-orange-500 pb-1 hover:text-orange-500 transition-colors">Manage Inventory</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="p-8 rounded-[32px] bg-slate-50 border border-slate-100 flex items-center justify-between group hover:border-blue-900/10 transition-all">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-sm text-2xl group-hover:scale-110 transition-transform">📡</div>
                    <div>
                        <h4 class="font-bold text-[#0F172A]">Router Assets</h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Ruijie & TP-Link</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-3xl font-black text-blue-900">{{ $products->where('category', 'Router')->sum('available_stock') }}</span>
                    <p class="text-[10px] font-bold text-slate-300">UNITS</p>
                </div>
            </div>

            <div class="p-8 rounded-[32px] bg-slate-50 border border-slate-100 flex items-center justify-between group hover:border-orange-500/10 transition-all">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-sm text-2xl group-hover:scale-110 transition-transform">🛠️</div>
                    <div>
                        <h4 class="font-bold text-[#0F172A]">Installation Tools</h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Cables & Materials</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-3xl font-black text-orange-500">{{ $products->where('category', 'Tools')->sum('available_stock') }}</span>
                    <p class="text-[10px] font-bold text-slate-300">ITEMS</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection