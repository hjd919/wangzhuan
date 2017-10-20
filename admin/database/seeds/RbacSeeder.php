<?php

use Illuminate\Database\Seeder;

class RbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $permission = Defender::createPermission('user.create', '创建用户');
        $permission = Defender::findPermission('user.create');
        $roleAdmin  = Defender::findRole('admin');
        $roleAdmin->attachPermission($permission);

    }
}
