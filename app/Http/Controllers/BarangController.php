<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel; // WAJIB DI-IMPORT untuk dropdown kategori
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator; // WAJIB DI-IMPORT untuk validasi AJAX

class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];
        $page = (object) [
            'title' => 'Daftar barang dalam sistem'
        ];
        $activeMenu = 'barang'; 

        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        // Gunakan with('kategori') agar relasi terbaca di DataTables
        $barangs = BarangModel::with('kategori')->select('barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual');

        return DataTables::of($barangs)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                // Tombol aksi diubah agar memicu modalAction() AJAX
                $btn  = '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show($id) {
        $barang = BarangModel::with('kategori')->find($id);
        $breadcrumb = (object)['title' => 'Detail Barang', 'list' => ['Home', 'Barang', 'Detail']];
        $page = (object)['title' => 'Detail Barang'];
        $activeMenu = 'barang';
        return view('barang.show', compact('barang', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function create() {
        $breadcrumb = (object)['title' => 'Tambah Barang', 'list' => ['Home', 'Barang', 'Tambah']];
        $page = (object)['title' => 'Tambah Barang Baru'];
        $kategori = KategoriModel::all();
        $activeMenu = 'barang';
        return view('barang.create', compact('breadcrumb', 'page', 'kategori', 'activeMenu'));
    }

    public function store(Request $request) {
        $request->validate([
            'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:100',
            'harga_beli'  => 'required|numeric',
            'harga_jual'  => 'required|numeric',
            'kategori_id' => 'required|integer'
        ]);

        BarangModel::create($request->all());
        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    /* -------------------------------------------------------------------------- */
    /* FITUR TAMBAHAN AJAX FORM BARANG                                            */
    /* -------------------------------------------------------------------------- */

    // 1. Menampilkan Form Tambah via AJAX
    public function create_ajax() {
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        return view('barang.create_ajax', compact('kategori'));
    }

    // 2. Menyimpan Data Baru via AJAX
    public function store_ajax(Request $request) {
        if($request->ajax() || $request->wantsJson()){
            $rules = [
                'barang_kode' => 'required|string|min:3|max:10|unique:m_barang,barang_kode',
                'barang_nama' => 'required|string|max:100',
                'harga_beli'  => 'required|numeric',
                'harga_jual'  => 'required|numeric',
                'kategori_id' => 'required|integer'
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            BarangModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data barang berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    // 3. Menampilkan Detail Data via AJAX
    public function show_ajax($id) {
        $barang = BarangModel::with('kategori')->find($id);
        if($barang){
            return view('barang.show_ajax', compact('barang'));
        }
        return response()->json([
            'status' => false,
            'message' => 'Data tidak ditemukan'
        ]);
    }

    // 4. Menampilkan Form Edit via AJAX
    public function edit_ajax($id) {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        return view('barang.edit_ajax', compact('barang', 'kategori'));
    }

    // 5. Menyimpan Perubahan Data via AJAX
    public function update_ajax(Request $request, $id) {
        if($request->ajax() || $request->wantsJson()){
            $rules = [
                'barang_kode' => 'required|string|min:3|max:10|unique:m_barang,barang_kode,'.$id.',barang_id',
                'barang_nama' => 'required|string|max:100',
                'harga_beli'  => 'required|numeric',
                'harga_jual'  => 'required|numeric',
                'kategori_id' => 'required|integer'
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = BarangModel::find($id);
            if($check){
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data barang berhasil diubah'
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        return redirect('/');
    }

    // 6. Menampilkan Modal Konfirmasi Hapus via AJAX
    public function confirm_ajax($id) {
        $barang = BarangModel::with('kategori')->find($id);
        return view('barang.confirm_ajax', compact('barang'));
    }

    // 7. Menghapus Data via AJAX
  public function delete_ajax(Request $request, $id) {
    if ($request->ajax() || $request->wantsJson()) {
        $barang = BarangModel::find($id);
        
        if ($barang) {
            try {
                $barang->delete(); // Proses hapus
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                // Jika terjadi error karena masih ada relasi di tabel lain
                return response()->json([
                    'status' => false,
                    'message' => 'Data gagal dihapus karena masih digunakan sebagai referensi dalam data penjualan.'
                ]);
            }
        }
        
        return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
    }
    return redirect('/');
}
}