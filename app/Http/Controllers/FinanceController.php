<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
class FinanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function index()
    {
        //
    }

    
    public function create()
    {
        //
    }

    public function store(Request $request, string $id)
    {
        $finance = new Finance ([
            'pengajuan_finance_id' => $id,
            'finance' => 'Approved',
            'action_by' => Auth::user()->id,
            'action_at' => Carbon::now()
        ]);

        $finance->save();

        return response()->json([
            'success' => true,
            // 'message' => 'Barang Berhasil Diajukan!',
            'data' => $finance  
        ]);
    }

    
    public function reject(Request $request, string $id)
    {
        $finance = new Finance ([
            'pengajuan_finance_id' => $id,
            'finance' => 'Rejected',
            'alasan_finance' => $request->alasan_finance,
            'action_by' => Auth::user()->id,
            'action_at' => Carbon::now()
        ]);
        $finance->save();


        return response()->json([
            'success' => true,
            // 'message' => 'Barang Berhasil Diajukan!',
            'data' => $finance  
        ]);
    }

    
    public function edit(string $id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {   
        $request->validate([
            'bukti_transfer.*' => 'mimes:doc,pdf,docx,zip,jpeg,png,jpg,gif,svg',
        ]);

        $bukti= $request->file('bukti_transfer');
        $buktiNama = rand().'.'.$bukti->getClientOriginalExtension();
        $bukti->move(public_path('bukti'), $buktiNama);
      
        $bukti = Finance::where('pengajuan_finance_id',$id)->update([
            'bukti_transfer' => $buktiNama
        ]);
        // $bukti->bukti_transfer = $buktiNama;
        // $bukti->update([
        //     'bukti_transfer' => $buktiNama
        // ]);

        return response()->json(['status' => "success", 'message' => 'File Berhasil di Upload']);
    }

    
    public function destroy(string $id)
    {
        //
    }
}
