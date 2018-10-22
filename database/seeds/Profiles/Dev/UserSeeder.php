<?php

class UserSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @param bool $addImages
     * @return void
     */
    public function run($addImages = false)
    {
        $users = include(database_path('seeds/Data/Seed/users.php'));

        foreach ($users as $user) {
            if ($user['image']) {
                $user['avatar_id'] = $addImages ? $this->createFileFromSVG($user['image'])->id : 1;
                $user['avatar_thumbnail_id'] = $addImages ? $user['avatar_id'] : 1;
            } else {
                $user['avatar_id'] = null;
                $user['avatar_thumbnail_id'] = null;
            }
            unset($user['image']);

            $addressCount = $user['addresses'];
            unset($user['addresses']);

            $type = $user['type'];
            unset($user['type']);

            $manager = null;
            if (isset($user['manager'])) {
                $user['account_manager_id'] = user_repository()->findByEmailOrUsername($user['manager'])->id;
                unset($user['manager']);
            }

            $model = factory(\App\Models\User::class)->states($type)->create($user);

            $firstAddressId = null;
            for ($i = 0; $i < $addressCount; $i++) {
                $address = factory(\App\Models\Address::class)->create([
                    'user_id' => $model->id,
                ]);

                if ($i == 0) {
                    $firstAddressId = $address->id;
                }
            }

            $model->update([
                'address_id' => $firstAddressId,
            ]);
        }
    }
}