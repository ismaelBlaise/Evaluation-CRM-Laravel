<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Ramsey\Uuid\Uuid;
use App\Models\User;
use App\Models\Industry;

class AClientSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param int $count Nombre de clients à générer (par défaut 20)
     * @return void
     */
    public function run($count = 10)
    {
        $faker = Faker::create();

        // Récupérer tous les IDs des utilisateurs existants
        $userIds = User::pluck('id')->toArray();
        // Récupérer tous les IDs des industries existantes
        $industryIds = Industry::pluck('id')->toArray();

        if (empty($userIds) || empty($industryIds)) {
            $this->command->info("❌ Aucun utilisateur ou industrie trouvé, veuillez en créer d'abord.");
            return;
        }

        for ($i = 0; $i < $count; $i++) {
            DB::table('clients')->insert([
                'external_id'   => Uuid::uuid4()->toString(),
                'address'       => $faker->streetAddress,
                'zipcode'       => $faker->postcode,
                'city'          => $faker->city,
                'company_name'  => $faker->company,
                'vat'           => $faker->optional()->vat,
                'company_type'  => $faker->randomElement(['SARL', 'SAS', 'EURL', 'Auto-Entrepreneur']),
                'client_number' => $faker->randomNumber(8, true),
                'user_id'       => $faker->randomElement($userIds),
                'industry_id'   => $faker->randomElement($industryIds), // Choisir une industrie existante
                'deleted_at'    => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

        $this->command->info("✅ $count clients ont été créés avec succès !");
    }
}
