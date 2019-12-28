<?php

use App\User;
use Illuminate\Database\Seeder;

class SystemUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        factory(User::class)->create([
            'name' => config('app.sysUser_name'),
            'password' => bcrypt(config('app.sysUser_password'))
        ]);

        factory(User::class)->create([
            'name' => 'manager',
            'password' => bcrypt('manager123')
        ]);
    }
}
