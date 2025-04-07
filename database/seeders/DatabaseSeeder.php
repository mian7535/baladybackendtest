<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'bankId' => Str::random(7),
            'Name' => 'Ishaq Khan',
            'email' => Str::random(10).'@gmail.com',
            'birthDate' => '2000-01-01',
            'gender' => 'male',
            'identityNumber' => Str::random(7),
            'mobileNumber' => Str::random(11),
            'observationType' => "sub",
            'subMunicipalityId' => Str::random(7),
            'subMunicipalityName' => 'Ishaq Khan',
            'MunicipalityId' => 'Ishaq Khan',
            'MunicipalityName' => 'Ishaq Khan',
        ]);
    }
}
