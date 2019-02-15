<?php

namespace App\Repositories;

use App\Image;
use App\Interfaces\AmenityRepositoryInterface;
use App\Interfaces\HotelRepositoryInterface;
use App\Hotel;


class HotelRepository implements HotelRepositoryInterface
{
    public function getAll($perPage, $page) {
        return Hotel::with('amenities')->paginate($perPage, ['*'], 'page', $page);
    }

    public function store($requestData){
        $hotel = Hotel::create($requestData);
        if($requestData['amenities'] != '') {
            $selectedAminity = explode(',', $requestData['amenities']);
            foreach ($selectedAminity as $index => $amenity_id) {
                $hotel->amenities()->attach($amenity_id);
            }
        }
        return $hotel;
    }

    public function getByID($id){
        return Hotel::with('amenities','images')->findOrFail($id);
    }


    public function update($id,$requestData){
        $hotelslist = $this->getByID($id);
        $hotel = $hotelslist->update($requestData);
        $hotelslist->amenities()->detach();
        if($requestData['amenities'] != '') {
            $selectedAminity = explode(',', $requestData['amenities']);
            foreach ($selectedAminity as $index => $amenity_id) {
                $hotelslist->amenities()->attach($amenity_id);
            }
        }
        return $hotel;

    }

    public function destroy($id){
        return Hotel::destroy($id);
    }

}
