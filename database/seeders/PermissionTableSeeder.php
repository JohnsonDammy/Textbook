<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
  
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [            
            'user-list', 'user-create', 'user-edit', 'user-delete',
            'district-list', 'district-create', 'district-edit', 'district-delete',
            'school-list', 'school-create', 'school-edit', 'school-delete',
            'category-list', 'category-create', 'category-edit', 'category-delete',
            'item-list', 'item-create', 'item-edit', 'item-delete',
            'collection-request-list', 'collection-request-create', 'collection-request-edit', 'collection-request-delete',
            'collect-furniture-list', 'collect-furniture-create', 'repair-furniture-create', 'deliver-furniture-create',
            'manage-request-list', 'manage-request-create', 'manage-request-edit', 'manage-request-delete', 
            'report-list',
            'cmc-list', 'cmc-create', 'cmc-edit', 'cmc-delete',
            'circuit-list', 'circuit-create', 'circuit-edit', 'circuit-delete',
            'subplace-list', 'subplace-create', 'subplace-edit', 'subplace-delete',
            'dashboard-list',
            'repair-furniture-list', 'deliver-furniture-list'
        ];
     
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}