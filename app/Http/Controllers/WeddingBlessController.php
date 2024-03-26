<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\RajaOngkir_Subdistrict;
use App\WeddingBless;
use App\Pastor;

class WeddingBlessController extends Controller
{
    public function index(){
		$weddingBlesses = WeddingBless::where('active', true)->orderBy('datetime_bless', 'desc')->paginate(10);
		return view('list_wedding_bless', compact('weddingBlesses'));
	}

    public function create(){
    	$pastors = Pastor::where('active', true)->get();
    	$subDistricts = RajaOngkir_Subdistrict::whereIn('province_id', [9,10,11])->get();
        return view('add_wedding_bless', compact('subDistricts', 'pastors'));
    }

    public function store(Request $request){
        DB::beginTransaction();

        try {
        	$data = $request->all();
        	$data['datetime_bless'] = date("Y-m-d H:i:s", strtotime($data['datetime_bless']));
        	$weddingBless = WeddingBless::create($data);

            DB::commit();
            return redirect()->back()->with('success', 'Data pemberkatan nikah berhasil diinput.');

        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['errors' => $ex->getMessage()]);
        }
    }

    public function edit($id){
    	$weddingBlessNya = WeddingBless::find($id);
    	$pastors = Pastor::where('active', true)->get();
    	$subDistricts = RajaOngkir_Subdistrict::whereIn('province_id', [9,10,11])->get();
    	return view('update_wedding_bless', compact('weddingBlessNya', 'pastors', 'subDistricts'));
    }

    public function update(Request $request){
    	$weddingBlessNya = WeddingBless::find($request->id);

    	try {
        	$data = $request->all();
        	$data['datetime_bless'] = date("Y-m-d H:i:s", strtotime($data['datetime_bless']));
        	$weddingBlessNya->update($data);

            DB::commit();
            return redirect()->back()->with('success', 'Data pemberkatan nikah berhasil diubah.');

        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['errors' => $ex->getMessage()]);
        }
    }

    public function destroy($id){
    	$weddingBlessNya = WeddingBless::find($id);
    	$weddingBlessNya->active = false;
    	$weddingBlessNya->save();
        return redirect()->back()->with('success', 'Data pemberkatan nikah Berhasil Di Hapus');
    }
}
