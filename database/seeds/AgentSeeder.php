<?php

use Illuminate\Database\Seeder;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(\App\Agent::class, 10)->create([
            'position' => 'Agent'
        ]);

        factory(\App\Agent::class, 4)->create([
            'position' => 'Supervisor'
        ]);

        factory(\App\Agent::class, 1)->create([
            'position' => 'Manager'
        ]);
    }
}
