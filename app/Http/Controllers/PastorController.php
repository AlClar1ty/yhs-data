<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\RajaOngkir_Subdistrict;
use App\Pastor;

class PastorController extends Controller
{
	public function index(){
		$pastors = Pastor::where('active', true)->orderBy('name', 'asc')->paginate(10);
		return view('list_pastor', compact('pastors'));
	}

    public function create(){
        return view('add_pastor');
    }

    public function store(Request $request){
        DB::beginTransaction();

        try {
        	$data = $request->all();
        	$pastor = Pastor::create($data);

            DB::commit();
            return redirect()->back()->with('success', 'Pastor berhasil diinput.');

        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['errors' => $ex->getMessage()]);
        }
    }

    public function edit($id){
    	$pastorNya = Pastor::find($id);
    	return view('update_pastor', compact('pastorNya'));
    }

    public function update(Request $request){
    	$pastorNya = Pastor::find($request->id);

    	try {
        	$data = $request->all();
        	$pastorNya->update($data);

            DB::commit();
            return redirect()->back()->with('success', 'Pastor berhasil diubah.');

        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['errors' => $ex->getMessage()]);
        }
    }

    public function destroy($id){
    	$pastorNya = Pastor::find($id);
    	$pastorNya->active = false;
    	$pastorNya->save();
        return redirect()->back()->with('success', 'Pastor Berhasil Di Hapus');
    }
}
