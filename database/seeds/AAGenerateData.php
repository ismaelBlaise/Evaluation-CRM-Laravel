<?php

use Illuminate\Database\Seeder;

class AAGenerateData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call("AClientSeed", false, ['count' => 50]);
    }
}
