@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center print:hidden">
        <a href="{{ route('reports.index') }}" class="text-slate-400 hover:text-blue-900 font-bold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Reports
        </a>
        <button onclick="window.print()" class="bg-blue-900 text-white px-8 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-blue-900/20">
            Print / Save PDF
        </button>
    </div>

    <div class="bento-card bg-white p-12 shadow-xl border-slate-100 max-w-5xl mx-auto print:shadow-none print:border-none print:p-0">
        <div class="flex justify-between items-start border-b-4 border-slate-50 pb-10 mb-10">
            <div>
                <h2 class="text-3xl font-black text-[#0F172A]">Installation Report</h2>
                <p class="text-slate-400 font-bold uppercase tracking-widest text-sm mt-1">Periode: {{ $periode }}</p>
            </div>
            <div class="text-right">
                <h3 class="text-xl font-black text-orange-500 italic">Inventra.</h3>
                <p class="text-[10px] text-slate-400 font-medium">MMA Management</p>
            </div>
        </div>

        <table class="w-full text-left">
            <thead>
                <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                    <th class="py-4">No.</th>
                    <th class="py-4">Client / Unit</th>
                    <th class="py-4">Technician</th>
                    <th class="py-4">Device</th>
                    <th class="py-4 text-right">Cable (M)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($details as $index => $item)
                <tr>
                    <td class="py-6 text-slate-300 font-bold text-sm">{{ $index + 1 }}</td>
                    <td class="py-6">
                        {{-- FIX: Cek jika array, ubah jadi string --}}
                        <div class="font-bold text-[#0F172A]">
                            @if(is_array($item->client_unit))
                                {{ implode(', ', $item->client_unit) }}
                            @else
                                {{ $item->client_unit ?? '-' }}
                            @endif
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium uppercase">
                            {{ $item->installed_at ? \Carbon\Carbon::parse($item->installed_at)->format('d M Y') : '-' }}
                        </div>
                    </td>
                    <td class="py-6 text-sm font-bold text-slate-600">
                        @if(is_array($item->technician))
                            {{ implode(', ', $item->technician) }}
                        @else
                            {{ $item->technician ?? '-' }}
                        @endif
                    </td>
                    <td class="py-6">
                        <div class="font-bold text-xs text-blue-900">{{ $item->product->name ?? 'Router' }}</div>
                        <div class="font-mono text-[10px] text-slate-400">{{ $item->serial_number ?? '-' }}</div>
                    </td>
                    <td class="py-6 text-right font-black text-[#0F172A]">
                        {{ is_array($item->cable_length) ? 0 : ($item->cable_length ?? 0) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border-t-2 border-slate-100">
                    <td colspan="4" class="py-8 text-right font-black text-slate-400 uppercase tracking-widest text-xs">Total Cable Usage</td>
                    <td class="py-8 text-right font-black text-2xl text-orange-500">{{ $details->sum('cable_length') }} M</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection