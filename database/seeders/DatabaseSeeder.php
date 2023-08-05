<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Advancement;
use App\Models\Avenant;
use App\Models\Contract;
use App\Models\Employee;
use Database\Factories\EmployeeFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory()->create();
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        
        $advancement = Advancement::factory(50)->create();
        // Employee::hasAttached($advancement->random(1));

        $avenant = Avenant::factory(50)->create();
        $contract = Contract::factory(50)
            // ->hasAttached($avenant->random(1))
            ->create();
        
        Employee::factory(50)
            // ->hasAttached($contract->random(1))
            ->create();
        

    }
}
