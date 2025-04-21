<?php

namespace Database\Seeders;

use App\Models\Dia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        try {
            DB::beginTransaction();
            Dia::create([
                'nombre' => 'Lunes'
            ]);
            Dia::create([
                'nombre' => 'Martes'
            ]);
            Dia::create([
                'nombre' => 'Miercoles'
            ]);
            Dia::create([
                'nombre' => 'Jueves'
            ]);
            Dia::create([
                'nombre' => 'Viernes'
            ]);
            Dia::create([
                'nombre' => 'Sábado'
            ]);
            Dia::create([
                'nombre' => 'Domingo'
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::debug($th->getMessage());
        }
    }
}
