@extends('layouts.app')

@section('content')
<style>
    .bento-card { background: white; border-radius: 32px; border: 1px solid rgba(226, 232, 240, 0.6); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02); }
    .table-header-text { color: #64748b; font-weight: 800; font-size: 11px; }
    .table-body-text { color: #1e293b; font-weight: 700; font-size: 14px; }
</style>

<div class="space-y-8">
    {{-- Header --}}
    <div class="flex justify-between items-start px-1 mb-2">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-[#0F172A]">Client Database</h1>
            <p class="text-slate-400 font-medium text-sm tracking-wide mt-1">
                Kelola data pelanggan dan performa sales Gading Nias.
            </p>
        </div>
        
        <button onclick="toggleModal('addClientModal')" class="bg-[#0F172A] hover:bg-orange-500 text-white px-8 py-4 rounded-2xl font-bold transition-all flex items-center gap-2 text-xs uppercase tracking-widest shadow-xl shadow-blue-900/10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M12 4v16m8-8H4" /></svg>
            Add New Client
        </button>
    </div>

    {{-- Tabel Client --}}
    <div class="bento-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-50">
                        <th class="px-8 py-6 table-header-text uppercase tracking-widest">Unit / Name</th>
                        <th class="px-8 py-6 table-header-text uppercase tracking-widest">Contact</th>
                        <th class="px-8 py-6 table-header-text uppercase tracking-widest">Package</th>
                        <th class="px-8 py-6 table-header-text uppercase tracking-widest">Sales</th>
                        <th class="px-8 py-6 table-header-text uppercase tracking-widest">Status</th>
                        <th class="px-8 py-6 table-header-text uppercase tracking-widest text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($clients as $client)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="table-body-text">{{ $client->unit_number }}</div>
                            <div class="text-[11px] text-slate-400 font-bold uppercase">{{ $client->name }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $client->phone) }}" target="_blank" class="inline-flex items-center gap-3 group">
                                <div class="w-9 h-9 rounded-xl bg-green-500 flex items-center justify-center text-white shadow-lg shadow-green-500/20 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 .004 5.412.001 12.049a11.82 11.82 0 001.611 6.118L0 24l6.132-1.61a11.802 11.802 0 005.912 1.586h.005c6.635 0 12.044-5.412 12.048-12.05a11.805 11.805 0 00-3.524-8.521z"/>
                                    </svg>
                                </div>
                                <span class="table-body-text text-slate-500 group-hover:text-green-600 transition-colors">{{ $client->phone }}</span>
                            </a>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase tracking-wider">
                                {{ $client->package }} Mbps
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="table-body-text text-slate-600 uppercase">{{ $client->sales_name ?? 'Unassigned' }}</span>
                        </td>
                        <td class="px-8 py-6">
                            {{-- Perbaikan Sinkronisasi Status --}}
                            @if($client->status == 'ACTIVE')
                                <span class="text-[10px] font-black text-green-500 bg-green-50 px-3 py-1 rounded-full uppercase italic">Active</span>
                            @else
                                <span class="text-[10px] font-black text-slate-400 bg-slate-50 px-3 py-1 rounded-full uppercase italic">Non-Active</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-center">
                            <a href="{{ route('clients.edit', $client->id) }}" class="inline-flex p-3 bg-slate-50 text-slate-400 hover:text-blue-600 rounded-xl transition-all border border-slate-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Hapus client {{ $client->name }} dari database?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex p-3 bg-slate-50 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all border border-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL ADD CLIENT --}}
<div id="addClientModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[40px] w-full max-w-lg p-10 shadow-2xl">
        <h2 class="text-2xl font-black text-[#0F172A] mb-8">Register New Client</h2>
        <form action="{{ route('clients.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Unit Number</label>
                    <input type="text" name="unit_number" placeholder="A/01/01" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/10 font-black text-sm outline-none uppercase" required>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Package</label>
                    <select name="package" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/10 font-black text-sm outline-none" required>
                        <option value="30">30 Mbps</option>
                        <option value="50">50 Mbps</option>
                        <option value="100">100 Mbps</option>
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                <input type="text" name="name" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/10 font-black text-sm outline-none" required>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">WhatsApp Number</label>
                <input type="text" name="phone" placeholder="628..." class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/10 font-black text-sm outline-none" required>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Sales Name</label>
                <select name="sales_name" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/10 font-black text-sm outline-none" required>
                    <option value="">-- Select Sales --</option>
                    @foreach(['Mufarohah', 'Olivia', 'Amanda', 'Ika'] as $sales)
                        <option value="{{ $sales }}">{{ $sales }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="button" onclick="toggleModal('addClientModal')" class="flex-1 px-8 py-4 rounded-2xl font-black text-xs text-slate-400 uppercase tracking-widest">Cancel</button>
                <button type="submit" class="flex-1 bg-[#0F172A] text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-blue-900/20">Save Client</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden');
    }
</script>
@endsection