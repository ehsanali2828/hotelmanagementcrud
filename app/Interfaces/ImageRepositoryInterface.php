<?php
/**
 * Created by PhpStorm.
 * User: anil-kumar
 * Date: 27/1/17
 * Time: 3:03 PM
 */

namespace App\Interfaces;


interface ImageRepositoryInterface
{
    public function find($id);

    public function store($hotel_id, $requestData);

    public function destroy($id);

    public function updateImageTitle($imageId, $title);

}