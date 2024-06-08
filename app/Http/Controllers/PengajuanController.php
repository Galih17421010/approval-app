<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
    
    public function table(Request $request)
    {

            $data = Pengajuan::orderBy('id','DESC')->get();

            return DataTables::of($data)
                    ->addColumn('data', function($d){
                            $btn = '<div class="card card-primary card-outline" id='.$d->id.'>
                            <div class="card-header">
                                <h5 class="card-title m-0">Pengajuan - '.$d->nama_barang.'</h5>
                                <div class="card-tools">
                                  
                                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                                      <button id="btn-edit" class="dropdown-item"><i class="fa fa-edit"></i> Edit</button>
                                      <button id="btn-delete" class="dropdown-item"><i class="fa fa-trash"></i> Delete</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Diajukan oleh '.$d->user_id.' pada '.date('d-m-Y H:m', strtotime($d->created_at)).'</h6>
                                        <p class="card-text"><b> Keterangan :</b> <br>'.$d->alasan_pengajuan.'</p>
                                        </div>
                                    <div class="col-md-6">
                                        <p class="text-right">Harga Satuan <b>Rp '.$d->harga_satuan.'</b> <br> Sejumlah <b>'.$d->qty.'</b> Buah</p>
                                        <h4 class="float-right">Total Rp '.$d->total_harga.'</h4>
                                    </div>
                                </div>
                                <center>
                                    <button class="btn btn-sm btn-block btn-light" id="btn-detail">
                                        <span class="text-success"><i class="far fa-check-circle"></i> Menunggu Persetujuan Manager</span>
                                    </button> 
                                </center>
                            </div>
                            <div class="card-footer">    
                                  <center>
                                    <button id="reject-manager" class="btn btn-sm btn-danger">Reject</button>&nbsp;
                                    <button id="approve-manager" class="btn btn-sm btn-success">Approve</button> 
                                    <button id="reject-finance" class="btn btn-sm btn-danger">Reject</button>&nbsp;
                                    <button id="approve-finance" class="btn btn-sm btn-success">Approve</button>  
                                  </center>
                            </div>
                          </div>';   
      
                            return $btn;
                    })
                    ->rawColumns(['data'])
                    ->make(true);
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
