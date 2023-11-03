<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\User;
use Faker\Factory as Faker;

class ContactsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $contactGroups = ContactGroup::all();
        $users = User::all();

        foreach (range(1, 20) as $index) {
            Contact::create([
                'business_name' => $faker->company,
                'contact_name' => $faker->name,
                'email' => $faker->email,
                'phone_number' => $faker->phoneNumber,
                'contact_group' => $contactGroups->random()->id,
                'assigned_to' => $users->random()->id,
                'address' => $faker->address,
            ]);
        }
    }
}

