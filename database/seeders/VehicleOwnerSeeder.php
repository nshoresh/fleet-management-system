<?php

namespace Database\Seeders;

use App\Models\VehicleOwner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class VehicleOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $ownerTypes = DB::table('vehicle_owner_types')->pluck('id')->toArray();

        // Create 50 vehicle owners with various owner types
        $vehicleOwners = [];

        // Individual owners (more common)
        for ($i = 0; $i < 2; $i++) {
            $vehicleOwners[] = [
                'name' => $faker->name(),
                'contact_number' => $faker->phoneNumber(),
                'email' => $faker->unique()->safeEmail(),
                'address' => $faker->address(),
                'vehicle_owner_type_id' => 1, // Individual
                'business_name' => $faker->company(),
                'business_phone' => $faker->phoneNumber(),
                'business_email' => $faker->unique()->companyEmail(),
                'business_address' => $faker->address(),
                'business_registration_number' => $faker->unique()->numerify('BRN-#####'),
                'business_type' => $faker->randomElement(['LLC', 'Corporation', 'Partnership']),
                'business_tax_id' => $faker->unique()->numerify('TAX-#####'),
                'business_website' => $faker->url(),
                'business_logo' => $faker->imageUrl(200, 200, 'business', true, 'Logo'),
                'business_contact_person' => $faker->name(),
                'business_contact_number' => $faker->phoneNumber(),
                'id_number' => $faker->unique()->numerify('ID-#####'),
                'id_type' => $faker->randomElement(['National ID', 'Passport', 'Driver\'s License']),
                'position' => $faker->jobTitle(),
                'business_registration_date' => $faker->date(),
                'is_information_verified' => $faker->boolean(),
                'status' => $faker->randomElement(['active', 'inactive', 'pending']),
                'is_documents_verified' => $faker->boolean(),
                //'vehicle_owner_type_id' => $ownerTypes['Individual'],
                'created_at' => now(),
                'updated_at' => now(),

            ];
        }

        // Company owners
        for ($i = 0; $i < 2; $i++) {
            $vehicleOwners[] = [
                'name' => $faker->name(),
                'contact_number' => $faker->phoneNumber(),
                'email' => $faker->unique()->safeEmail(),
                'address' => $faker->address(),

                'vehicle_owner_type_id' => 1, // Individual
                'business_name' => $faker->company(),
                'business_phone' => $faker->phoneNumber(),
                'business_email' => $faker->unique()->companyEmail(),
                'business_address' => $faker->address(),
                'business_registration_number' => $faker->unique()->numerify('BRN-#####'),
                'business_type' => $faker->randomElement(['LLC', 'Corporation', 'Partnership']),
                'business_tax_id' => $faker->unique()->numerify('TAX-#####'),
                'business_website' => $faker->url(),
                'business_logo' => $faker->imageUrl(200, 200, 'business', true, 'Logo'),
                'business_contact_person' => $faker->name(),
                'business_contact_number' => $faker->phoneNumber(),
                'id_number' => $faker->unique()->numerify('ID-#####'),
                'id_type' => $faker->randomElement(['National ID', 'Passport', 'Driver\'s License']),
                'position' => $faker->jobTitle(),
                'business_registration_date' => $faker->date(),
                'is_information_verified' => $faker->boolean(),
                'status' => $faker->randomElement(['active', 'inactive', 'pending']),
                'is_documents_verified' => $faker->boolean(),
                'vehicle_owner_type_id' => 2, // Company
                //'vehicle_owner_type_id' => $ownerTypes['Company'],
                'created_at' => now(),
                'updated_at' => now(),

            ];
        }

        // Government owners
        for ($i = 0; $i < 2; $i++) {
            $vehicleOwners[] = [
                'name' => $faker->name(),
                'contact_number' => $faker->phoneNumber(),
                'email' => $faker->unique()->safeEmail(),
                'address' => $faker->address(),
                'vehicle_owner_type_id' => 1, // Individual
                'business_name' => $faker->company(),
                'business_phone' => $faker->phoneNumber(),
                'business_email' => $faker->unique()->companyEmail(),
                'business_address' => $faker->address(),
                'business_registration_number' => $faker->unique()->numerify('BRN-#####'),
                'business_type' => $faker->randomElement(['LLC', 'Corporation', 'Partnership']),
                'business_tax_id' => $faker->unique()->numerify('TAX-#####'),
                'business_website' => $faker->url(),
                'business_logo' => $faker->imageUrl(200, 200, 'business', true, 'Logo'),
                'business_contact_person' => $faker->name(),
                'business_contact_number' => $faker->phoneNumber(),
                'id_number' => $faker->unique()->numerify('ID-#####'),
                'id_type' => $faker->randomElement(['National ID', 'Passport', 'Driver\'s License']),
                'position' => $faker->jobTitle(),
                'business_registration_date' => $faker->date(),
                'is_information_verified' => $faker->boolean(),
                'status' => $faker->randomElement(['active', 'inactive', 'pending']),
                'is_documents_verified' => $faker->boolean(),
                'vehicle_owner_type_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),

            ];
        }

        // Military owners
        for ($i = 0; $i < 2; $i++) {
            $vehicleOwners[] = [
                'name' => $faker->name(),
                'contact_number' => $faker->phoneNumber(),
                'email' => $faker->unique()->safeEmail(),
                'address' => $faker->address(),
                'vehicle_owner_type_id' => 1, // Individual
                'business_name' => $faker->company(),
                'business_phone' => $faker->phoneNumber(),
                'business_email' => $faker->unique()->companyEmail(),
                'business_address' => $faker->address(),
                'business_registration_number' => $faker->unique()->numerify('BRN-#####'),
                'business_type' => $faker->randomElement(['LLC', 'Corporation', 'Partnership']),
                'business_tax_id' => $faker->unique()->numerify('TAX-#####'),
                'business_website' => $faker->url(),
                'business_logo' => $faker->imageUrl(200, 200, 'business', true, 'Logo'),
                'business_contact_person' => $faker->name(),
                'business_contact_number' => $faker->phoneNumber(),
                'id_number' => $faker->unique()->numerify('ID-#####'),
                'id_type' => $faker->randomElement(['National ID', 'Passport', 'Driver\'s License']),
                'position' => $faker->jobTitle(),
                'business_registration_date' => $faker->date(),
                'is_information_verified' => $faker->boolean(),
                'status' => $faker->randomElement(['active', 'inactive', 'pending']),
                'is_documents_verified' => $faker->boolean(),
                'vehicle_owner_type_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),

            ];
        }

        // Public Transport owners
        for ($i = 0; $i < 2; $i++) {
            $vehicleOwners[] = [
                'name' => $faker->name(),
                'contact_number' => $faker->phoneNumber(),
                'email' => $faker->unique()->safeEmail(),
                'address' => $faker->address(),
                'vehicle_owner_type_id' => 1, // Individual
                'business_name' => $faker->company(),
                'business_phone' => $faker->phoneNumber(),
                'business_email' => $faker->unique()->companyEmail(),
                'business_address' => $faker->address(),
                'business_registration_number' => $faker->unique()->numerify('BRN-#####'),
                'business_type' => $faker->randomElement(['LLC', 'Corporation', 'Partnership']),
                'business_tax_id' => $faker->unique()->numerify('TAX-#####'),
                'business_website' => $faker->url(),
                'business_logo' => $faker->imageUrl(200, 200, 'business', true, 'Logo'),
                'business_contact_person' => $faker->name(),
                'business_contact_number' => $faker->phoneNumber(),
                'id_number' => $faker->unique()->numerify('ID-#####'),
                'id_type' => $faker->randomElement(['National ID', 'Passport', 'Driver\'s License']),
                'position' => $faker->jobTitle(),
                'business_registration_date' => $faker->date(),
                'is_information_verified' => $faker->boolean(),
                'status' => $faker->randomElement(['active', 'inactive', 'pending']),
                'is_documents_verified' => $faker->boolean(),
                'vehicle_owner_type_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),

            ];
        }

        // Create a few owners for each remaining type
        for ($typeId = 6; $typeId <= 15; $typeId++) {
            for ($i = 0; $i < 2; $i++) {
                // For business-related owner types, use company names
                if (in_array($typeId, [6, 7, 8, 11, 12, 13])) {
                    $name = $faker->company();
                    $email = $faker->unique()->companyEmail();
                }
                // For educational institutions
                elseif ($typeId == 14) {
                    $name = $faker->lastName() . ' ' . $faker->randomElement(['University', 'College', 'School', 'Academy']);
                    $email = $faker->unique()->safeEmail();
                }
                // For non-profits
                elseif ($typeId == 15) {
                    $name = $faker->randomElement(['Care', 'Hope', 'Future', 'Global', 'Aid']) . ' ' .
                        $faker->randomElement(['Foundation', 'Initiative', 'Relief', 'Support', 'Network']);
                    $email = $faker->unique()->safeEmail();
                }
                // For others, use individual names
                else {
                    $name = $faker->name();
                    $email = $faker->unique()->safeEmail();
                }

                $vehicleOwners[] = [
                    'name' => $name,
                    'contact_number' => $faker->phoneNumber(),
                    'email' => $email,
                    'address' => $faker->address(),
                    'vehicle_owner_type_id' => $typeId,
                    'created_at' => now(),
                    'updated_at' => now(),

                ];
            }
        }

        // Add some with null email and contact number to test nullable fields
        $vehicleOwners[] = [
            'name' => $faker->name(),
            'contact_number' => null,
            'email' => null,
            'address' => $faker->address(),
            'vehicle_owner_type_id' => 1, // Individual
            'created_at' => now(),
            'updated_at' => now(),

        ];

        // DB::table('vehicle_owners')->insert($vehicleOwners);
        foreach ($vehicleOwners as $vehicleOwnerData) {
            VehicleOwner::create($vehicleOwnerData);
        }
    }
}
