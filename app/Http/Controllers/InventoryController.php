<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SerialNumber;
use App\Models\Client;
use Illuminate\Http\Request;
use DateTime;

class InventoryController extends Controller
{
    // --- 1. DASHBOARD ---
    public function index()
    {
        $products = Product::withCount(['serialNumbers as available_stock' => function($query) {
            $query->where('status', 'MASUK');
        }])->get();

        $totalClients = SerialNumber::where('status', 'KELUAR')->count();
        $totalThisMonth = SerialNumber::where('status', 'KELUAR')->whereMonth('installed_at', now()->month)->count();
        $usedCableMonth = SerialNumber::where('status', 'KELUAR')->whereMonth('installed_at', now()->month)->sum('cable_length');

        $monthlyData = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyData[] = SerialNumber::where('status', 'KELUAR')->whereMonth('installed_at', $m)->whereYear('installed_at', now()->year)->count();
        }

        // --- LOGIC BARU: SALES PERFORMANCE ---
        // Mengambil semua data sales dan menghitung jumlah klien yang mereka bawa
        $salesList = ['Mufarohah', 'Olivia', 'Amanda', 'Ika'];
        $salesPerformance = [];
        
        foreach ($salesList as $name) {
            $count = Client::where('sales_name', $name)->count();
            // Hitung persentase untuk progress bar (misal target 20 client per sales)
            $percentage = ($count / 20) * 100; 
            $salesPerformance[] = [
                'name' => $name,
                'count' => $count,
                'percentage' => $percentage > 100 ? 100 : $percentage
            ];
        }

        return view('dashboard', compact('products', 'totalClients', 'totalThisMonth', 'usedCableMonth', 'monthlyData', 'salesPerformance'));
    }

    // --- 2. INVENTORY ---
    public function inventoryIndex()
    {
        $routers = SerialNumber::with('product')
                    ->where('status', 'MASUK')
                    ->whereHas('product', function($q) {
                        $q->where('category', 'Router');
                    })->latest()->get();

        $tools = Product::withCount(['serialNumbers as available_stock' => function($q) {
                        $q->where('status', 'MASUK');
                    }])->where('category', 'Tools')->get();
        
        return view('inventory.index', compact('routers', 'tools'));
    }

    public function storeRouter(Request $request)
    {
        $request->validate(['name_router' => 'required', 'sns' => 'required']);
        $product = Product::firstOrCreate(['name' => $request->name_router], ['category' => 'Router']);
        $snArray = explode("\n", str_replace("\r", "", $request->sns));
        foreach ($snArray as $sn) {
            if (!empty(trim($sn))) {
                if (!SerialNumber::where('serial_number', trim($sn))->exists()) {
                    SerialNumber::create([
                        'product_id' => $product->id,
                        'serial_number' => trim($sn),
                        'status' => 'MASUK',
                    ]);
                }
            }
        }
        return redirect()->back()->with('success', 'Router berhasil ditambah!');
    }

    public function storeTool(Request $request)
    {
        $request->validate(['name_tool' => 'required', 'qty' => 'required|integer']);
        $product = Product::firstOrCreate(['name' => $request->name_tool], ['category' => 'Tools']);
        for ($i = 0; $i < $request->qty; $i++) {
            SerialNumber::create([
                'product_id' => $product->id,
                'serial_number' => 'TOOL-' . strtoupper(uniqid()), 
                'status' => 'MASUK',
            ]);
        }
        return redirect()->back()->with('success', 'Tool berhasil ditambah!');
    }

    public function updateTool(Request $request, $id)
    {
        $request->validate([
            'name_tool' => 'required',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name_tool
        ]);

        return redirect()->back()->with('success', 'Nama peralatan berhasil diperbarui!');
    }

    public function destroyTool($id)
    {
        $product = Product::findOrFail($id);
        // Ini akan menghapus produk dan semua "stok" (serial_numbers) terkait
        $product->delete();

        return redirect()->back()->with('success', 'Peralatan berhasil dihapus dari sistem!');
    }

    // --- 3. INSTALLATIONS (RECORDS & EDIT) ---
    public function indexInstallation(Request $request)
    {
        $query = SerialNumber::with('product')->where('status', 'KELUAR');
        if ($request->has('month') && $request->month != '') {
            $query->whereMonth('installed_at', $request->month);
        }
        $installations = $query->latest('installed_at')->get();
        $totalThisMonth = SerialNumber::where('status', 'KELUAR')->whereMonth('installed_at', now()->month)->count();
        $totalInstallations = SerialNumber::where('status', 'KELUAR')->count();
        $totalChurn = Client::where('status', 'NONAKTIF')->count();
        
        return view('installations.index', compact('installations', 'totalThisMonth', 'totalInstallations', 'totalChurn'));
    }

    public function createInstallation(Request $request)
    {
        $availableSNs = SerialNumber::where('status', 'MASUK')
                        ->whereHas('product', function($q) {
                            $q->where('category', 'Router');
                        })->with('product')->get();
        
        $selectedSN = null;
        if ($request->has('sn_id')) {
            $selectedSN = SerialNumber::with('product')->find($request->sn_id);
        }

        return view('installations.create', compact('availableSNs', 'selectedSN'));
    }

    public function storeInstallation(Request $request)
    {
        $request->validate([
            'serial_number_id' => 'required|exists:serial_numbers,id',
            'nomor_unit' => 'required',
            'teknisi' => 'required|array',
            'tanggal_pengerjaan' => 'required|date',
            'panjang_kabel' => 'required|integer',
        ]);

        $sn = SerialNumber::findOrFail($request->serial_number_id);
        $sn->update([
            'status' => 'KELUAR',
            'client_unit' => strtoupper($request->nomor_unit),
            'technician' => $request->teknisi,
            'cable_length' => $request->panjang_kabel,
            'work_date' => $request->tanggal_pengerjaan,
            'installed_at' => $request->tanggal_pengerjaan, 
        ]);

        return redirect()->route('install.index')->with('success', 'Aktivasi Berhasil!');
    }

    // METHOD BARU: Menampilkan Form Edit Instalasi
    public function editInstallation($id)
    {
        $selectedSN = SerialNumber::with('product')->findOrFail($id);
        
        // Ambil stok cadangan jika ingin mengganti unit (opsional)
        $availableSNs = SerialNumber::where('status', 'MASUK')
                        ->whereHas('product', function($q) {
                            $q->where('category', 'Router');
                        })->with('product')->get();

        return view('installations.create', compact('selectedSN', 'availableSNs'));
    }

    // METHOD BARU: Menyimpan Perubahan Update Instalasi
    public function updateInstallation(Request $request, $id)
    {
        $request->validate([
            'nomor_unit' => 'required',
            'teknisi' => 'required|array',
            'tanggal_pengerjaan' => 'required|date',
            'panjang_kabel' => 'required|integer',
        ]);

        $sn = SerialNumber::findOrFail($id);
        $sn->update([
            'client_unit' => strtoupper($request->nomor_unit),
            'technician' => $request->teknisi,
            'cable_length' => $request->panjang_kabel,
            'work_date' => $request->tanggal_pengerjaan,
            'installed_at' => $request->tanggal_pengerjaan, 
        ]);

        return redirect()->route('install.index')->with('success', 'Data Instalasi diperbarui!');
    }

    // --- 4. CLIENTS ---
    public function indexClient()
    {
        $clients = Client::latest()->get(); 
        return view('clients.index', compact('clients'));
    }

    public function storeClient(Request $request)
    {
        $request->validate([
            'unit_number' => 'required|unique:clients,unit_number',
            'name' => 'required',
            'phone' => 'required',
            'package' => 'required',
            'sales_name' => 'required'
        ]);

        Client::create([
            'unit_number' => strtoupper($request->unit_number),
            'name' => $request->name,
            'phone' => $request->phone,
            'package' => $request->package,
            'sales_name' => $request->sales_name,
            'status' => 'ACTIVE'
        ]);

        return redirect()->route('clients.index')->with('success', 'Data Client Tersimpan!');
    }

    public function editClient($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    public function updateClient(Request $request, $id)
    {
        $request->validate(['name' => 'required', 'phone' => 'required', 'package' => 'required', 'sales_name' => 'required', 'status' => 'required']);
        $client = Client::findOrFail($id);
        $client->update($request->all());
        return redirect()->route('clients.index')->with('success', 'Data Client Diperbarui!');
    }

    public function destroyInstallation($id)
    {
        $sn = SerialNumber::findOrFail($id);
        $sn->update([
            'status' => 'MASUK', 'client_unit' => null, 'technician' => null, 'cable_length' => null, 'work_date' => null, 'installed_at' => null,
        ]);
        return redirect()->route('install.index')->with('success', 'Data dihapus & SN kembali ke stok.');
    }

    public function updateRouter(Request $request, $id)
    {
        $request->validate([
            'name_router' => 'required',
            'serial_number' => 'required|unique:serial_numbers,serial_number,' . $id
        ]);

        $sn = SerialNumber::findOrFail($id);
        $sn->update([
            'product_id' => Product::firstOrCreate(['name' => $request->name_router], ['category' => 'Router'])->id,
            'serial_number' => trim($request->serial_number),
        ]);

        return redirect()->back()->with('success', 'Data Router berhasil diperbarui!');
    }

    public function destroyClient($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Data Client berhasil dihapus!');
    }
    public function indexReport()
    {
        $monthlyReports = SerialNumber::where('status', 'KELUAR')
            ->whereNotNull('installed_at')
            ->selectRaw("
                EXTRACT(YEAR FROM installed_at) as year, 
                EXTRACT(MONTH FROM installed_at) as month, 
                COUNT(*) as total_units, 
                SUM(cable_length) as total_cable
            ")
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('reports.index', compact('monthlyReports'));
    }
    public function previewReport($year, $month)
    {
        // SQLite kadang sensitif dengan format bulan 1 digit (2) vs 2 digit (02)
        $formattedMonth = str_pad($month, 2, '0', STR_PAD_LEFT);
        
        $details = SerialNumber::where('status', 'KELUAR')
            ->whereRaw("strftime('%Y', installed_at) = ?", [$year])
            ->whereRaw("strftime('%m', installed_at) = ?", [$formattedMonth])
            ->with('product')
            ->get();

        try {
            $periode = DateTime::createFromFormat('!m', $formattedMonth)->format('F') . " " . $year;
        } catch (\Exception $e) {
            $periode = "Periode $formattedMonth-$year";
        }

        return view('reports.preview', compact('details', 'periode'));
    }
}