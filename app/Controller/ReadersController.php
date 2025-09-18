<?php

namespace Controller;

use Model\Readers;
use Src\Validator\Validator;
use Src\View;
use Src\Request;

class ReadersController
{
    public function index(Request $request): string
    {
        $search = $request->get('search_field');

        if ($search) {
            $readers = Readers::whereHas('deliveries.book', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })->get();
        } else {
            $readers = Readers::all();
        }


        return (new View())->render('site.readers', ['readers' => $readers, 'request' => $request]);
    }

    public function create(Request $request)
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
                'full_name' => ['fullname:readers,full_name'],
                'address' => ['required'],
                'telephone' => ['required', 'telephone'],
            ], [
                'required' => 'Поле :field пусто',
                'fullname' => 'Читатель с таким ФИО уже существует',
                'telephone' => 'Некорректный номер телефона'
            ]);

            if($validator->fails()){
                $errors = $validator->errors();
                return new View('site.create_reader', [
                    'errors' => $errors,
                    'old' => $request->all()
                ]);
            }

            if (Readers::create($request->all())) {
                app()->route->redirect('/readers');
                return ''; // Добавляем return после редиректа
            }
        }

        return new View('site.create_reader');
    }

    public function delete(Request $request): void
    {
        if (Readers::where('id', $request->id)->delete()) {
            app()->route->redirect('/readers');
        }
    }
}