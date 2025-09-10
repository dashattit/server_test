<?php

namespace Controller;

use Model\Authors;
use Src\Validator\Validator;
use Src\View;
use Src\Request;

class AuthorsController
{
    public function index(): string
    {
        $authors = Authors::all();
        return (new View())->render('site.authors', ['authors' => $authors]);
    }

    public function create(Request $request): string
    {
        $errors = [];
        if ($request->method === 'POST') {
            $request->set('full_name', implode(' ', [
                $request->get('last_name'),
                $request->get('first_name'),
                $request->get('patronym')
            ]));

            $validator = new Validator($request->all(), [
                'first_name' => ['required'],
                'last_name' => ['required'],
                'full_name' => ['fullname:authors,full_name'],
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально',
                'fullname' => 'Автор с таким ФИО уже существует',
            ]);

            if($validator->fails()){
                $errors = $validator->errors();
                return new View('site.create_author',
                    ['errors' => $errors, 'old' => $request->all()]);
            }

            if (Authors::create($request->all())) {
                app()->route->redirect('/authors');
            }
        }
        return (new View())->render('site.create_author');
    }

    public function delete(Request $request): void
    {
        if (Authors::where('id', $request->id)->delete()) {
            app()->route->redirect('/authors');
        }
    }
}