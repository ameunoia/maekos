<?php

namespace App\Http\Controllers;

use App\Enum\RoomStatusEnum;
use App\Models\Room;
use App\Models\RoomImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{


  public function addRoom(Request $request)
  {
    $validated = $request->validate([
      'no' => 'required',
      'price' => 'required',
      'images' => 'required'
    ]);
    try {
      DB::beginTransaction();
      $room = Room::create([
        'no' => $request->no,
        'is_booked' => false,
        'price' => $request->price
      ]);

      foreach ($request->file('images') as $imageFile) {
        $path = $imageFile->store('/images/resource', ['disk' => 'my_files']);
        $image = RoomImage::create([
          'url' => $path,
          'room_no' => $room->no,
        ]);
      }
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json($e->getMessage(), 200);
    }
    DB::commit();
    return response()->json([$room], 200);
  }

  public function editRoom(Request $request, $room_no)
  {
    Room::where('no', $room_no)->update(["price" => $request->price]);

    // return response()->json($request, 200);
    return redirect()->back()->with("message", "Harga Berhasil dirubah");
  }

  public function deleteRoomImage($id)
  {
    $image = RoomImage::where("id", $id)->first();

    // $result = Storage::delete($image->url);
    if (!Storage::disk('my_files')->exists($image->url)) {
      return response()->json("Failed", 404);
    }
    Storage::disk('my_files')->delete($image->url);
    $image->delete();
    // return response()->json("Success", 200);
    return redirect()->back()->with("message", "Berhasil dihapus");
    // return response()->json($result, 200);
  }

  public function addImage(Request $request, $roomNo)
  {
    $imageFile = $request->file('image');
    $path = $imageFile->store('/images/resource', ['disk' => 'my_files']);
    $image = RoomImage::create([
      'url' => $path,
      'room_no' => $roomNo,
    ]);
  }

  public function deleteRoom($roomNo)
  {
    $room = Room::where("no", $roomNo)->delete();
    $images = RoomImage::where("room_no", $roomNo)->select("url")->get();

    foreach ($images as $image) {
      if (!Storage::disk('my_files')->exists($image->url)) {
        return response()->json("Failed", 404);
      }
      Storage::disk('my_files')->delete($image->url);
    }
    RoomImage::where("room_no", $roomNo)->delete();
  }
}
