<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Room;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RoomController extends Controller
{
    public function roomsIndex(){
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $rooms = Room::orderBy('oda_adi','ASC')->paginate(10);
            $departments = Department::get();
            return view('Admin.rooms',compact('rooms','departments'));
        }
    }

    public function addNewRoom(Request $request)
    {
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $input = $request->all();
            Validator::make($input, [
                'oda_adi' => ['required', 'string', 'max:255'],
                'oda_numarasi' => ['required', 'integer'],
                'yatak_sayisi' => ['required', 'integer'],
                'bolum_id' =>['required', 'integer']
            ])->validate();
            $room = Room::create([
                'oda_adi' => $input['oda_adi'],
                'oda_numarasi' => $input['oda_numarasi'],
                'yatak_sayisi' => $input['yatak_sayisi'],
                'bolum_id' => $input['bolum_id'],
            ]);
            $room->save();
            Alert::toast( $room->oda_adi.' added successfully', 'success');
            return redirect()->back();
        }
    }
    public function deleteRoom($roomID)
    {
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $room = Room::where('id', '=', $roomID)->first();
            $room->delete();
            Alert::toast($room->oda_adi. ' deleted successfully','success');
            return redirect()->back();
        }
    }
    public function editRoom($roomID)
    {
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $room = Room::where('id','=',$roomID)->first();
            $departments = Department::get();
            return view('Admin.editRoom',compact('room','departments'));
        }
    }
    public function updateRoom(Request $request, $roomID)
    {
        $usertype = Auth::user()->user_type;
        if($usertype == '2'){
            $input = $request->all();
            $room = Room::where('id', '=', $roomID)->first();
            Validator::make($input, [
                'oda_adi' => ['required', 'string', 'max:255'],
                'oda_numarasi' => ['required', 'integer'],
                'yatak_sayisi' => ['required', 'integer'],
                'bolum_id' =>['required', 'integer']
            ])->validate();
            $room->oda_adi = $request->oda_adi;
            $room->oda_numarasi = $request->oda_numarasi;
            $room->yatak_sayisi = $request->yatak_sayisi;
            $room->bolum_id = $request->bolum_id;
            $room->save();
            Alert::toast($room->oda_adi.' updated successfully', 'success');
            return redirect()->route('admin.hospital.rooms');
        }
    }

}
