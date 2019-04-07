<?php

use Illuminate\Database\Seeder;
use App\User;
use App\UserType;
use App\TypeUser;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //super admin
        $user = new User([
            'name' => 'Super Admin',
            'last_name' => 'Jaol',
            'email' => 'admin@jaol.org',
            'password' => Hash::make('@jaol@2019'),
            'status' => 'approved',
        ]);
        $user->save();
        $userType = new UserType(['type_user_id' => $this->getTypeUserId('super_admin')]);
        $user->userType()->save($userType);
    }

    public function getTypeUserId($title)
    {
        $typeUser = TypeUser::where('name', '=', $title)->first();
        if (isset($typeUser)) {
            return $typeUser->id;
        }
        return TypeUser::first()->id;
    }
}
