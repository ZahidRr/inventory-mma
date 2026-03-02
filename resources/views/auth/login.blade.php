<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Inventra MMA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #F1F5F9; /* Menyelaraskan dengan background dashboard */
        }
        .bento-card { 
            background: white; 
            border-radius: 40px; 
            border: 1px solid rgba(226, 232, 240, 0.6); 
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.04);
        }
        .btn-primary {
            background-color: #0F172A;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #F97316;  
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-[440px]">
        
        {{-- Brand Logo & Title --}}
        <div class="flex flex-col items-center mb-10">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 bg-orange-500 rounded-2xl flex items-center justify-center text-white font-black shadow-lg shadow-orange-500/30 text-xl">I</div>
                <h1 class="text-2xl font-extrabold tracking-tighter text-[#0F172A]">
                    Inventra<span class="text-orange-500">.</span>
                </h1>
            </div>
            <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.4em]">Internal Infrastructure</p>
        </div>

        {{-- Login Card --}}
        <div class="bento-card p-12 relative overflow-hidden">
            {{-- Accent Decoration --}}
            <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-bl-full -z-10 opacity-50"></div>

            <div class="mb-10 text-center">
                <h2 class="text-2xl font-black text-[#0F172A] tracking-tight">Authorize Access</h2>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mt-2">Sign in to manage assets</p>
            </div>

            {{-- Error Alerts --}}
            @if ($errors->any())
                <div class="mb-8 p-4 bg-red-50 rounded-2xl border border-red-100">
                    <p class="text-[10px] font-black text-red-500 uppercase tracking-widest text-center">
                        {{ $errors->first() }}
                    </p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-7">
                @csrf
                
                {{-- Username Input --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Account ID</label>
                    <input type="text" name="username" :value="old('username')" required autofocus 
                        class="w-full px-8 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/10 font-black text-sm outline-none transition-all placeholder:text-slate-300" 
                        placeholder="Admin Username">
                </div>

                {{-- Password Input --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Secret Password</label>
                    <input type="password" name="password" required 
                        class="w-full px-8 py-5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-orange-500/10 font-black text-sm outline-none transition-all placeholder:text-slate-300" 
                        placeholder="••••••••">
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full btn-primary text-white font-black py-6 rounded-3xl shadow-xl shadow-blue-900/10 uppercase text-[11px] tracking-[0.3em] mt-4 flex items-center justify-center gap-3">
                    <span>Login System</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </form>
        </div>

        {{-- Footer --}}
        <div class="mt-12 text-center">
            <p class="text-slate-300 text-[9px] font-black uppercase tracking-[0.5em]">
                &copy; 2026 PT Multi Media Access
            </p>
        </div>
    </div>
</body>
</html>