<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Pool;
use App\Models\User;
use App\Models\Vote;
use App\Models\Group;
use App\Models\Option;
use App\Models\Category;
use App\Models\Groupapplication;
use App\Models\Groupuser;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Category::create(['category_name'=>"Siyaset"]);
        Category::create(['category_name'=>"Politika"]);
        Category::create(['category_name'=>"Spor"]);
        Category::create(['category_name'=>"Gündem"]);
        Category::create(['category_name'=>"Sanat"]);
        Category::create(['category_name'=>"Bilim"]);
        Category::create(['category_name'=>"Bilişim"]);
        Category::create(['category_name'=>"Programcılık"]);
        Category::create(['category_name'=>"Yemek"]);
        Category::create(['category_name'=>"Din"]);
        Category::create(['category_name'=>"Oyun"]);
        Category::create(['category_name'=>"Film"]);
        Category::create(['category_name'=>"Dizi"]);
        Category::create(['category_name'=>"Kitap"]);
        Category::create(['category_name'=>"Felsefe"]);
        Category::create(['category_name'=>"Tarih"]);
        Category::create(['category_name'=>"Eğitim"]);
        Category::create(['category_name'=>"Evcil Hayvan"]);
        Category::create(['category_name'=>"Diğer"]);

    }
}
