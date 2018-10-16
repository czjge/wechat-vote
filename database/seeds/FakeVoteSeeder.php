<?php

use Illuminate\Database\Seeder;

class FakeVoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\vote\Wxuser::class, 10)->create();
    }
}
