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
                ],
                [
                    'last_name' => 'Garcia',
                    'first_name' => 'Sophia',
                    'middle_name' => 'Isabel',
                    'suffix_name' => '',
                    'birth_date' => '1985-09-22',
                    'address' => '789 Elm St, Villagetown'
                ],
                [
                    'last_name' => 'Martinez',
                    'first_name' => 'Daniel',
                    'middle_name' => 'Miguel',
                    'suffix_name' => '',
                    'birth_date' => '1975-03-18',
                    'address' => '1010 Pine Ln, Hamlet'
                ],
                [
                    'last_name' => 'Jackson',
                    'first_name' => 'Olivia',
                    'middle_name' => 'Grace',
                    'suffix_name' => '',
                    'birth_date' => '1988-11-05',
                    'address' => '1313 Cedar Rd, Borough'
                ],
                [
                    'last_name' => 'Taylor',
                    'first_name' => 'William',
                    'middle_name' => 'Henry',
                    'suffix_name' => '',
                    'birth_date' => '1992-06-20',
                    'address' => '1515 Oak Dr, Townsville'
                ],
                [
                    'last_name' => 'Anderson',
                    'first_name' => 'Emma',
                    'middle_name' => 'Nicole',
                    'suffix_name' => '',
                    'birth_date' => '1983-01-10',
                    'address' => '1717 Maple Ct, Cityville'
                ],
                [
                    'last_name' => 'Thomas',
                    'first_name' => 'Matthew',
                    'middle_name' => '',
                    'suffix_name' => '',
                    'birth_date' => '1970-08-27',
                    'address' => '1919 Elm Ave, Villagetown'
                ],
                [
                    'last_name' => 'Hernandez',
                    'first_name' => 'Ava',
                    'middle_name' => 'Sofia',
                    'suffix_name' => 'III',
                    'birth_date' => '1982-05-14',
                    'address' => '2121 Pine Blvd, Hamlet'
                ],
                [
                    'last_name' => 'Walker',
                    'first_name' => 'Alexander',
                    'middle_name' => 'Joseph',
                    'suffix_name' => '',
                    'birth_date' => '1997-02-08',
                    'address' => '2323 Cedar St, Borough'
                ]
            ]
        );
    }
}
