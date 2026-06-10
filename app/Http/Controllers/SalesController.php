<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\BarangModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SalesController extends Controller
{
    public function index() {
        $breadcrumb = (object)['title' => 'Daftar Transaksi', 'list' => ['Home', 'Data Transaksi', 'Penjualan']];
        $page = (object)['title' => 'Daftar Penjualan Barang'];
        $activeMenu = 'penjualan';
        $user = UserModel::all(); 
        return view('penjualan.index', compact('breadcrumb', 'page', 'activeMenu', 'user'));
    }

    public function list(Request $request) {
        $penjualan = PenjualanModel::select('penjualan_id', 'user_id', 'pembeli', 'penjualan_tanggal')
                                   ->with('user');

        if ($request->user_id) {
            $penjualan->where('user_id', $request->user_id);
        }

        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($p) {
                return  '<button onclick="modalAction(\''.url('/penjualan/'.$p->penjualan_id.'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ' .
                        '<button onclick="modalAction(\''.url('/penjualan/'.$p->penjualan_id.'/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ' .
                        '<button onclick="modalAction(\''.url('/penjualan/'.$p->penjualan_id.'/confirm_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // ================= AMBIL DATA MODAL (GET) =================

    public function create_ajax() {
        $barang = BarangModel::all();
        $user = UserModel::all();
        return view('penjualan.create_ajax', compact('barang', 'user'));
    }

    public function edit_ajax($id) {
        $penjualan = PenjualanModel::with(['detail.barang', 'user'])->find($id);
        $barang = BarangModel::all();
        return view('penjualan.edit_ajax', compact('penjualan', 'barang'));
    }

    public function show_ajax($id) {
        $penjualan = PenjualanModel::with(['user', 'detail.barang'])->find($id);
        return view('penjualan.show_ajax', compact('penjualan'));
    }

    // Method untuk menampilkan modal konfirmasi hapus
    public function confirm_ajax($id) {
        $penjualan = PenjualanModel::find($id);
        return view('penjualan.confirm_ajax', compact('penjualan'));
    }

    // ================= PROSES DATA AJAX (POST/PUT/DELETE) =================

    public function store_ajax(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'pembeli'           => 'required|string|max:100',
                'user_id'           => 'required|integer',
                'penjualan_tanggal' => 'required|date',
                'barang_id'         => 'required|array',
                'jumlah'            => 'required|array',
                'harga'             => 'required|array'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Validasi gagal.', 'msgField' => $validator->errors()]);
            }

            try {
                DB::transaction(function () use ($request) {
                    $penjualan = PenjualanModel::create([
                        'user_id'           => $request->user_id,
                        'pembeli'           => $request->pembeli,
                        'penjualan_tanggal' => $request->penjualan_tanggal
                    ]);
                    foreach ($request->barang_id as $index => $barangId) {
                        PenjualanDetailModel::create([
                            'penjualan_id' => $penjualan->penjualan_id,
                            'barang_id'    => $barangId,
                            'jumlah'       => $request->jumlah[$index],
                            'harga'        => $request->harga[$index]
                        ]);
                    }
                });
                return response()->json(['status' => true, 'message' => 'Transaksi berhasil disimpan']);
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Gagal: ' . $e->getMessage()]);
            }
        }
        return redirect('/penjualan');
    }

    public function update_ajax(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $penjualan = PenjualanModel::find($id);
            if (!$penjualan) return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);

            try {
                DB::transaction(function () use ($request, $penjualan) {
                    $penjualan->update(['pembeli' => $request->pembeli]);
                    $penjualan->detail()->delete();
                    foreach ($request->barang_id as $index => $barangId) {
                        $penjualan->detail()->create([
                            'barang_id' => $barangId,
                            'jumlah'    => $request->jumlah[$index],
                            'harga'     => $request->harga[$index]
                        ]);
                    }
                });
                return response()->json(['status' => true, 'message' => 'Data berhasil diupdate']);
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Gagal: ' . $e->getMessage()]);
            }
        }
        return redirect('/penjualan');
    }

    // Method untuk eksekusi hapus data
   public function delete_ajax(Request $request, $id) {
    if ($request->ajax() || $request->wantsJson()) {
        $penjualan = PenjualanModel::find($id);
        
        if ($penjualan) {
            try {
                $penjualan->detail()->delete();
                $penjualan->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                // Ini akan menangkap error 1451 tadi
                return response()->json([
                    'status' => false,
                    'message' => 'Data gagal dihapus karena masih digunakan dalam data lain (seperti tabel stok).'
                ]);
            }
        }
        
        return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
    }
    return redirect('/');
}
}