<?php

namespace App\Database\Seeds;

use App\Models\CommentModel;
use CodeIgniter\Database\Seeder;

class CommentsSeeder extends Seeder
{
    public function run()
    {
        $model = new CommentModel();
        $faker = \Faker\Factory::create('ru_RU');

        for ($i = 0; $i < 20; $i++) {
            $data = [
                'name' => $faker->email(),
                'text' => $faker->realText(200),
                'date' => $faker->dateTimeThisYear()->format('Y-m-d H:i')
            ];

            $model->save($data);
        }


    }
}
