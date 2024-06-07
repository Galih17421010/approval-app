<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('pengajuan.index');
    }

    public function show(Request $request)
    {
        $data = Pengajuan::orderBy('id','DESC')->get();
        $html = array();
        foreach ( $data as $d ) {
            $html[] = '<div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title m-0">Pengajuan - '.$d->nama_barang.'</h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-cog"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <a href="" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a>
                        <a href="" class="dropdown-item"><i class="fa fa-trash"></i> Delete</a>
                    </div>
                </div>
             </div>
            <div class="card-body">
            
            <p class="card-text">'.$d->alasan_pengajuan.'</p>
            
            </div>
            <div class="card-footer">
                <a href="" class="btn btn-primary float-right">Action</a>
                <div>
                </div>
                <h6 class="text-success"><i class="far fa-check-circle"></i> Diajukan '.$d->created_at.'</span>
            </div>
         </div>';
        }
        
        return response()->json(['html' => $html]);
    }

    public function store(Request $request)
    {
        $pengajuan = new Pengajuan ([
            'user_id' => $request->input('user_id'),
            'nama_barang' => $request->input('nama_barang'),
            'alasan_pengajuan' => $request->input('alasan_pengajuan'),
            'qty' => $request->input('qty'),
            'harga_satuan' => $request->input('harga_satuan')
        ]);

        $pengajuan->save();

        // $html=view('load',compact($pengajuan))->render();

        return response()->json([
            // 'html' => $html,
            'success' => true,
            'message' => 'Barang Berhasil Diajukan!',
            'data'    => $pengajuan  
        ]);
    }
    
    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    
    public function destroy(string $id)
    {
        //
    }
}
