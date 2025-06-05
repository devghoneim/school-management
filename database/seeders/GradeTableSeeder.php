<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $arx = [
            'الابتدائيه',
            'الاعداديه',
            'الثانويه'
        ];
        $enx = [
            'primary',
            'Preparatory',
            'high'
        ];

        foreach($arx as $i => $ar)
        Grade::create([
            'name'=> ['ar'=>$ar ,'en'=>$enx[$i] ]
        ]);

      
    }
}
