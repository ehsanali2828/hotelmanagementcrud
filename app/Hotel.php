<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hotels';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'address1', 'address2','city','state','zip','country'];

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class,'hotel_amenity');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class,'hotel_images');
    }

}