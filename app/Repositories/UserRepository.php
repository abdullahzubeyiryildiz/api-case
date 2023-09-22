<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function register($data)
    {
        return $this->model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function login($data)
    {
        if (auth()->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return auth()->user();
        }

        return null;
    }

    public function find($userId)
    {
        return $this->model->find($userId);
    }

    public function user()
    {
        return auth()->user();
    }

    public function updateUserImage($userId, $image)
    {
        $user = $this->find($userId);

        if ($user) {
            removeImage($user->image);

            $folderName = 'img/user/';
            $fileName = 'profile';
            $imageUrl = uploadImage($image, $fileName, $folderName);

            $user->image = $imageUrl;
            $user->save();

            return $user;
        }

        return null;
    }
}
