@extends('layouts.app')

@section('content')
{{-- Custom Style Lokal untuk Bento Inventory --}}
<style>
    .bento-card { 
        background: white; 
        border-radius: 32px; 
        border: 1px solid rgba(226, 232, 240, 0.6); 
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    }
    .table-header-text {
        color: #64748b; 
        font-weight: 800;
        font-size: 11px;
    }
    .table-body-text {
        color: #1e293b; 
        font-weight: 700;
        font-size: 14px;
    }
</style>

<div class="space-y-8">
    {{-- HEADER HALAMAN --}}
    <div class="flex justify-between items-start px-1 mb-2">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-[#0F172A]">Inventory</h1>
            <p class="text-slate-400 font-medium text-sm tracking-wide mt-1">
                Manajemen stok perangkat dan peralatan teknisi MMA Gading Nias.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-8">
        {{-- SECTION: ROUTER ASSETS --}}
        <div class="col-span-12 bento-card overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                <h3 class="text-xl font-black text-[#0F172A]">Router Assets</h3>
                <button onclick="toggleModal('routerModal')" class="bg-orange-500 hover:bg-[#0F172A] text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-orange-500/20 transition-all flex items-center gap-2 text-[11px] uppercase tracking-widest">
                    <span>+ Add New Router</span>
                </button>
            </div>

            <table class="w-full text-left">
                <thead>
                    <tr class="table-header-text uppercase tracking-[0.2em] border-b border-slate-50">
                        <th class="p-8">Router Model</th>
                        <th class="p-8">Serial Number</th>
                        <th class="p-8">Status</th>
                        <th class="p-8 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($routers as $router)
                    <tr class="group hover:bg-slate-50/30 transition-all">
                        <td class="p-8 table-body-text">{{ $router->product->name }}</td>
                        <td class="p-8">
                            <span class="font-mono text-orange-600 bg-orange-50 px-3 py-1.5 rounded-xl text-xs font-black border border-orange-100">
                                {{ $router->serial_number }}
                            </span>
                        </td>
                        <td class="p-8">
                            <div class="flex items-center gap-2 text-green-600">
                                <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                <span class="text-[11px] font-black uppercase tracking-widest">Available</span>
                            </div>
                        </td>
                        <td class="p-8 text-right flex justify-end gap-3">
                            {{-- Edit Router --}}
                            <button onclick="openEditRouter('{{ $router->id }}', '{{ $router->product->name }}', '{{ $router->serial_number }}')" 
                                    class="p-3 bg-slate-100 text-slate-400 hover:text-[#0F172A] rounded-xl transition-all shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 113.536 3.536L12 17.207l-4 1 1-4 9.414-9.414z" />
                                </svg>
                            </button>

                            <a href="{{ route('install.create', ['sn_id' => $router->id]) }}" class="inline-block bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                                Use for Installation
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-20 text-center text-slate-300 font-bold italic">Belum ada unit router di gudang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- SECTION: INSTALLATION TOOLS --}}
        <div class="col-span-12 bento-card overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                <h3 class="text-xl font-black text-[#0F172A]">Installation Tools</h3>
                <button onclick="toggleModal('toolModal')" class="bg-blue-900 hover:bg-orange-500 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-blue-900/20 transition-all flex items-center gap-2 text-[11px] uppercase tracking-widest">
                    <span>+ Add New Tool</span>
                </button>
            </div>

            <table class="w-full text-left">
                <thead>
                    <tr class="table-header-text uppercase tracking-[0.2em] border-b border-slate-50">
                        <th class="p-8">Tool / Material Name</th>
                        <th class="p-8 text-center">Current Stock</th>
                        <th class="p-8 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($tools as $tool)
                    <tr class="hover:bg-slate-50/30 transition-all group">
                        <td class="p-8 table-body-text flex items-center gap-4">
                            <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-sm">🛠️</div>
                            {{ $tool->name }}
                        </td>
                        <td class="p-8 text-center">
                            <span class="text-2xl font-black text-blue-900">{{ $tool->available_stock }}</span>
                            <span class="text-[11px] font-black text-slate-400 ml-1 uppercase">Unit / Meter</span>
                        </td>
                        <td class="p-8 text-right flex justify-end gap-2">
                            {{-- Edit Tool --}}
                            <button onclick="openEditTool('{{ $tool->id }}', '{{ $tool->name }}')" 
                                    class="p-3 bg-slate-100 text-slate-400 hover:text-blue-600 rounded-xl transition-all shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 113.536 3.536L12 17.207l-4 1 1-4 9.414-9.414z" />
                                </svg>
                            </button>
                            
                            {{-- Delete Tool --}}
                            <form action="{{ route('inventory.destroyTool', $tool->id) }}" method="POST" onsubmit="return confirm('Hapus peralatan {{ $tool->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-3 bg-slate-100 text-slate-400 hover:text-red-600 rounded-xl transition-all shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-20 text-center text-slate-300 font-bold italic">Stok peralatan masih kosong.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL ADD ROUTER --}}
<div id="routerModal" class="fixed inset-0 z-[60] flex items-center justify-center hidden p-4">
    <div class="absolute inset-0 bg-[#0F172A]/40 backdrop-blur-md" onclick="toggleModal('routerModal')"></div>
    <div class="bg-white w-full max-w-xl p-10 rounded-[40px] shadow-2xl relative z-10 border border-slate-100">
        <div class="mb-8">
            <h3 class="text-2xl font-black text-[#0F172A]">Add New Router</h3>
            <p class="text-sm text-slate-400 font-medium">Input serial number unit yang baru masuk.</p>
        </div>
        <form action="{{ route('inventory.storeRouter') }}" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Router Model</label>
                <select name="name_router" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-orange-500/10 transition-all cursor-pointer">
                    <option value="Ruijie RG-EW300N">Ruijie RG-EW300N</option>
                    <option value="TP-Link AC1200">TP-Link AC1200</option>
                    <option value="TP-Link AC750">TP-Link AC750</option>
                    <option value="TP-Link TL-WR844N">TP-Link TL-WR844N</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Serial Numbers (Per Baris)</label>
                <textarea name="sns" rows="4" class="w-full px-6 py-4 bg-slate-50 border-none rounded-[28px] font-bold text-sm outline-none focus:ring-4 focus:ring-orange-500/10 transition-all" placeholder="Ketik atau scan SN satu per baris..." required></textarea>
            </div>
            <button type="submit" class="w-full bg-orange-500 hover:bg-[#0F172A] text-white font-bold py-5 rounded-[22px] transition-all shadow-xl shadow-orange-500/20 uppercase text-[10px] tracking-[0.3em] mt-4">
                Confirm Records
            </button>
        </form>
    </div>
</div>

{{-- MODAL EDIT ROUTER --}}
<div id="editRouterModal" class="fixed inset-0 z-[60] flex items-center justify-center hidden p-4">
    <div class="absolute inset-0 bg-[#0F172A]/40 backdrop-blur-md" onclick="toggleModal('editRouterModal')"></div>
    <div class="bg-white w-full max-w-xl p-10 rounded-[40px] shadow-2xl relative z-10 border border-slate-100">
        <div class="mb-8">
            <h3 class="text-2xl font-black text-[#0F172A]">Edit Router Data</h3>
            <p class="text-sm text-slate-400 font-medium">Koreksi kesalahan input model atau serial number.</p>
        </div>
        <form id="editRouterForm" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Router Model</label>
                <select name="name_router" id="edit_name_router" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-orange-500/10 transition-all cursor-pointer">
                    <option value="Ruijie RG-EW300N">Ruijie RG-EW300N</option>
                    <option value="TP-Link AC1200">TP-Link AC1200</option>
                    <option value="TP-Link AC750">TP-Link AC750</option>
                    <option value="TP-Link TL-WR844N">TP-Link TL-WR844N</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Serial Number</label>
                <input type="text" name="serial_number" id="edit_serial_number" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-orange-500/10 transition-all" required>
            </div>
            <button type="submit" class="w-full bg-[#0F172A] hover:bg-orange-500 text-white font-bold py-5 rounded-[22px] transition-all shadow-xl shadow-blue-900/20 uppercase text-[10px] tracking-[0.3em] mt-4">
                Update Record
            </button>
        </form>
    </div>
</div>

{{-- MODAL EDIT TOOL --}}
<div id="editToolModal" class="fixed inset-0 z-[60] flex items-center justify-center hidden p-4">
    <div class="absolute inset-0 bg-[#0F172A]/40 backdrop-blur-md" onclick="toggleModal('editToolModal')"></div>
    <div class="bg-white w-full max-w-xl p-10 rounded-[40px] shadow-2xl relative z-10 border border-slate-100">
        <div class="mb-8">
            <h3 class="text-2xl font-black text-[#0F172A]">Edit Tool Name</h3>
            <p class="text-sm text-slate-400 font-medium">Ubah nama peralatan atau material instalasi.</p>
        </div>
        <form id="editToolForm" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tool/Material Name</label>
                <input type="text" name="name_tool" id="edit_name_tool" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-blue-900/10 transition-all" required>
            </div>
            <button type="submit" class="w-full bg-blue-900 hover:bg-orange-500 text-white font-bold py-5 rounded-[22px] transition-all shadow-xl shadow-blue-900/20 uppercase text-[10px] tracking-[0.3em] mt-4">
                Update Tool Name
            </button>
        </form>
    </div>
</div>

{{-- MODAL ADD TOOLS --}}
<div id="toolModal" class="fixed inset-0 z-[60] flex items-center justify-center hidden p-4">
    <div class="absolute inset-0 bg-[#0F172A]/40 backdrop-blur-md" onclick="toggleModal('toolModal')"></div>
    <div class="bg-white w-full max-w-xl p-10 rounded-[40px] shadow-2xl relative z-10 border border-slate-100">
        <div class="mb-8">
            <h3 class="text-2xl font-black text-[#0F172A]">Update Tools Stock</h3>
            <p class="text-sm text-slate-400 font-medium">Update jumlah Peralatan Instalasi</p>
        </div>
        <form action="{{ route('inventory.storeTool') }}" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tool/Material Name</label>
                <input type="text" name="name_tool" placeholder="e.g. Paku Klem / Isolasi" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-blue-900/10 transition-all" required>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Quantity</label>
                <input type="number" name="qty" placeholder="Jumlah unit/meter..." class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-blue-900/10 transition-all" required>
            </div>
            <button type="submit" class="w-full bg-blue-900 hover:bg-orange-500 text-white font-bold py-5 rounded-[22px] transition-all shadow-xl shadow-blue-900/20 uppercase text-[10px] tracking-[0.3em] mt-4">
                Update Stock
            </button>
        </form>
    </div>
</div>

<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }

    function openEditRouter(id, name, sn) {
        const form = document.getElementById('editRouterForm');
        form.action = `/inventory/router/${id}`;
        document.getElementById('edit_name_router').value = name;
        document.getElementById('edit_serial_number').value = sn;
        toggleModal('editRouterModal');
    }

    function openEditTool(id, name) {
        const form = document.getElementById('editToolForm');
        form.action = `/inventory/tool/${id}`;
        document.getElementById('edit_name_tool').value = name;
        toggleModal('editToolModal');
    }
</script>
@endsection