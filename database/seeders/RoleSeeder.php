<?php

namespace Database\Seeders;

use App\Enums\RoleNames;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = [
            RoleNames::JobSeeker->value => [
                'jobseeker.all'
            ],
            RoleNames::SchoolAdmin->value => [
                'school.manage-campuses',
                'school.manage-jobs',
                'school.manage-users',
                'school.manage-applications',
                'school.manage-reviews',
                'school.manage-staffroom',
                'school.manage-billing',
                'school.view-dashboard',
            ],RoleNames::SchoolAccountManager->value => [
                'school.view-dashboard',
                'school.manage-schools-group',
            ],
            RoleNames::SchoolSupport->value => [
                'school.manage-campus-profiles',
            ],
            // Super sounds like the highest level access, so the client will be happy
            RoleNames::SuperAdmin->value => [
                'nova.view',
                'nova.manage.general',
                'nova.manage.taxonomies',
            ],
            RoleNames::Developer->value => [ // access outside of clients super administration (super SUPER user)
                'nova.view',
                'nova.manage.general',
                'nova.manage.taxonomies',
                'developer.super', // controls permissions and other breakable things
            ],
            RoleNames::TaxonomyManager->value => [
                'nova.view',
                'nova.manage.taxonomies',
            ]

            // TODO add in additional roles here - marketing user, panel user etc

        ];

        foreach ($roles as $role => $permissions ) {
            $role = Role::findOrCreate($role, 'web');

            foreach( $permissions as $permission ) {

                // Find or create permission
                $_permission = Permission::findOrCreate($permission, 'web');

                $role->givePermissionTo($_permission);
            }

        }

    }
}
