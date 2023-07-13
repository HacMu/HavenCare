<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Department;


class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            [
                'bolum_adi' => 'Anesthetics',
                'bolum_adres' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ],
            [
                'bolum_adi' => 'Anesthetics',
                'bolum_adres' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ],
            [
                'bolum_adi' => 'Cardiology',
                'bolum_adres' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ],
            [
                'bolum_adi' => 'Chaplaincy',
                'bolum_adres' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ],
            [
                'bolum_adi' => 'Diagnostic Imaging',
                'bolum_adres' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ],
            [
                'bolum_adi' => 'Elderly Services',
                'bolum_adres' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ],
            [
                'bolum_adi' => 'Finance Department',
                'bolum_adres' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ],
        ];
        DB::table('departments')->insert($departments);
    }
}
