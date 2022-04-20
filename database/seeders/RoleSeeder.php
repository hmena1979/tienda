<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'ADMINISTRADOR']);
        $role2 = Role::create(['name' => 'VENDEDOR']);

        Permission::create(['name' => 'admin.inicio','description' =>'Puede ver el Inicio'])->assignRole($role1);

        Permission::create(['name' => 'admin.clientes.index','description' =>'Puede ver listado Proveedor|Cliente'])->assignRole($role1);
        Permission::create(['name' => 'admin.clientes.create','description' =>'Puede agregar Proveedor|Cliente'])->assignRole($role1);
        Permission::create(['name' => 'admin.clientes.edit','description' =>'Puede editar Proveedor|Cliente'])->assignRole($role1);
        Permission::create(['name' => 'admin.clientes.destroy','description' =>'Puede eliminar Proveedor|Cliente'])->assignRole($role1);

        Permission::create(['name' => 'admin.compras','description' =>'Puede realizar Compras'])->assignRole($role1);

        Permission::create(['name' => 'admin.ventas','description' =>'Puede realizar Ventas'])->assignRole($role1);

        Permission::create(['name' => 'admin.tablas','description' =>'Puede ver tablas del sistema'])->assignRole($role1);
        Permission::create(['name' => 'admin.usuarios.index','description' =>'Puede ver listado Usuarios'])->assignRole($role1);
        Permission::create(['name' => 'admin.usuarios.create','description' =>'Puede agregar Usuarios'])->assignRole($role1);
        Permission::create(['name' => 'admin.usuarios.edit','description' =>'Puede editar Usuarios'])->assignRole($role1);
        Permission::create(['name' => 'admin.usuarios.destroy','description' =>'Puede eliminar Usuarios'])->assignRole($role1);

        Permission::create(['name' => 'admin.util','description' =>'Puede ver Utilitarios'])->assignRole($role1);
    }
}
