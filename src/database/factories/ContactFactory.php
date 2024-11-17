<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;
use App\Models\Category;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Contact::class;

    public function definition()
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id, // カテゴリIDをランダムに取得
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'gender' => rand(1, 3), // 男性(1), 女性(2), その他(3)
            'email' => $this->faker->unique()->safeEmail,
            'tel' => $this->faker->numerify('###-####-####'), // 電話番号のダミーデータ
            'address' => $this->faker->address,
            'building' => $this->faker->secondaryAddress,
            'detail' => $this->faker->realText(100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
