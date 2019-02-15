<?php
/**
 * Created by PhpStorm.
 * User: anil-kumar
 * Date: 27/1/17
 * Time: 3:02 PM
 */

namespace App\Repositories;


use App\Hotel;
use App\Image;
use App\Interfaces\ImageRepositoryInterface;

class ImageRepository implements ImageRepositoryInterface
{
    public function find($id){
        return Image::find($id);
    }

    public function store($hotel_id, $requestData)
    {
        $hotel = Hotel::find($hotel_id);
        $image = new Image();
        $image->name = $requestData['name'];
        $image->path = $requestData['path'];
        $image->title = $requestData['title'];
        $image->save();
        $hotel->images()->attach($image->id);
    }

    public function updateImageTitle($imageId, $title)
    {
        $imageIdArray = explode(',',$imageId);
        $imageTitleArray = explode(',',$title);
        foreach($imageIdArray as $key=>$id){
            Image::where('id',$id)->update(['title'=>$imageTitleArray[$key]]);
        }

    }

    public function destroy($id)
    {
        return Image::destroy($id);
    }

}