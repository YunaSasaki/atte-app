<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stamp;
use App\Models\Rest;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // \App\Models\User::factory(10)->create();

    // \App\Models\User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);

    $this->call(UserSeeder::class);
    Stamp::factory(100)
    ->has(Rest::factory(2)
      ->state(function (array $attributes, Stamp $stamp) {
      return ['stamp_id' => $stamp->id];
      })
    )
    ->create();
  }
}
