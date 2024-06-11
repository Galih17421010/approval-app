<?php

namespace App\Http\Controllers;

use App\Models\Bukti;
use App\Models\Manager;
use App\Models\Pengajuan;
use App\Models\View\VwTracking;
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

    public function detail($id)
    {
        $data = new VwTracking();
        $d = $data->find($id);

        if($d->manager == 'Approved'){
            $manager = '<div class="vertical-timeline-item vertical-timeline-element">
                            <span class="vertical-timeline-element-icon bounce-in">
                                <i class="badge badge-dot badge-dot-xl badge-success"> </i>
                            </span>
                            <div class="vertical-timeline-element-content bounce-in">
                                <h4 class="timeline-title text-success">Disetujui Oleh Manager</h4>
                                <p>Pengajuan disetujui oleh Manager pada <b class="text-success"> '.date('d-m-Y', strtotime($d->manager_created)).'</b><br>
                                <span class="vertical-timeline-element-date text-success">'.date('H:i', strtotime($d->manager_created)).' WIB</span>
                            </div>
                        </div>';
        }elseif($d->manager == 'Rejected'){
            $manager = '<div class="vertical-timeline-item vertical-timeline-element">
                            <span class="vertical-timeline-element-icon bounce-in">
                                <i class="badge badge-dot badge-dot-xl badge-danger"> </i>
                            </span>
                            <div class="vertical-timeline-element-content bounce-in">
                                <h4 class="timeline-title text-danger">Di Tolak Oleh Manager</h4>
                                <p>Pengajuan ditolak oleh Manager pada <b class="text-danger"> '.date('d-m-Y', strtotime($d->manager_created)).'</b> <br>
                                <b>Alasan : </b>'.$d->alasan_manager.'</p>
                                <span class="vertical-timeline-element-date text-danger">'.date('H:i', strtotime($d->manager_created)).' WIB</span>
                            </div>
                        </div>';
        }else{
            $manager = '<div class="vertical-timeline-item vertical-timeline-element">
                            <span class="vertical-timeline-element-icon bounce-in">
                                <i class="badge badge-dot badge-dot-xl badge-info"> </i>
                            </span>
                            <div class="vertical-timeline-element-content bounce-in">
                                <h4 class="timeline-title text-info">Menunggu Persetujuan Manager</h4>
                            </div>
                        </div>';
        }

        if($d->finance == 'Approved'){
            $finance = '<div class="vertical-timeline-item vertical-timeline-element">
                            <span class="vertical-timeline-element-icon bounce-in">
                                <i class="badge badge-dot badge-dot-xl badge-success"> </i>
                            </span>
                            <div class="vertical-timeline-element-content bounce-in">
                                <h4 class="timeline-title text-success">Disetujui Oleh Finance</h4>
                                <p>Pengajuan dibayarkan oleh Finance pada <b class="text-success"> '.date('d-m-Y', strtotime($d->finance_create)).'</b><br>
                                <span class="vertical-timeline-element-date text-success">'.date('H:i', strtotime($d->finance_create)).' WIB</span>
                            </div>
                        </div>';
        }elseif($d->finance == 'Rejected'){
            $finance = '<div class="vertical-timeline-item vertical-timeline-element">
                            <span class="vertical-timeline-element-icon bounce-in">
                                <i class="badge badge-dot badge-dot-xl badge-danger"> </i>
                            </span>
                            <div class="vertical-timeline-element-content bounce-in">
                                <h4 class="timeline-title text-danger">Di Tolak Oleh Finance</h4>
                                <p>Pengajuan ditolak oleh Finance pada<b class="text-danger"> '.date('d-m-Y', strtotime($d->finance_create)).'</b><br>
                                <b>Alasan : </b> '.$d->alasan_finance.'</p>
                                <span class="vertical-timeline-element-date text-danger">'.date('H:i', strtotime($d->finance_create)).' WIB</span>
                            </div>
                        </div>';
        }elseif($d->manager == null || $d->manager == 'Rejected' && $d->finance == null){
            $finance = '';
        }else {
            $finance = '<div class="vertical-timeline-item vertical-timeline-element">
                            <span class="vertical-timeline-element-icon bounce-in">
                                <i class="badge badge-dot badge-dot-xl badge-info"> </i>
                            </span>
                            <div class="vertical-timeline-element-content bounce-in">
                                <h4 class="timeline-title text-info">Menunggu Persetujuan Finance</h4>
                            </div>
                        </div>';
        }

        if ($d->manager == 'Approved' && $d->finance == 'Approved' && $d->bukti_transfer == null) {
            $bayar = '<div class="vertical-timeline-item vertical-timeline-element">
                        <span class="vertical-timeline-element-icon bounce-in">
                            <i class="badge badge-dot badge-dot-xl badge-info"> </i>
                        </span>
                        <div class="vertical-timeline-element-content bounce-in">
                            <h4 class="timeline-title text-info">Menunggu Dibayarkan Oleh Finance</h4>
                        </div>
                    </div>';
        }elseif($d->manager == null || $d->manager == 'Rejected' || $d->manager == 'Approved' && $d->finance == null || $d->finance == 'Rejected' && $d->bukti_transfer == null){
            $bayar = '';
        }else{
            $bayar = '<div class="vertical-timeline-item vertical-timeline-element">
                        <span class="vertical-timeline-element-icon bounce-in">
                            <i class="badge badge-dot badge-dot-xl badge-success"> </i>
                        </span>
                        <div class="vertical-timeline-element-content bounce-in">
                            <h4 class="timeline-title text-success">Pengajuan Telah Dibayarkan oleh Finance</h4>
                            <p>Pengajuan dibayarkan oleh Finance pada <b class="text-success"> '.date('d-m-Y', strtotime($d->finance_update)).'</b><br>
                                <a href="bukti/'.$d->bukti_transfer.'" data-fancybox>Lihat Bukti Pembayaran</a></p>
                            <span class="vertical-timeline-element-date text-success">'.date('H:i', strtotime($d->finance_update)).' WIB</span>
                        </div>
                    </div>';
        }    
        


        $html = '<div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                    '.$bayar.'
                    '.$finance.'
                    '.$manager.'                    
                    <div class="vertical-timeline-item vertical-timeline-element">
                        <span class="vertical-timeline-element-icon bounce-in">
                            <i class="badge badge-dot badge-dot-xl badge-success"> </i>
                        </span>
                        <div class="vertical-timeline-element-content bounce-in">
                            <h4 class="timeline-title text-success">Pengajuan Berhasil Diajukan</h4>
                            <p>Pengajuan Dibuat Oleh Officer Pada<b class="text-success"> '.date('d-m-Y', strtotime($d->updated_at)).'</b></p>
                            <span class="vertical-timeline-element-date text-success">'.date('H:i', strtotime($d->updated_at)).' WIB</span>
                        </div>
                    </div>
                </div>';

        return response()->json(['html' => $html]);
    }

    public function getdata()
    {
        return DB::table('pengajuans')
        ->select('*','pengajuans.id as id', 'pengajuans.created_at','pengajuans.updated_at','finances.created_at as finance_create', 'finances.updated_at as finance_update', 'users.name')
        ->leftJoin('managers','pengajuans.id','=','managers.pengajuan_id')
        ->leftJoin('finances','pengajuans.id','=','finances.pengajuan_finance_id')
        ->leftJoin('users','pengajuans.user_id','=','users.id')
        ->orderBy('pengajuans.id','DESC')->get();
    }

    public function table()
    {
        $data = $this->getdata();

        return DataTables::of($data)
            ->addColumn('data', function($d){
                if (Auth::user()->role == 'Manager' && $d->manager == null) {
                    $button = '<button id="reject-manager" data-id="'.$d->id.'" da class="btn btn-sm btn-danger">Reject</button>&nbsp;
                                <button id="approve-manager" data-id="'.$d->id.'" class="btn btn-sm btn-success">Approve</button>';
                    
                }elseif (Auth::user()->role == 'Finance' && $d->manager == 'Approved' && $d->finance == null) {
                    $button = '<button id="reject-finance" data-id="'.$d->id.'" class="btn btn-sm btn-danger">Reject</button>&nbsp;
                                <button id="approve-finance" data-id="'.$d->id.'" class="btn btn-sm btn-success">Approve</button>';
                }elseif(Auth::user()->role == 'Finance' && $d->finance == 'Approved' && $d->bukti_transfer == null){
                    $button = '<button id="bukti-finance" data-id="'.$d->id.'" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#uploadBuktiBayar" data-keyboard="false" data-backdrop="static">
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

                if($d->bukti_transfer == null){
                    if ($d->manager == null && $d->finance == null) {
                        $status = '<span class="text-success"><i class="far fa-check-circle"></i> Pengajuan Berhasil Diajukan</span>';
                        $cardhead = 'card-primary';
                    }elseif($d->manager == 'Rejected'){
                        $status = '<span class="text-danger"><i class="far fa-times-circle"></i> Pengajuan Ditolak oleh Manager</span>';
                        $cardhead = 'card-danger';
                    }elseif($d->manager == 'Approved' && $d->finance == null){
                        $status = '<span class="text-success"><i class="far fa-check-circle"></i> Pengajuan Disetujui oleh Manager</span>';
                        $cardhead = 'card-primary';
                    }elseif($d->manager == 'Approved' && $d->finance == 'Rejected'){
                        $status = '<span class="text-danger"><i class="far fa-times-circle"></i> Pengajuan Ditolak oleh Finance</span>';
                        $cardhead = 'card-danger';
                    }elseif($d->manager == 'Approved' && $d->finance == 'Approved'){
                        $status = '<span class="text-success"><i class="far fa-check-circle"></i> Pengajuan Disetujui oleh Finance</span>';
                        $cardhead = 'card-success';
                    }
                }else{
                    $status = '<span class="text-success"><i class="far fa-check-circle"></i> Pengajuan Telah Dibayarkan oleh Finance</span>';
                    $cardhead = 'card-success';
                }
                    
                

                $card = '<div class="card '.$cardhead.' card-outline" id='.$d->id.'>
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
                                        <h6>Diajukan oleh <b>'.$d->name.'</b> pada '.date('d-m-Y H:i', strtotime($d->created_at)).' WIB</h6>
                                        <p class="card-text"><b> Keterangan :</b> <br>'.$d->alasan_pengajuan.'</p>
                                        </div>
                                    <div class="col-md-6">
                                        <p class="text-right">Harga Satuan <b>Rp '.number_format($d->harga_satuan,0,',','.').'</b> <br> Jumlah <b>'.$d->qty.'</b></p>
                                        <h4 class="float-right">Total Rp '.number_format($d->total_harga,0,',','.').'</h4>
                                    </div>
                                </div>
                                <center>
                                    <button class="btn btn-sm btn-block btn-light" id="btn-detail" data-id="'.$d->id.'" data-toggle="modal" data-target="#detailPengajuan" data-keyboard="false" data-backdrop="static">
                                        '.$status.'
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
}
