<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    // Menampilkan halaman awal level
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level']
        ];
        
        $page = (object) [
            'title' => 'Daftar level pengguna dalam sistem'
        ];
        
        $activeMenu = 'level'; 
        
        return view('level.index', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'activeMenu' => $activeMenu
        ]);
    }

    // Ambil data level dalam bentuk json untuk datatables
    public function list(Request $request) 
    {
        $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');

        return DataTables::of($levels)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) {
    $btn  = '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
    $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
    $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
    return $btn;
})

            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Menampilkan halaman form tambah level biasa
    public function create() {
        $breadcrumb = (object)['title' => 'Tambah Level', 'list' => ['Home', 'Level', 'Tambah']];
        $page = (object)['title' => 'Tambah Level Baru'];
        $activeMenu = 'level';
        return view('level.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    // Menyimpan data level baru biasa
    public function store(Request $request) {
        $request->validate([
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100'
        ]);
        LevelModel::create($request->all());
        return redirect('/level')->with('success', 'Data level berhasil disimpan');
    }

    // Menampilkan detail level biasa
    public function show($id) {
        $level = LevelModel::find($id);
        $breadcrumb = (object)['title' => 'Detail Level', 'list' => ['Home', 'Level', 'Detail']];
        $page = (object)['title' => 'Detail Level'];
        $activeMenu = 'level';
        return view('level.show', compact('level', 'breadcrumb', 'page', 'activeMenu'));
    }

    // Menampilkan halaman form edit level biasa
    public function edit($id) {
        $level = LevelModel::find($id);
        $breadcrumb = (object)['title' => 'Edit Level', 'list' => ['Home', 'Level', 'Edit']];
        $page = (object)['title' => 'Edit Level'];
        $activeMenu = 'level';
        return view('level.edit', compact('level', 'breadcrumb', 'page', 'activeMenu'));
    }

    // Menyimpan perubahan data level biasa
    public function update(Request $request, $id) {
        $request->validate([
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode,'.$id.',level_id',
            'level_nama' => 'required|string|max:100'
        ]);

        LevelModel::find($id)->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama
        ]);

        return redirect('/level')->with('success', 'Data level berhasil diubah');
    }
    
    // Menghapus data level biasa
    public function destroy($id) {
        $check = LevelModel::find($id);
        if (!$check) return redirect('/level')->with('error', 'Data tidak ditemukan');
        
        try {
            LevelModel::destroy($id);
            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/level')->with('error', 'Data level gagal dihapus karena masih digunakan tabel lain');
        }
    }

    // ==================== IMPLEMENTASI AJAX ====================

    // 1. Menampilkan modal tambah level via AJAX
    public function create_ajax()
    {
        return view('level.create_ajax');
    }

    public function show_ajax($id) {
    // Mencari data level berdasarkan id
    $level = LevelModel::find($id);

    if ($level) {
        return view('level.show_ajax', compact('level'));
    } else {
        return response()->json([
            'status' => false,
            'message' => 'Data level tidak ditemukan'
        ]);
    }
}
public function edit_ajax($id) {
    $level = LevelModel::find($id);
    return view('level.edit_ajax', compact('level'));
}

    // 2. Menyimpan data level baru via AJAX
    public function store_ajax(Request $request) 
    {
        if($request->ajax() || $request->wantsJson()){
            $rules = [
                // Mengubah min:3 menjadi min:2 agar sinkron dengan jQuery validation
                'level_kode' => 'required|string|min:2|max:10|unique:m_level,level_kode',
                'level_nama' => 'required|string|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()){
                return response()->json([
                    'status'    => false,
                    'message'   => 'Validasi Gagal',
                    'msgField'  => $validator->errors()
                ]);
            }

            LevelModel::create($request->all());

            return response()->json([
                'status'    => true,
                'message'   => 'Data level berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    // 4. Menyimpan perubahan data level via AJAX
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // Mengubah min:3 menjadi min:2 agar sinkron dengan jQuery validation
                'level_kode' => 'required|string|min:2|max:10|unique:m_level,level_kode,'.$id.',level_id',
                'level_nama' => 'required|string|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $level = LevelModel::find($id);
            if ($level) {
                $level->update($request->all());
                return response()->json([
                    'status'  => true,
                    'message' => 'Data level berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Data tidak ditemukan',
                    'msgField' => [] // Ditambahkan untuk menjaga konsistensi skrip js
                ]);
            }
        }
        return redirect('/');
    }

public function confirm_ajax($id) {
    $level = LevelModel::find($id);
    return view('level.confirm_ajax', compact('level'));
}

public function delete_ajax(Request $request, $id) {
    if ($request->ajax() || $request->wantsJson()) {
        $level = LevelModel::find($id);
        if ($level) {
            try {
                $level->delete();
                return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']);
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Data gagal dihapus']);
            }
        }
        return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
    }
    return redirect('/level');
}

}