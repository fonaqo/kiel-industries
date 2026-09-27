<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            CmsSettingSeeder::class,
            CmsPageSeeder::class,
            CmsBlockSeeder::class,
            ExpertisePoleSeeder::class,
            ProductSeeder::class,
            PostSeeder::class,
            TipVideoSeeder::class,
            CompanyDocumentSeeder::class,
            ProductReviewSeeder::class,
        ]);
    }
}
