<?php

namespace Database\Seeders;

use App\Models\CampBenefit;
use Illuminate\Database\Seeder;

class CampBenefitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $campBenefits = [
            [
                'camp_id' => 1,
                'name' => 'ProTech Kit',
            ],
            [
                'camp_id' => 1,
                'name' => '1 on 1 Mentoring Program',
            ],
            [
                'camp_id' => 1,
                'name' => 'Final Project Presentation',
            ],
            [
                'camp_id' => 1,
                'name' => 'Offline Course Videos',
            ],
            [
                'camp_id' => 1,
                'name' => 'Future Job Connections',
            ],
            [
                'camp_id' => 1,
                'name' => 'Premium Design Kit',
            ],
            [
                'camp_id' => 1,
                'name' => 'Website Builder',
            ],
            [
                'camp_id' => 2,
                'name' => '1 on 1 Mentoring Program',
            ],
            [
                'camp_id' => 2,
                'name' => 'Final Project Certificate',
            ],
            [
                'camp_id' => 2,
                'name' => 'Offline Course Videos',
            ],
        ];

        CampBenefit::insert($campBenefits);
    }
}
