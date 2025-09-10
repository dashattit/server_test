<?php

namespace Controller;

use Model\LibrarianRoles;
use Model\Librarians;
use Src\Validator\Validator;
use Src\View;
use Src\Request;
use Src\Auth\Auth;

class AuthController
{

    public function signup(Request $request): string
    {
        $errors = [];
        if ($request->method === 'POST') {
        $query = LibrarianRoles::query();
        $roleLibrarian = $query->where('role_name', 'Библиотекарь')->first();

        $requestData = $request->all();
        $requestData['role_id'] = $roleLibrarian->id;
            $validator = new Validator($requestData, [
                'first_name' => ['required'],
                'last_name' => ['required'],
                'login' => ['required', 'unique:librarians,login'],
                'password' => ['required', 'password'],
                'role_id' => ['required'],
                'avatar' => ['avatar']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально',
                'avatar' => 'Размер аватара должен быть не более 2мб, допустимые форматы: jpg, jpeg, png, gif',
                'password' => 'Пароль должен быть длиной не менее 8 символов и содержать как минимум одну цифру, одну заглавную и одну строчную букву'
            ]);

            if($validator->fails()){
                $errors = $validator->errors();
                return new View('site.signup',
                    ['errors' => $errors]);
            }

            if ($request->avatar) {
                $user = new Librarians();
                $avatarPath = $user->uploadAvatar($request->file('avatar'));

                if ($avatarPath) {
                    $requestData['avatar'] = $avatarPath;
                }
            }

            if (Librarians::create($requestData)) {
                app()->route->redirect('/login');
            }
        }
        return new View('site.signup');
    }

    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.login');
        }

        if (Auth::attempt($request->all())) {
            app()->route->redirect('/');
        }

        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/login');
    }
}