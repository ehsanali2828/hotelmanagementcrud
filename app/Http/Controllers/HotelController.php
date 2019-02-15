<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\HotelRequest;
use App\Hotel;
use App\Image;
use App\Interfaces\AmenityRepositoryInterface;
use App\Interfaces\HotelRepositoryInterface;
use App\Interfaces\ImageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Session;

class HotelController extends Controller
{
    protected $hotel_repository;
    protected $amenities_repository;
    protected $image_repository;

    public function __construct(HotelRepositoryInterface $hotel_list_repository, AmenityRepositoryInterface $amenities, ImageRepositoryInterface $images) {
        $this->hotel_repository = $hotel_list_repository;
        $this->amenities_repository = $amenities;
        $this->image_repository = $images;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $hotels = $this->hotel_repository->getAll($request->get('per_page'), $request->get('page'));
        return response()->json($hotels);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('hotels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(HotelRequest $request)
    {
        $responseData = $this->hotel_repository->store($request->all());
        if($request->hasFile('images')) {
            $imageTitleArray = explode(',',$request->get('title'));
            foreach($request->file('images') as $index=>$image){
                $imageName = time() . "_" . $image->getClientOriginalName();
                $path = public_path() .Image::IMAGE_PATH;
                if (!is_dir($path)) {
                    File::makeDirectory($path, 0777, true);
                    chmod($path, 0777);
                }
                if ($image->move($path, $imageName)) {
                    $this->image_repository->store($responseData->id, array('name' => $imageName, 'path' => Image::IMAGE_PATH, 'title'=>$imageTitleArray[$index]));
                }
            }
        }
        return response()->json(['status'=>true,'message'=>'Hotel added successfully!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        try{
            $hotel_info =  $this->hotel_repository->getByID($id);
            if(!empty($hotel_info))
            {
                return response()->json($hotel_info);
            }
            else{
                return response()->json(['status'=>false,'message'=>"Invalid Request Id! No Hotel with that ID found in the database!"]);
            }

        } catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $hotel_info = $this->hotel_repository->getByID($id);
        return response()->json($hotel_info);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, HotelRequest $request)
    {
        $requestData = $request->all();
        if($this->hotel_repository->update($id,$requestData))
        {
            if($request->hasFile('images')) {
                $imageTitleArray = explode(',',$request->get('title'));
                foreach($request->file('images') as $index => $image){
                    $imageName = time() . "_" . $image->getClientOriginalName();
                    $path = public_path() .Image::IMAGE_PATH;
                    if (!is_dir($path)) {
                        File::makeDirectory($path, 0777, true);
                        chmod($path, 0777);
                    }
                    if ($image->move($path, $imageName)) {
                        $this->image_repository->store($id, array('name' => $imageName, 'path' => Image::IMAGE_PATH, 'title'=>$imageTitleArray[$index]));
                    }
                }
            }
            if($request->has('image_id')){
                $this->image_repository->updateImageTitle($requestData['image_id'], $requestData['image_title']);
            }
            return response()->json(["status"=>true,"message"=> "Hotel Information updated successfully!!"]);
        }
        return response()->json(["status"=>false,"message"=> "Something went wrong"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $hotel_info = $this->hotel_repository->getByID($id);
        if($this->hotel_repository->destroy($id))
        {
            foreach($hotel_info['images'] as $imageArray){
                $this->image_repository->destroy($imageArray->id);
                File::delete(public_path().Image::IMAGE_PATH.'/'.$imageArray->name);
            }
            return response()->json(["status"=>true,"message"=> "Hotel Information Deleted Successfully."]);
        }
        return response()->json(["status"=>false,"message"=> "Invalid Deletion Request!"]);
    }

    public function getAmenities()
    {
        $amenities = $this->amenities_repository->getAll();
        return response()->json($amenities);

    }
    public function deleteImage($id)
    {
        $image = $this->image_repository->find($id);
        if($this->image_repository->destroy($id))
        {
            File::delete(public_path().Image::IMAGE_PATH.'/'.$image->name);
            return response()->json(["status"=>true,"message"=> "Hotel Image Deleted Successfully."]);
        }
        return response()->json(["status"=>true,"message"=> "Invalid Deletion Request!"]);
    }
}