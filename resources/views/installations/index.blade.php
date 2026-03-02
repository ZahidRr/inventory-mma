@extends('layouts.app')

@section('content')
<style>
    .bento-card { 
        background: white; 
        border-radius: 32px; 
        border: 1px solid rgba(226, 232, 240, 0.6); 
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    }
    .table-header-text { color: #64748b; font-weight: 800; font-size: 11px; }
    .table-body-text { color: #1e293b; font-weight: 700; font-size: 14px; }
</style>

<div class="space-y-8">
    {{-- HEADER HALAMAN --}}
    <div class="flex justify-between items-start px-1 mb-2">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-[#0F172A]">Installation Records</h1>
            <p class="text-slate-400 font-medium text-sm tracking-wide mt-1">
                Tracking all activations in Gading Nias Residence.
            </p>
        </div>
        
        <a href="{{ route('install.create') }}" class="bg-[#0F172A] hover:bg-orange-500 text-white px-8 py-4 rounded-2xl font-bold shadow-xl shadow-blue-900/10 transition-all flex items-center gap-2 text-xs uppercase tracking-widest">
            <span class="text-lg">+</span> New Activation
        </a>
    </div>

    {{-- STATS ROW (Bento Style) --}}
    <div class="grid grid-cols-12 gap-6">
        {{-- Card 1: Monthly --}}
        <div class="col-span-12 md:col-span-4 bento-card p-8 flex items-center gap-6">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-2xl">📈</div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Activations This Month</p>
                <h3 class="text-3xl font-black text-blue-900 mt-1">{{ $totalThisMonth }} <span class="text-xs font-bold text-slate-300">UNITS</span></h3>
            </div>
        </div>

        {{-- Card 2: TOTAL INSTALLATIONS --}}
        <div class="col-span-12 md:col-span-4 bento-card p-8 flex items-center gap-6">
            <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-2xl">🏠</div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Installations</p>
                <h3 class="text-3xl font-black text-orange-600 mt-1">{{ $totalInstallations }} <span class="text-xs font-bold text-slate-300">UNITS</span></h3>
            </div>
        </div>

        {{-- Card 3: Berhenti Berlangganan --}}
        <div class="col-span-12 md:col-span-4 bento-card p-8 flex items-center gap-6">
            <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-2xl">🚫</div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Churned Users</p>
                <h3 class="text-3xl font-black text-red-600 mt-1">{{ $totalChurn ?? 0 }} <span class="text-xs font-bold text-slate-300">UNITS</span></h3>
            </div>
        </div>
    </div>


    {{-- MAIN TABLE BENTO --}}
    <div class="bento-card overflow-hidden">
        {{-- Internal Header Bento --}}
        <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <h3 class="text-xl font-black text-[#0F172A]">Historical Data</h3>
            
            <form action="{{ route('install.index') }}" method="GET">
                <select name="month" onchange="this.form.submit()" class="bg-white border border-slate-200 rounded-xl px-6 py-3 text-[11px] font-black outline-none focus:ring-2 focus:ring-orange-500 cursor-pointer text-[#0F172A] shadow-sm uppercase tracking-wider">
                    <option value="">All Months</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="table-header-text uppercase tracking-[0.2em] border-b border-slate-50">
                    <th class="p-8">Unit</th>
                    <th class="p-8">Device & Serial Number</th>
                    <th class="p-8">Technicians</th>
                    <th class="p-8 text-center">Cable</th>
                    <th class="p-8 text-center">Date</th>
                    <th class="p-8 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($installations as $inst)
                <tr class="group hover:bg-slate-50/30 transition-all">
                    <td class="p-8">
                        <span class="text-blue-700 bg-blue-50 px-4 py-2 rounded-xl font-black text-xs border border-blue-100/50 uppercase">{{ $inst->client_unit }}</span>
                    </td>
                    
                    <td class="p-8">
                        <p class="text-base font-black text-[#0F172A] font-mono tracking-tight">{{ $inst->serial_number }}</p>
                        <p class="text-[11px] font-bold text-slate-400 mt-0.5 uppercase tracking-wide">{{ $inst->product->name }}</p>
                    </td>

                    <td class="p-8">
                        <div class="flex flex-wrap gap-1.5">
                            @if(is_array($inst->technician))
                                @foreach($inst->technician as $tech)
                                    <span class="text-[10px] font-black bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg border border-slate-200/50 uppercase">{{ $tech }}</span>
                                @endforeach
                            @endif
                        </div>
                    </td>

                    <td class="p-8 text-center">
                        <p class="text-lg font-black text-[#0F172A]">{{ $inst->cable_length }}<span class="text-[10px] text-slate-300 ml-1 uppercase">M</span></p>
                    </td>

                    <td class="p-8 text-center">
                        <p class="text-sm font-bold text-slate-500">{{ $inst->installed_at ? $inst->installed_at->format('d M Y') : '-' }}</p>
                    </td>

                    <td class="p-8">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('install.edit', $inst->id) }}" class="p-3 bg-slate-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-xl transition-all border border-slate-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.5 2.5 0 113.536 3.536L12 17.207l-4 1 1-4 9.414-9.414z" />
                                </svg>
                            </a>
                            <form action="{{ route('install.destroy', $inst->id) }}" method="POST" onsubmit="return confirm('Hapus data unit {{ $inst->client_unit }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-3 bg-slate-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all border border-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-24 text-center">
                        <p class="text-slate-300 font-bold italic">No records found for this period.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection