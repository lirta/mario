<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Models\Image;
use App\Models\Device;
use App\Models\Userip;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Stevebauman\Location\Facades\Location;
use Jenssegers\Agent\Facades\Agent;

class ImageController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function count()
	{
		// Menghitung jumlah gambar yang sudah disimpan
		$count = Image::count();
		return $count;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		// Mengambil gambar dari POST request
		$imageData = $request->input('image');

		// Membuat model Image dan menyimpan ke database
		$image = new Image();
		$image->image = $this->saveImage($imageData);
		$image->save();

		return 'Image saved to database and file system';
	}

	private function saveImage($imageData)
	{
		// Dekode data URL dan menyimpan gambar ke file system
		$image = str_replace('data:image/png;base64,', '', $imageData);
		$image = str_replace(' ', '+', $image);
		$imageName = time() . '_' . mt_rand() . '.png';
		// dd($imageName);
		Storage::disk('public')->put('images/' . $imageName, base64_decode($image));
		// Storage::move(\base_path() . "/public/assets/images/spam", $imageName);
		return $imageName;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreImageRequest  $request
	 * @return \Illuminate\Http\Response
	 */

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Image  $image
	 * @return \Illuminate\Http\Response
	 */
	public function show(Image $image)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Image  $image
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Image $image)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateImageRequest  $request
	 * @param  \App\Models\Image  $image
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateImageRequest $request, Image $image)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Image  $image
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Image $image)
	{
		//
	}
}
