<?php

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectsDummyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Project::class, 1)->create();
    }
}
