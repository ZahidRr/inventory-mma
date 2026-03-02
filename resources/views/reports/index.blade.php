@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="space-y-8 pb-10">
    {{-- HEADER --}}
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-[#0F172A]">Executive Reports</h1>
            <p class="text-slate-400 font-medium text-sm mt-1">Analisis performa aktivasi bulanan MMA Gading Nias.</p>
        </div>
        <div class="text-right hidden md:block border-l-2 border-slate-100 pl-6">
            <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Status Sistem</span>
            <p class="text-sm font-bold text-green-500 flex items-center gap-2 justify-end">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> Synchronized
            </p>
        </div>
    </div>

    {{-- STATS GRID (2 Kolom Besar) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Total Unit --}}
        <div class="bento-card p-8 bg-blue-900 border-none text-white relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-blue-300 text-[10px] font-black uppercase tracking-[0.2em] mb-1">Total Aktivasi Selesai</p>
                <h3 class="text-5xl font-black tracking-tighter">{{ $monthlyReports->sum('total_units') }} <span class="text-xl font-bold text-blue-400">Unit</span></h3>
            </div>
            <div class="absolute -right-6 -bottom-6 opacity-20 transition-transform group-hover:scale-110 duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-40 w-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
        </div>

        {{-- Total Kabel --}}
        <div class="bento-card p-8 bg-white border-slate-100 relative overflow-hidden group">
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mb-1">Total Material Keluar</p>
            <h3 class="text-5xl font-black text-[#0F172A] tracking-tighter">{{ number_format($monthlyReports->sum('total_cable')) }} <span class="text-xl font-bold text-slate-300">Meter</span></h3>
            <div class="absolute right-8 top-8">
                <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- CHART AREA --}}
    <div class="bento-card bg-white p-8 border-slate-100">
        <h4 class="text-[10px] font-black text-[#0F172A] uppercase tracking-[0.2em] mb-8">Trend Pemasangan</h4>
        <div class="h-72">
            <canvas id="activationChart"></canvas>
        </div>
    </div>

    {{-- TABLE REKAP --}}
    <div class="bento-card overflow-hidden bg-white border-slate-100">
        <table class="w-full text-left">
            <thead class="bg-slate-50/50">
                <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                    <th class="px-8 py-5">Periode Laporan</th>
                    <th class="px-8 py-5 text-center">Volume Unit</th>
                    <th class="px-8 py-5 text-center">Volume Kabel</th>
                    <th class="px-8 py-5 text-right">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($monthlyReports as $report)
                <tr class="hover:bg-slate-50/30 transition-all group">
                    <td class="px-8 py-6">
                        <div class="font-black text-[#0F172A] text-lg">
                            {{ DateTime::createFromFormat('!m', $report->month)->format('F') }}
                        </div>
                        <div class="text-[10px] font-bold text-slate-400 tracking-widest">{{ $report->year }}</div>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <span class="bg-blue-900 text-white px-4 py-1.5 rounded-full font-black text-xs shadow-lg shadow-blue-900/20">
                            {{ $report->total_units }}
                        </span>
                    </td>
                    <td class="px-8 py-6 text-center font-bold text-slate-600">
                        {{ number_format($report->total_cable) }} <span class="text-[10px] text-slate-400">M</span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <a href="{{ route('reports.preview', ['year' => $report->year, 'month' => $report->month]) }}" 
                           class="text-[10px] font-black text-blue-900 uppercase tracking-widest hover:text-orange-500 transition-all inline-flex items-center gap-2">
                            View Preview
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    const ctx = document.getElementById('activationChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyReports->reverse()->map(fn($r) => DateTime::createFromFormat('!m', $r->month)->format('M'))->values()) !!},
            datasets: [{
                data: {!! json_encode($monthlyReports->reverse()->pluck('total_units')) !!},
                borderColor: '#1e1b4b',
                backgroundColor: 'rgba(30, 27, 75, 0.03)',
                borderWidth: 5,
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointBackgroundColor: '#f97316',
                pointBorderColor: '#fff',
                pointBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, border: {display: false}, grid: { color: '#f1f5f9' } },
                x: { border: {display: false}, grid: { display: false } }
            }
        }
    });
</script>
@endsection