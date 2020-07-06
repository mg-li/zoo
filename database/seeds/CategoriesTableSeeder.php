<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("insert into categories (name,created_at,updated_at) values ('レーザー',now(),now());");
        DB::insert("insert into categories (name,created_at,updated_at) values ('ボール盤',now(),now());");
        DB::insert("insert into categories (name,created_at,updated_at) values ('シャーリング',now(),now());");
        DB::insert("insert into categories (name,created_at,updated_at) values ('ラクソー',now(),now());");
        DB::insert("insert into categories (name,created_at,updated_at) values ('溶接',now(),now());");
        DB::insert("insert into categories (name,created_at,updated_at) values ('バリ取り機',now(),now());");
        DB::insert("insert into categories (name,created_at,updated_at) values ('プレス',now(),now());");
        DB::insert("insert into categories (name,created_at,updated_at) values ('ノコ盤',now(),now());");
        DB::insert("insert into categories (name,created_at,updated_at) values ('ブレーキプレス',now(),now());");
        DB::insert("insert into categories (name,created_at,updated_at) values ('旋盤',now(),now());");
        DB::insert("insert into categories (name,created_at,updated_at) values ('フライス',now(),now());");
        DB::insert("insert into categories (name,created_at,updated_at) values ('ラジアル',now(),now());");
        DB::insert("insert into categories (name,created_at,updated_at) values ('マシニング',now(),now());");
        DB::insert("insert into categories (name,created_at,updated_at) values ('その他',now(),now());");
    }
}
