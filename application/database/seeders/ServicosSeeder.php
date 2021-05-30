<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('servicos')->insert([
            'nome' => 'Pintura Externa',
            'descricao' => ''
        ]);
        
        DB::table('servicos')->insert([
           'nome' => 'Pintura Interna',
           'descricao' => '' 
        ]);

        DB::table('servicos')->insert([
            'nome' => 'Revestimento',
            'descricao' => ''
        ]);

        DB::table('servicos')->insert([
            'nome' => 'Acabamento',
            'descricao' => ''
        ]);
        
        DB::table('servicos')->insert([
            'nome' => 'Piso e Azulejo',
            'descricao' => ''
        ]);
        
        DB::table('servicos')->insert([
            'nome' => 'Impermeabilização',
            'descricao' => ''
        ]);
    }
}
