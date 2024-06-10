<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PengajuanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
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


        return response()->json([
            'success' => true,
            'message' => 'Barang Berhasil Diajukan!',
            'data'    => $pengajuan  
        ]);
    }

    public function detail(string $id)
    {
        $pengajuan = Pengajuan::find($id);
        return response()->json(['pengajuan' => $pengajuan]);
    }

    public function edit(string $id)
    {
        $data = Pengajuan::find($id);
        return response()->json(['data' => $data]);
    }

    public function update(Request $request, string $id)
    {
        $pengajuan = Pengajuan::find($id);
        $pengajuan->nama_barang = $request->nama_barang;
        $pengajuan->alasan_pengajuan = $request->alasan_pengajuan;
        $pengajuan->qty = $request->qty;
        $pengajuan->harga_satuan = $request->harga_satuan;
        $pengajuan->update();
        return response()->json(['status' => "success", 'message' => 'Barang Berhasil Diupdate!']);
    }
    
    public function destroy(string $id)
    {
        Pengajuan::destroy($id);
        return response()->json(['status' => "success"]);
    }
    
    public function table()
    {
        $data = DB::table('pengajuans')->select('*','pengajuans.id as id')
                    ->leftJoin('managers','pengajuans.id','=','managers.pengajuan_id')
                    ->leftJoin('finances','pengajuans.id','=','finances.pengajuan_finance_id')
                    ->orderBy('pengajuans.id','DESC')->get();
        
        return DataTables::of($data)
            ->addColumn('data', function($d){
                if (Auth::user()->role == 'Manager' && $d->manager == null) {
                    $button = '<button id="reject-manager" data-id="'.$d->id.'" da class="btn btn-sm btn-danger">Reject</button>&nbsp;
                                <button id="approve-manager" data-id="'.$d->id.'" class="btn btn-sm btn-success">Approve</button>';
                    
                }elseif (Auth::user()->role == 'Finance' && $d->manager == 'Approved' && $d->finance == null) {
                    $button = '<button id="reject-finance" data-id="'.$d->id.'" class="btn btn-sm btn-danger">Reject</button>&nbsp;
                                <button id="approve-finance" data-id="'.$d->id.'" class="btn btn-sm btn-success">Approve</button>';
                }elseif($d->finance == 'Approved'){
                    $button = '<button id="bukti-finance" data-id="'.$d->id.'" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalBukti" data-keyboard="false" data-backdrop="static">
                                Upload Bukti Pembayaran
                                </button>';
                }else{
                    $button = '';
                }

                if ($d->user_id == Auth::user()->id && $d->manager == null) {
                    $dropdown = '';
                }else{
                    $dropdown = 'disabled';
                }

                $card = '<div class="card card-primary card-outline" id='.$d->id.'>
                            <div class="card-header">
                                <h5 class="card-title m-0">Pengajuan - '.$d->nama_barang.'</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool dropdown-toggle '.$dropdown.'" data-toggle="dropdown">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <button id="btn-edit" data-id="'.$d->id.'" class="dropdown-item" data-toggle="modal" data-target="#editPengajuan" data-keyboard="false" data-backdrop="static">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <button id="btn-delete" data-id="'.$d->id.'" class="dropdown-item"><i class="fa fa-trash"></i> Delete</button>
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
                                    <button class="btn btn-sm btn-block btn-light" id="btn-detail" data-id="'.$d->id.'" data-toggle="modal" data-target="#detailPengajuan" data-keyboard="false" data-backdrop="static">
                                        <span class="text-success"><i class="far fa-check-circle"></i> Menunggu Persetujuan Manager</span>
                                    </button> 
                                </center>
                            </div>
                            <div class="card-footer">    
                                <center>
                                    '.$button.' 
                                </center>
                            </div>
                        </div>';   
            return $card;
            })
            ->rawColumns(['data'])
            ->make(true);
    }

    public function upload(Request $request, $id){
        
    }
}
