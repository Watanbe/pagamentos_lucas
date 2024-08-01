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
        $estadosCivis = [
            'Solteiro',
            'Casado',
            'Divorciado',
            'Viúvo',
            'Separado',
            'União Estável'
        ];

        foreach ($estadosCivis as $estadoCivil) {
            DB::table("marital_status") -> insert([
                'name' => $estadoCivil,
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
