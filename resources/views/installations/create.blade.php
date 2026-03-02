@extends('layouts.app')

@section('content')
<div class="max-w-3xl">
    {{-- Tombol Back --}}
    <a href="{{ route('install.index') }}" class="inline-flex items-center text-[11px] font-black text-slate-400 hover:text-[#0F172A] mb-8 transition-colors uppercase tracking-widest">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path d="M15 19l-7-7 7-7" />
        </svg>
        Back to Records
    </a>

    @php 
        $isEdit = isset($selectedSN) && $selectedSN->status == 'KELUAR';
        $actionUrl = $isEdit ? route('install.update', $selectedSN->id) : route('install.store');
    @endphp

    <div class="bent7o-card p-12 relative overflow-hidden bg-white">
        {{-- Header Form --}}
        <div class="mb-12">
            <h2 class="text-3xl font-black text-[#0F172A] tracking-tight">{{ $isEdit ? 'Edit Installation' : 'New Activation' }}</h2>
            <p class="text-slate-400 mt-2 font-medium">{{ $isEdit ? 'Perbarui data pengerjaan instalasi unit.' : 'Input data pengerjaan instalasi unit pelanggan.' }}</p>
        </div>

        <form action="{{ $actionUrl }}" method="POST" class="space-y-10">
            @csrf
            @if($isEdit) @method('PUT') @endif
            
            {{-- Technicians (Checkboxes) --}}
            <div class="space-y-4">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Team On Field</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach(['Bagas', 'Zahid', 'Zidan', 'Pak Rahmat'] as $name)
                    @php
                        $isChecked = $isEdit && is_array($selectedSN->technician) && in_array($name, $selectedSN->technician);
                    @endphp
                    <label class="group relative flex items-center p-5 bg-slate-50 rounded-2xl cursor-pointer hover:bg-slate-100 transition-all border-2 border-transparent has-[:checked]:border-orange-500/20 has-[:checked]:bg-orange-50/30">
                        <input type="checkbox" name="teknisi[]" value="{{ $name }}" {{ $isChecked ? 'checked' : '' }} class="w-5 h-5 rounded-lg text-orange-500 border-slate-300 focus:ring-orange-500">
                        <span class="ml-4 font-black text-sm text-slate-700 group-hover:text-[#0F172A]">{{ $name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Date & Unit --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Work Date</label>
                    <input type="date" name="tanggal_pengerjaan" 
                           value="{{ $isEdit ? ($selectedSN->work_date ? $selectedSN->work_date->format('Y-m-d') : date('Y-m-d')) : date('Y-m-d') }}" 
                           class="w-full px-8 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/10 font-black text-sm outline-none transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Unit Number</label>
                    <input type="text" name="nomor_unit" value="{{ $isEdit ? $selectedSN->client_unit : '' }}" placeholder="Ex: A/22/DB" class="w-full px-8 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/10 font-black text-sm outline-none transition-all uppercase placeholder:text-slate-300">
                </div>
            </div>

            {{-- Cable & Device --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Cable Length</label>
                    <div class="relative">
                        <input type="number" name="panjang_kabel" value="{{ $isEdit ? $selectedSN->cable_length : '' }}" placeholder="0" class="w-full px-8 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/10 font-black text-sm outline-none transition-all">
                        <span class="absolute right-8 top-1/2 -translate-y-1/2 font-black text-slate-300 text-[10px] uppercase">Meter</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Device Serial Number</label>
                    @if(isset($selectedSN))
                        <div class="w-full px-8 py-5 bg-slate-100 rounded-2xl font-black text-sm text-slate-400 border border-slate-200/50">
                            {{ $selectedSN->serial_number }} ({{ $selectedSN->product->name }})
                        </div>
                        <input type="hidden" name="serial_number_id" value="{{ $selectedSN->id }}">
                    @else
                        <select name="serial_number_id" class="w-full px-8 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/10 font-black text-sm outline-none cursor-pointer">
                            <option value="">-- Select Available SN --</option>
                            @foreach($availableSNs as $sn)
                                <option value="{{ $sn->id }}">{{ $sn->serial_number }} - {{ $sn->product->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="w-full bg-[#0F172A] hover:bg-orange-500 text-white font-black py-6 rounded-3xl transition-all shadow-2xl shadow-blue-900/20 uppercase text-xs tracking-[0.3em] mt-6">
                {{ $isEdit ? 'Update Installation Data' : 'Finalize Activation' }}
            </button>
        </form>
    </div>
</div>
@endsection