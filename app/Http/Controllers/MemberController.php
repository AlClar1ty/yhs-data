<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\RajaOngkir_Subdistrict;
use App\Member;

class MemberController extends Controller
{
    public function index(Request $request){
    	$url = $request->all();
    	$members = Member::where('active', true);
        $forMark = [];
    	if($request->has('search')){
    		if($request->input('search') != ""){
	    		$members = $members->Where(function($q) use($request) {
		                $q->Where('name', 'like', '%' . $request->input('search') . '%')
		                    ->orWhere('phone', 'like', '%' . $request->input('search') . '%');
		            });
		        $forMark = $members;
		        $forMark = $forMark->pluck('id');
    		}
        }
    	$result = $members->groupBy('member_id')->paginate(10);
        return view('welcome', compact('result', 'forMark', 'url'));
    }

    public function create(){
    	$subDistricts = RajaOngkir_Subdistrict::whereIn('province_id', [9,10,11])->get();
        return view('add', compact('subDistricts'));
    }

    public function store(Request $request){
        DB::beginTransaction();

        try{
	    	//untuk suami
	    	$data['name'] = $request->input('suami_name');
	    	$data['type'] = "suami";
	    	$data['gender'] = "pria";
	    	$data['phone'] = $request->input('suami_phone');
	    	$data['tempat_lahir'] = $request->input('suami_tmpt_lahir');
	    	$data['tgl_lahir'] = $request->input('suami_tgl_lahir');
	    	$data['tgl_pernikahan'] = $request->input('tgl_pernikahan');
	    	$data['district_id'] = $request->input('district');
	    	$data['alamat'] = $request->input('address');
	    	$suami = Member::create($data);

	    	//untuk istri
	    	$data['name'] = $request->input('istri_name');
	    	$data['type'] = "istri";
	    	$data['gender'] = "wanita";
	    	$data['phone'] = $request->input('istri_phone');
	    	$data['tempat_lahir'] = $request->input('istri_tmpt_lahir');
	    	$data['tgl_lahir'] = $request->input('istri_tgl_lahir');
	    	$data['member_id'] = $suami['id'];
	    	$istri = Member::create($data);

	    	//untuk anak
	    	foreach ($request->input('anak_name') as $key => $perAnak) {
	    		if($perAnak != null){
			    	$data['name'] = $perAnak;
			    	$data['type'] = "anak";
			    	$data['gender'] = "wanita";
			    	$data['phone'] = $request->input('anak_phone')[$key];
			    	$data['tempat_lahir'] = $request->input('anak_tmpt_lahir')[$key];
			    	$data['tgl_lahir'] = $request->input('anak_tgl_lahir')[$key];
			    	$data['tgl_pernikahan'] = null;
			    	$data['member_id'] = $suami['id'];
			    	$anak = Member::create($data);
	    		}
	    	}

	    	$suami->member_id = $suami['id'];
	    	$suami->update();

            DB::commit();
            return redirect()->back()->with('success', 'Status Order Berhasil Di Ubah');

        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['errors' => $ex->getMessage()]);
        }
    }

    public function edit($id){
    	$subDistricts = RajaOngkir_Subdistrict::whereIn('province_id', [9,10,11])->get();
    	$dataNya = Member::find($id);
        return view('update', compact('subDistricts', 'dataNya'));
    }

    public function update(Request $request){
    	$dataNya = Member::find($request->input('id'));
        $parentNya = $dataNya->parent_member;
        $childNya = $parentNya->child_member;

    	if($dataNya){
    		DB::beginTransaction();
	        try{
		    	//untuk suami
		    	$data['name'] = $request->input('suami_name');
		    	$data['type'] = "suami";
		    	$data['gender'] = "pria";
		    	$data['phone'] = $request->input('suami_phone');
		    	$data['tempat_lahir'] = $request->input('suami_tmpt_lahir');
		    	$data['tgl_lahir'] = $request->input('suami_tgl_lahir');
		    	$data['tgl_pernikahan'] = $request->input('tgl_pernikahan');
		    	$data['district_id'] = $request->input('district');
		    	$data['alamat'] = $request->input('address');
		    	$parentNya->update($data);

		    	//untuk istri
		    	$istri = $childNya->where('type', 'istri')->first();
		    	$data['name'] = $request->input('istri_name');
		    	$data['type'] = "istri";
		    	$data['gender'] = "wanita";
		    	$data['phone'] = $request->input('istri_phone');
		    	$data['tempat_lahir'] = $request->input('istri_tmpt_lahir');
		    	$data['tgl_lahir'] = $request->input('istri_tgl_lahir');
		    	$data['member_id'] = $parentNya['id'];
		    	$istri->update($data);
		    	//untuk anak
		    	foreach ($request->input('anak_name') as $key => $perAnak) {
		    		if($perAnak != null){
		    			$anak = $childNya->where('type', 'anak')[$key+1];
				    	$data['name'] = $perAnak;
				    	$data['type'] = "anak";
				    	$data['gender'] = "wanita";
				    	$data['phone'] = $request->input('anak_phone')[$key];
				    	$data['tempat_lahir'] = $request->input('anak_tmpt_lahir')[$key];
				    	$data['tgl_lahir'] = $request->input('anak_tgl_lahir')[$key];
				    	$data['tgl_pernikahan'] = null;
				    	$data['member_id'] = $parentNya['id'];
				    	$anak->update($data);
		    		}
		    	}

	            DB::commit();
	            return redirect()->back()->with('success', 'Data Berhasil Di Ubah');

	        } catch (\Exception $ex) {
	            DB::rollback();
	            return response()->json(['errors' => $ex->getMessage()]);
	        }
    	}
    	else{
    		return redirect()->route('index');
    	}
        
    }

    public function destroy(Request $request){
    	$parent = Member::find($request->input('parent_id'));
    	foreach ($parent->child_member as $childNya) {
	    	$childNya->active = false;
	    	$childNya->save();
    	}
    	$parent->active = false;
    	$parent->save();
        return redirect()->back()->with('success', 'Data Berhasil Di Hapus');
    }
}
