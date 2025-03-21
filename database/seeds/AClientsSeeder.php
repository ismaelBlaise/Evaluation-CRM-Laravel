<?php

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\User;
use App\Models\Industry;

class AClientsSeeder extends Seeder
{
    
    public function run()
    {
        
        $users = User::all(); 
        $industries = Industry::all();  
        
        $faker = \Faker\Factory::create();
       
            Client::create([
                'external_id' => $faker->unique()->word,
                'address' => $faker->address,
                'zipcode' => $faker->postcode,
                'city' => $faker->city,
                'company_name' => $faker->company,
                'vat' => $faker->vat,
                'company_type' => $faker->word,
                'client_number' => $faker->randomNumber(9, true),
                'user_id' => $users->random()->id,  
                'industry_id' => $industries->random()->id,  
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        
    }
}
