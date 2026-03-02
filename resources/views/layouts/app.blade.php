<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventra MMA - ISP Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F1F5F9; }
        
        /* Bento Card Style Global */
        .bento-card { 
            background: white; 
            border-radius: 32px; 
            border: 1px solid rgba(226, 232, 240, 0.6); 
            transition: all 0.3s ease; 
        }
        
        /* Custom Scrollbar untuk area konten */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
    </style>
</head>
<body class="text-[#0F172A] antialiased">
    <div class="flex h-screen overflow-hidden p-4 gap-4">
        
        <aside class="w-72 bg-white rounded-[40px] border border-slate-50 flex flex-col p-8 shadow-sm shrink-0 h-full">
            <div class="flex items-center gap-3 mb-12 px-2">
                <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center text-white font-black shadow-lg shadow-orange-500/30">I</div>
                <span class="text-xl font-extrabold tracking-tight">Inventra<span class="text-orange-500">.</span></span>
            </div>

            <nav class="flex-1 space-y-2 overflow-y-auto pr-2 custom-scrollbar">
                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl font-bold transition-all {{ request()->routeIs('dashboard') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                {{-- Inventory --}}
                <a href="{{ route('inventory.index') }}" 
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl font-bold transition-all {{ request()->routeIs('inventory.*') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span>Inventory</span>
                </a>

                {{-- Installations --}}
                <a href="{{ route('install.index') }}" 
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl font-bold transition-all {{ request()->routeIs('install.*') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a11 11 0 0115.556 0M2 10.5a15 15 0 0120 0" />
                    </svg>
                    <span>Installations</span>
                </a>

                {{-- Reports (NEW) --}}
                <a href="{{ route('reports.index') }}" 
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl font-bold transition-all {{ request()->routeIs('reports.*') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Reports</span>
                </a>

                {{-- Clients --}}
                <a href="{{ route('clients.index') }}" 
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl font-bold transition-all {{ request()->routeIs('clients.*') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Clients</span>
                </a>
            </nav>

            <div class="mt-8 pt-8 border-t border-slate-50">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-4 px-6 py-4 rounded-2xl font-bold text-red-400 hover:bg-red-50 transition-all w-full text-left">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-full overflow-hidden">
            <div class="flex-1 overflow-y-auto custom-scrollbar px-4">
                <div class="pt-6 pb-12">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</body>
</html>