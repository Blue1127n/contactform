<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\User;
use App\Models\Contact;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorySeeder::class); // カテゴリーを先に作成

        $users = User::factory()->count(35)->create();// 35人のユーザーを作成

        // 各ユーザーに対応するContactを1件ずつ作成（対になるように）
        foreach ($users as $user) {
            Contact::factory()->create([
                'last_name' => $user->last_name,
                'first_name' => $user->first_name,
                'email' => $user->email,
            ]);
        }
    }
}
