<?php

namespace Database\Seeders;

use App\Models\MenuResource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = MenuResource::create(['name' => 'Categorias']);
        $category->permissions()->create(['name' => 'visualizar_categorias']);
        $category->permissions()->create(['name' => 'criar_categorias']);
        $category->permissions()->create(['name' => 'editar_categorias']);
        $category->permissions()->create(['name' => 'deletar_categorias']);

        $company = MenuResource::create(['name' => 'Empresas']);
        $company->permissions()->create(['name' => 'visualizar_empresas']);
        $company->permissions()->create(['name' => 'criar_empresas']);
        $company->permissions()->create(['name' => 'editar_empresas']);
        $company->permissions()->create(['name' => 'deletar_empresas']);
    }
}
