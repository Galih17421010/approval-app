<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function index()
    {
        //
    }

    
    public function store(string $id)
    {
        $manager = new Manager ([
            'pengajuan_id' => $id,
            'manager' => 'Approved',
            'action_by' => Auth::user()->id,
            'action_at' => Carbon::now()
        ]);
        $manager->timestamps = false;
        $manager->save();


        return response()->json([
            'success' => true,
            // 'message' => 'Barang Berhasil Diajukan!',
            'data' => $manager  
        ]);
    }

    
    public function reject(Request $request, string $id)
    {
        $manager = new Manager ([
            'pengajuan_id' => $id,
            'manager' => 'Rejected',
            'alasan_manager' => $request->alasan_manager,
            'action_by' => Auth::user()->id,
            'action_at' => Carbon::now()
        ]);
        $manager->timestamps = false;
        $manager->save();


        return response()->json([
            'success' => true,
            // 'message' => 'Barang Berhasil Diajukan!',
            'data' => $manager  
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
