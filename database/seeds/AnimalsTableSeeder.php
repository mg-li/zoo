<?php

use Illuminate\Database\Seeder;
use App\Animal;


class AnimalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Animal;
        $model->name = "ゴリ吉";
        $model->gender = "オス";
        $model->age = 3;
        $model->save();

        $model = new Animal;
        $model->name = "クマ五郎";
        $model->gender = "オス";
        $model->age = 5;
        $model->save();

        $model = new Animal;
        $model->name = "白鳥玲子";
        $model->gender = "メス";
        $model->age = 4;
        $model->save();
    }
}
