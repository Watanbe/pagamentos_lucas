<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $statesJson = database_path('data/Estados.json');
        $citiesJson = database_path('data/Cidades.json');

        $states = json_decode(file_get_contents($statesJson), true);
        $cities = json_decode(file_get_contents($citiesJson), true);

        foreach ($states as $state) {
            DB::table('states')->insert([
                'id' => $state['ID'],
                'name' => $state['Sigla'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($cities as $city) {
            DB::table('cities')->insert([
                'id' => $city['ID'],
                'name' => $city['Nome'],
                'state_id' => $city['Estado'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
