<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi"; // password

        User::create([
            'id' => '1',
            'name' => '佐藤',
            'email' => 'satou@email.com',
            'password' => $password,
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'id' => '2',
            'name' => '鈴木',
            'email' => 'suzuki@email.com',
            'password' => $password,
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'id' => '3',
            'name' => '高橋',
            'email' => 'takahashi@email.com',
            'password' => $password,
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'id' => '4',
            'name' => '田中',
            'email' => 'tanaka@email.com',
            'password' => $password,
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'id' => '5',
            'name' => '伊藤',
            'email' => 'itou@email.com',
            'password' => $password,
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'id' => '6',
            'name' => '渡辺',
            'email' => 'watanabe@email.com',
            'password' => $password,
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'id' => '7',
            'name' => '山本',
            'email' => 'yamamoto@email.com',
            'password' => $password,
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'id' => '8',
            'name' => '中村',
            'email' => 'nakamura@email.com',
            'password' => $password,
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'id' => '9',
            'name' => '小林',
            'email' => 'kobayashi@email.com',
            'password' => $password,
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'id' => '10',
            'name' => '加藤',
            'email' => 'katou@email.com',
            'password' => $password,
            'remember_token' => Str::random(10),
        ]);
    }
}
