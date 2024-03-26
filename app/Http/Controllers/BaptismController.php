<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\RajaOngkir_Subdistrict;
use App\Baptism;
use App\Pastor;
class BaptismController extends Controller
{
    public function index(){
		$baptisms = Baptism::where('active', true)->orderBy('baptism_date', 'desc')->paginate(10);
		return view('list_baptism', compact('baptisms'));
	}

    public function create(){
    	$pastors = Pastor::where('active', true)->get();
    	$subDistricts = RajaOngkir_Subdistrict::whereIn('province_id', [9,10,11])->get();
        return view('add_baptism', compact('subDistricts', 'pastors'));
    }

    public function store(Request $request){
        DB::beginTransaction();

        try {
        	$data = $request->all();
        	$baptism = Baptism::create($data);

            DB::commit();
            return redirect()->back()->with('success', 'Data baptis berhasil diinput.');

        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['errors' => $ex->getMessage()]);
        }
    }

    public function edit($id){
    	$baptismNya = Baptism::find($id);
    	$pastors = Pastor::where('active', true)->get();
    	$subDistricts = RajaOngkir_Subdistrict::whereIn('province_id', [9,10,11])->get();
    	return view('update_baptism', compact('baptismNya', 'pastors', 'subDistricts'));
    }

    public function update(Request $request){
    	$baptismNya = Baptism::find($request->id);

    	try {
        	$data = $request->all();
        	$baptismNya->update($data);

            DB::commit();
            return redirect()->back()->with('success', 'Data baptis berhasil diubah.');

        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['errors' => $ex->getMessage()]);
        }
    }

    public function destroy($id){
    	$baptismNya = Baptism::find($id);
    	$baptismNya->active = false;
    	$baptismNya->save();
        return redirect()->back()->with('success', 'Data baptis Berhasil Di Hapus');
    }
}
