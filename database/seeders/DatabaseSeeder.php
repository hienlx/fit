<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $modules = [
            'user', 'role', 'permision', 'profile',
            'facult', 'academic', 'class',
            'stage', 'require', 'score'
        ];
        $permissions = [
            'manage-user', 'show-user', 'create-user', 'edit-user', 'delete-user',
            'manage-role', 'show-role', 'create-role', 'edit-role', 'delete-role',
            'manage-profile', 'show-profile', 'create-profile', 'edit-profile', 'delete-profile',
            'manage-facult', 'show-facult', 'create-facult', 'edit-facult', 'delete-facult',
            'manage-academic', 'show-academic', 'create-academic', 'edit-academic', 'delete-academic',
            'manage-class', 'show-class', 'create-class', 'edit-class', 'delete-class',
            'manage-stage', 'show-stage', 'create-stage', 'edit-stage', 'delete-stage',
            'manage-require', 'show-require', 'create-require', 'edit-require', 'delete-require',
            'manage-score', 'show-score', 'create-score', 'edit-score', 'delete-score'
        ];
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }
        $role = Role::create([
            'name' => 'admin',
            'desc' => 'Quản trị viên'
        ]);
        $role->givePermissionTo(Permission::all()->pluck('id'));

        $user = User::create([
            'name' => 'Lê Xuân Hiền',
            'username' => 'hienlx',
            'email' => 'lexuanhien@hnue.edu.vn',
            'password' => Hash::make('Abc123@')
        ]);
        $user->assignRole($role->id);
    }
}
