<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('admins')->insert([
      'name' => 'Super Admin',
      'email' => 'admin@example.com',
      'email_verified_at' => now(),
      'password' => Hash::make('password123'), // mot de passe sécurisé
      'created_at' => now(),
      'updated_at' => now(),
    ]);
  }
}
