@extends('layouts.app')

@section('content')
<div class="max-w-2xl">
    {{-- Tombol Back --}}
    <a href="{{ route('clients.index') }}" class="inline-flex items-center text-[11px] font-black text-slate-400 hover:text-[#0F172A] mb-8 transition-colors uppercase tracking-widest">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path d="M15 19l-7-7 7-7" />
        </svg>
        Back to Database
    </a>

    <div class="bg-white rounded-[40px] border border-slate-100 p-12 shadow-2xl shadow-slate-200/50 relative overflow-hidden">
        {{-- Dekorasi Latar Belakang --}}
        <div class="absolute top-0 right-0 w-32 h-32 bg-slate-50 rounded-bl-full -z-10"></div>

        <div class="mb-10">
            <h2 class="text-3xl font-black text-[#0F172A] tracking-tight">Edit Client Profile</h2>
            <p class="text-slate-400 mt-2 font-medium text-sm">Update detail informasi untuk unit {{ $client->unit_number }}</p>
        </div>

        <form action="{{ route('clients.update', $client->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-6">
                {{-- Unit Number (Read Only) --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Unit Number</label>
                    <input type="text" name="unit_number" value="{{ $client->unit_number }}" 
                        class="w-full px-8 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/10 font-black text-sm outline-none uppercase transition-all" 
                        placeholder="A/01/01" required>
                </div>

                {{-- Status Subscription --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Subscription Status</label>
                    <select name="status" class="w-full px-8 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/10 font-black text-sm outline-none cursor-pointer">
                        <option value="ACTIVE" {{ $client->status == 'ACTIVE' ? 'selected' : '' }}>ACTIVE</option>
                        <option value="NONAKTIF" {{ $client->status == 'NONAKTIF' ? 'selected' : '' }}>NON-ACTIVE </option>
                    </select>
                </div>
            </div>

            {{-- Full Name --}}
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Client Full Name</label>
                <input type="text" name="name" value="{{ $client->name }}" class="w-full px-8 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/10 font-black text-sm outline-none" required>
            </div>

            <div class="grid grid-cols-2 gap-6">
                {{-- Contact --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Contact (WhatsApp)</label>
                    <input type="text" name="phone" value="{{ $client->phone }}" class="w-full px-8 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/10 font-black text-sm outline-none" required>
                </div>
                {{-- Internet Package --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Internet Package</label>
                    <select name="package" class="w-full px-8 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/10 font-black text-sm outline-none" required>
                        <option value="30" {{ $client->package == '30' ? 'selected' : '' }}>30 Mbps</option>
                        <option value="50" {{ $client->package == '50' ? 'selected' : '' }}>50 Mbps</option>
                        <option value="100" {{ $client->package == '100' ? 'selected' : '' }}>100 Mbps</option>
                    </select>
                </div>
            </div>

            {{-- Sales Representative --}}
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Assigned Sales</label>
                <select name="sales_name" class="w-full px-8 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/10 font-black text-sm outline-none" required>
                    @foreach(['Mufarohah', 'Olivia', 'Amanda', 'Ika'] as $sales)
                        <option value="{{ $sales }}" {{ $client->sales_name == $sales ? 'selected' : '' }}>{{ $sales }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Button Submit --}}
            <button type="submit" class="w-full bg-[#0F172A] hover:bg-orange-500 text-white font-black py-6 rounded-3xl transition-all shadow-2xl shadow-blue-900/20 uppercase text-xs tracking-[0.3em] mt-6">
                Update Database
            </button>
        </form>
    </div>
</div>
@endsection