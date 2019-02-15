<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmenitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amenities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('is_active');
            $table->timestamps();
        });
        DB::table('amenities')->insert([[
                'name' => 'Sauna',
                'is_active' => '1'
            ],[
                'name' => 'Fireplace or fire pit',
                'is_active' => '1'
            ],[
                'name' => 'Outdoor Kitchen',
                'is_active' => '1'
            ],[
                'name' => 'Tennis Courts',
                'is_active' => '1'
            ],[
                'name' => 'Trees and Landscaping',
                'is_active' => '1'
            ],[
                'name' => 'Sun Room',
                'is_active' => '1'
            ],[
                'name' => 'Family Room',
                'is_active' => '1'
            ],[
                'name' => 'Concrete Flooring',
                'is_active' => '1'
            ]]
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
