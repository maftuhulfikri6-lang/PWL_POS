<?php

namespace App\Http\Controllers;

use App\Models\LevelModel; // Tambahkan ini
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables; // Tambahkan ini

class LevelController extends Controller
{
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

    public function list(Request $request) 
    {
        // Mengambil data dari LevelModel
        $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');

        return DataTables::of($levels)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) {
                $btn  = '<a href="'.url('/level/' . $level->level_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/level/' . $level->level_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/level/'.$level->level_id).'">'.
                        csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}