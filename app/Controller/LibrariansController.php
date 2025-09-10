<?php

namespace Controller;

use Model\Books;
use Model\Authors;
use Model\LibrarianRoles;
use Model\Librarians;
use Src\Validator\Validator;
use Src\View;
use Src\Request;

class LibrariansController
{
    public function index(Request $request): string
    {
        $user = app()->auth->user();
        $userRole = $user->role->role_name;
        $librarians = Librarians::all();
        return (new View())->render('site.librarians', ['librarians' => $librarians, 'userRole' => $userRole]);
    }

    public function create(Request $request): string
    {
        $errors = [];
        $roles = LibrarianRoles::all();
        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'first_name' => ['required'],
                'last_name' => ['required'],
                'login' => ['required', 'unique:librarians,login'],
                'password' => ['required', 'password'],
                'role_id' => ['required'],
                'avatar' => ['avatar:librarians, avatar']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально',
                'avatar' => 'Размер аватара должен быть не более 2мб, допустимые форматы: jpg, jpeg, png, gif',
                'password' => 'Пароль должен быть длиной не менее 8 символов и содержать как минимум одну цифру, одну заглавную и одну строчную букву'
            ]);

            if($validator->fails()){
                $errors = $validator->errors();
                return new View('site.create_librarian',
                    ['errors' => $errors, 'roles' => $roles, 'old' => $request->all()]);
            }

            $requestData = $request->all();

            if ($request->avatar) {
                $user = new Librarians();
                $avatarPath = $user->uploadAvatar($request->file('avatar'));

                if ($avatarPath) {
                    $requestData['avatar'] = $avatarPath;
                }
            }

            if (Librarians::create($requestData)) {
                app()->route->redirect('/librarians');
            }
        }
        return (new View())->render('site.create_librarian', ['roles' => $roles]);
    }
}