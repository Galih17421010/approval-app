<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function upload(Request $request, $id){

        $request->validate([
            'bukti' => 'required|mimes:jpg,jpeg,png,pdf,|max:2048',
        ]);
                
        $buktiName=rand().'.'.$request->file('bukti')->extension();
        $request->file('bukti')->move(public_path('bukti'), $buktiName);

        $finance = Finance::where('pengajuan_finance_id','=',$id)->update([
            'bukti_transfer' => $buktiName,
        ]);      

        return response()->json([
            'success'=> true,
            'message' => 'Bukti berhasil di Upload!',
            'data'=>$finance
        ]);
    }
    
    public function destroy(string $id)
    {
        //
    }
}
