<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\RajaOngkir_Subdistrict;
use App\Member;

class MemberController extends Controller
{
    public function index(Request $request){
    	$url = $request->all();
    	$members = Member::where('active', true);
    	$totMembers = Member::where('active', true)->count();
        $forMark = [];

        //search
    	if($request->has('search-date')){
    		if(!$request->input('search-date-type') != ""){
	    		$members = $members->Where(function($q) use($request) {
		                $q->whereDate('tgl_lahir', $request->input('search-date'))
		                    ->orWhereDate('tgl_pernikahan', $request->input('search-date'));
		            });
    		}
    		else{
    			$members = $members->whereDate($request->input('search-date-type'), $request->input('search-date'));
    		}
    	}
    	// dd($forMark);
    	if($request->has('search')){
    		if($request->input('search') != ""){
	    		$members = $members->orWhere(function($q) use($request) {
		                $q->Where('name', 'like', '%' . $request->input('search') . '%')
		                    ->orWhere('phone', 'like', '%' . $request->input('search') . '%');
		            });
    		}
        }
        if($request->has('search-date') || $request->has('search')){
	        $tempMark = $members;
	        $forMark = $tempMark->pluck('id');
        }
    	$result = $members->groupBy('member_id')->paginate(10);

    	//khusus untuk ultah dan married
    	$date2morrow = date("Y-m-d", strtotime("+2 days"));
    	$date2morrow_m = date("m", strtotime("+2 days"));
    	$date2morrow_d = date("d", strtotime("+2 days"));
    	$ultah = Member::where('active', true)->whereDay('tgl_lahir', $date2morrow_d)->whereMonth('tgl_lahir', $date2morrow_m)->select('name', 'phone')->get();
    	$married = Member::where('active', true)->whereDay('tgl_pernikahan', $date2morrow_d)->whereMonth('tgl_pernikahan', $date2morrow_m)->select('name', 'phone')->get();

        return view('welcome', compact('result', 'forMark', 'url', 'ultah', 'married', 'date2morrow', 'totMembers'));
    }

    public function index_new(Request $request){
    	$url = $request->all();
    	$members = Member::where('active', true);
    	if($request->has('search')){
    		if($request->input('search') != ""){
	    		$members = $members->Where(function($q) use($request) {
		                $q->Where('name', 'like', '%' . $request->input('search') . '%')
		                    ->orWhere('phone', 'like', '%' . $request->input('search') . '%');
		            });
    		}
        }
    	$result = $members->paginate(10);
        return view('list_member', compact('result', 'url'));
    }

    public function create(){
    	//khusus untuk ultah dan married
    	$members = Member::where('active', true);
    	$ultah = $members;
    	$married = $members;
    	$date2morrow = date("Y-m-d", strtotime("+2 days"));
    	$date2morrow_m = date("m", strtotime("+2 days"));
    	$date2morrow_d = date("d", strtotime("+2 days"));
    	$ultah = $ultah->whereDay('tgl_lahir', $date2morrow_d)->whereMonth('tgl_lahir', $date2morrow_m)->select('name', 'phone')->get();
    	$married = $married->whereDay('tgl_pernikahan', $date2morrow_d)->whereMonth('tgl_pernikahan', $date2morrow_m)->select('name', 'phone')->get();

    	$subDistricts = RajaOngkir_Subdistrict::whereIn('province_id', [9,10,11])->get();
        return view('add', compact('subDistricts', 'date2morrow', 'ultah', 'married'));
    }

    public function store(Request $request){
        DB::beginTransaction();

        try{
        	if($request->input('status_perinkahan') == 'single'){
	        	$data['name'] = $request->input('single_name');
		    	$data['type'] = "single";
		    	$data['gender'] = $request->input('single_gender');
		    	$data['phone'] = $request->input('single_phone');
		    	$data['is_baptis'] = $request->input('single_baptis');
		    	$data['tempat_lahir'] = $request->input('single_tmpt_lahir');
		    	$data['tgl_lahir'] = $request->input('single_tgl_lahir');
		    	$data['district_id'] = $request->input('single_district');
		    	$data['alamat'] = $request->input('single_address');
		    	$resultData = Member::create($data);

		    	if ($request->hasFile('photo')) {
	                $path = "sources/members";
	                $file = $request->file('photo');
	                $fileName = str_replace([' ', ':'], '', Carbon::now()->toDateTimeString()) . "_members." . $file->getClientOriginalExtension();

	                // Cek ada folder tidak
	                if (!is_dir($path)) {
	                    File::makeDirectory($path, 0777, true, true);
	                }

	                //compressed img
	                $compres = Image::make($file->getRealPath());
	                $compres->resize(720, null, function ($constraint) {
	                    $constraint->aspectRatio();
	                })->save($path.'/'.$fileName);
			    	$resultData->photo = $fileName;
			    	$resultData->member_id = $resultData['id'];
			    	$resultData->update();
	            }
        	}
        	else{
				//untuk suami
		    	$data['name'] = $request->input('suami_name');
		    	$data['type'] = "suami";
		    	$data['gender'] = "pria";
		    	$data['phone'] = $request->input('suami_phone');
		    	$data['is_baptis'] = $request->input('suami_baptis');
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
		    	$data['is_baptis'] = $request->input('istri_baptis');
		    	$data['tempat_lahir'] = $request->input('istri_tmpt_lahir');
		    	$data['tgl_lahir'] = $request->input('istri_tgl_lahir');
		    	$data['member_id'] = $suami['id'];
		    	$istri = Member::create($data);

		    	//untuk anak
		    	foreach ($request->input('anak_name') as $key => $perAnak) {
		    		if($perAnak != null){
				    	$data['name'] = $perAnak;
				    	$data['type'] = "anak";

				    	$data['gender'] = "pria";
				    	if($request->has('anak_gender')){
				    		if(isset($request->input('anak_gender')[$key])){
						    	$data['gender'] = $request->input('anak_gender')[$key];
				    		}
				    	}
				    	if($request->has('anak_baptis')){
				    		if(isset($request->input('anak_baptis')[$key])){
						    	$data['is_baptis'] = $request->input('anak_baptis')[$key];
				    		}
				    	}

				    	$data['phone'] = $request->input('anak_phone')[$key];
				    	$data['tempat_lahir'] = $request->input('anak_tmpt_lahir')[$key] != null ? $request->input('anak_tmpt_lahir')[$key] : "NaN";
				    	$data['tgl_lahir'] = $request->input('anak_tgl_lahir')[$key];
				    	$data['tgl_pernikahan'] = null;
				    	$data['member_id'] = $suami['id'];
				    	$anak = Member::create($data);
		    		}
		    	}

		    	$suami->member_id = $suami['id'];
		    	if ($request->hasFile('photo')) {
	                $path = "sources/members";
	                $file = $request->file('photo');
	                $fileName = str_replace([' ', ':'], '', Carbon::now()->toDateTimeString()) . "_members." . $file->getClientOriginalExtension();

	                // Cek ada folder tidak
	                if (!is_dir($path)) {
	                    File::makeDirectory($path, 0777, true, true);
	                }

	                //compressed img
	                $compres = Image::make($file->getRealPath());
	                $compres->resize(720, null, function ($constraint) {
	                    $constraint->aspectRatio();
	                })->save($path.'/'.$fileName);
			    	$suami->photo = $fileName;
	            }
		    	$suami->update();
        	}

            DB::commit();
            return redirect()->back()->with('success', 'Status Order Berhasil Di Ubah');

        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['errors' => $ex->getMessage()]);
        }
    }

    public function store_single(Request $request){
    	DB::beginTransaction();

        try{
	    	//simpen data
	    	$data['name'] = $request->input('name');
	    	$data['type'] = "suami";
	    	$data['gender'] = "pria";
	    	$data['phone'] = $request->input('suami_phone');
	    	$data['tempat_lahir'] = $request->input('suami_tmpt_lahir');
	    	$data['tgl_lahir'] = $request->input('suami_tgl_lahir');
	    	$data['tgl_pernikahan'] = $request->input('tgl_pernikahan');
	    	$data['district_id'] = $request->input('district');
	    	$data['alamat'] = $request->input('address');
	    	$suami = Member::create($data);

	    	if ($request->hasFile('photo')) {
                $path = "sources/members";
                $file = $request->file('photo');
                $fileName = str_replace([' ', ':'], '', Carbon::now()->toDateTimeString()) . "_members." . $file->getClientOriginalExtension();

                // Cek ada folder tidak
                if (!is_dir($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                //compressed img
                $compres = Image::make($file->getRealPath());
                $compres->resize(720, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path.'/'.$fileName);
		    	$suami->photo = $fileName;
            }
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
    	// dd($request->all());
    	$dataNya = Member::find($request->input('id'));
        $parentNya = $dataNya->parent_member;

    	if($dataNya){
    		DB::beginTransaction();
	        try{
	        	if($parentNya['type'] == 'single'){
		        	$data['name'] = $request->input('single_name');
			    	$data['type'] = "single";
			    	$data['gender'] = $request->input('single_gender');
			    	$data['phone'] = $request->input('single_phone');
			    	$data['is_baptis'] = $request->input('single_baptis');
			    	$data['tempat_lahir'] = $request->input('single_tmpt_lahir');
			    	$data['tgl_lahir'] = $request->input('single_tgl_lahir');
			    	$data['district_id'] = $request->input('single_district');
			    	$data['alamat'] = $request->input('single_address');

			    	if ($request->hasFile('photo')) {
		                $path = "sources/members";
		                $file = $request->file('photo');
		                $fileName = str_replace([' ', ':'], '', Carbon::now()->toDateTimeString()) . "_members." . $file->getClientOriginalExtension();

		                // Cek ada folder tidak
		                if (!is_dir($path)) {
		                    File::makeDirectory($path, 0777, true, true);
		                }

		                // Hapus Img Lama Jika Update Image
	                    if (isset($parentNya['photo'])) {
	                        if (File::exists("sources/members/" . $parentNya['photo'])) {
	                            File::delete("sources/members/" . $parentNya['photo']);
	                        }
	                    }

		                //compressed img
		                $compres = Image::make($file->getRealPath());
		                $compres->resize(720, null, function ($constraint) {
		                    $constraint->aspectRatio();
		                })->save($path.'/'.$fileName);
				    	$data['photo'] = $fileName;
		            }

			    	$parentNya->update($data);
	        	}
	        	else{
			        $childNya = $parentNya->child_member;

	        		//untuk suami
			    	$data['name'] = $request->input('suami_name');
			    	$data['type'] = "suami";
			    	$data['gender'] = "pria";
			    	$data['phone'] = $request->input('suami_phone');
			    	$data['is_baptis'] = $request->input('suami_baptis');
			    	$data['tempat_lahir'] = $request->input('suami_tmpt_lahir');
			    	$data['tgl_lahir'] = $request->input('suami_tgl_lahir');
			    	$data['tgl_pernikahan'] = $request->input('tgl_pernikahan');
			    	$data['district_id'] = $request->input('district');
			    	$data['alamat'] = $request->input('address');

			    	if ($request->hasFile('photo')) {
		                $path = "sources/members";
		                $file = $request->file('photo');
		                $fileName = str_replace([' ', ':'], '', Carbon::now()->toDateTimeString()) . "_members." . $file->getClientOriginalExtension();

		                // Cek ada folder tidak
		                if (!is_dir($path)) {
		                    File::makeDirectory($path, 0777, true, true);
		                }

		                // Hapus Img Lama Jika Update Image
	                    if (isset($parentNya['photo'])) {
	                        if (File::exists("sources/members/" . $parentNya['photo'])) {
	                            File::delete("sources/members/" . $parentNya['photo']);
	                        }
	                    }

		                //compressed img
		                $compres = Image::make($file->getRealPath());
		                $compres->resize(720, null, function ($constraint) {
		                    $constraint->aspectRatio();
		                })->save($path.'/'.$fileName);
				    	$data['photo'] = $fileName;
		            }

			    	$parentNya->update($data);
			    	$data['photo'] = null;

			    	//untuk istri
			    	$istri = $childNya->where('type', 'istri')->first();
			    	$data['name'] = $request->input('istri_name');
			    	$data['type'] = "istri";
			    	$data['gender'] = "wanita";
			    	$data['phone'] = $request->input('istri_phone');
			    	$data['is_baptis'] = $request->input('istri_baptis');
			    	$data['tempat_lahir'] = $request->input('istri_tmpt_lahir');
			    	$data['tgl_lahir'] = $request->input('istri_tgl_lahir');
			    	$data['member_id'] = $parentNya['id'];
			    	$istri->update($data);

			    	//untuk anak
			    	foreach ($request->input('anak_name') as $key => $perAnak) {
			    		if($perAnak != null){
			    			$data['name'] = $perAnak;
					    	$data['type'] = "anak";

					    	$data['gender'] = "pria";
					    	if($request->has('anak_gender')){
					    		if(isset($request->input('anak_gender')[$key])){
							    	$data['gender'] = $request->input('anak_gender')[$key];
					    		}
					    	}
					    	if($request->has('anak_baptis')){
					    		if(isset($request->input('anak_baptis')[$key])){
							    	$data['is_baptis'] = $request->input('anak_baptis')[$key];
					    		}
					    	}

					    	$data['phone'] = $request->input('anak_phone')[$key];
					    	$data['tempat_lahir'] = $request->input('anak_tmpt_lahir')[$key] != null ? $request->input('anak_tmpt_lahir')[$key] : "NaN";;
					    	$data['tgl_lahir'] = $request->input('anak_tgl_lahir')[$key];
					    	$data['tgl_pernikahan'] = null;
					    	$data['member_id'] = $parentNya['id'];

			    			if(isset($childNya->where('type', 'anak')[$key+1])){
			    				$anak = $childNya->where('type', 'anak')[$key+1];
						    	$anak->update($data);
			    			}
			    			else{
						    	$anak = Member::create($data);
			    			}
			    			
			    		}
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
