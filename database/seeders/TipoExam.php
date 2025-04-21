<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\TipoExamen;

class TipoExam extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();
            TipoExamen::create([
                'nombre' => 'Cardiovasculares'
            ]);
            TipoExamen::create([
                'nombre' => 'Metabolica'
            ]);
            TipoExamen::create([
                'nombre' => 'Gastrointestinales'
            ]);
            TipoExamen::create([
                'nombre' => 'Renales'
            ]);
            TipoExamen::create([
                'nombre' => 'Respiratorias'
            ]);
            TipoExamen::create([
                'nombre' => 'Endocrinos'
            ]);
           
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::debug($th->getMessage());
        }
    }
}
