<?php

namespace Database\Seeders;

use App\Services\TeknisiCatalogService;
use Illuminate\Database\Seeder;

class TeknisiCatalogSeeder extends Seeder
{
    public function run(): void
    {
        TeknisiCatalogService::seed();
    }
}
