<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('patients')->insert(
            [
                [
                    'last_name' => 'Doe',
                    'first_name' => 'John',
                    'middle_name' => 'Michael',
                    'suffix_name' => 'Jr.',
                    'birth_date' => '1990-05-15',
                    'address' => '123 Main St, City'
                ],
                [
                    'last_name' => 'Smith',
                    'first_name' => 'Jane',
                    'middle_name' => 'Elizabeth',
                    'suffix_name' => '',
                    'birth_date' => '1985-08-20',
                    'address' => '456 Elm St, Town'
                ],
                [
                    'last_name' => 'Johnson',
                    'first_name' => 'Robert',
                    'middle_name' => '',
                    'suffix_name' => 'Sr.',
                    'birth_date' => '1978-03-10',
                    'address' => '789 Oak St, Village'
                ],
                [
                    'last_name' => 'Williams',
                    'first_name' => 'Emily',
                    'middle_name' => 'Anne',
                    'suffix_name' => '',
                    'birth_date' => '1995-11-25',
                    'address' => '101 Pine St, Hamlet'
                ],
                [
                    'last_name' => 'Brown',
                    'first_name' => 'David',
                    'middle_name' => 'Allen',
                    'suffix_name' => '',
                    'birth_date' => '1980-07-12',
                    'address' => '222 Cedar St, Borough'
                ]
            ]
        );
    }
}
