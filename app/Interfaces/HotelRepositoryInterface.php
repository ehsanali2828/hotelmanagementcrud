<?php

namespace App\Interfaces;

interface HotelRepositoryInterface
{
    public function store($requestData);
    public function getByID($id);
    public function update($id,$requestData);
    public function destroy($id);
    public function getAll($perPage, $page);
}