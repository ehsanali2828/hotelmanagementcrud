<?php
/**
 * Created by PhpStorm.
 * User: anil-kumar
 * Date: 27/1/17
 * Time: 3:02 PM
 */

namespace App\Repositories;


use App\Amenity;
use App\Interfaces\AmenityRepositoryInterface;

class AmenityRepository implements AmenityRepositoryInterface
{

    public function getAll()
    {
        return Amenity::all();

    }

    public function storeHotelAmenity($hotel_id, $amenity_id)
    {

    }

}