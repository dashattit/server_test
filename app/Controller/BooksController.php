<?php

namespace Controller;

use Model\Books;
use Model\Authors;
use Src\Validator\Validator;
use Src\View;
use Src\Request;

class BooksController
{
    public function index(Request $request): string
    {
        $user = app()->auth->user();

        $query = Books::with('author');

        $search = $request->get('search_field');
        $sortByPopularity = $request->get('search_checkbox');

        if ($search) {
            $query->whereHas('deliveries', function ($q) use ($search) {
                $q->whereNull('date_return')
                ->whereHas('reader', function ($q2) use ($search) {
                    $q2->whereRaw("CONCAT(last_name, ' ', first_name, ' ', patronym) LIKE ?", ["%{$search}%"]);
                });
            });
        }
        $query->withCount('deliveries');
        if ($sortByPopularity) {
            $query->orderBy('deliveries_count', 'desc');
        }

        $books = $query->get();

        return (new View())->render('site.books', [
            'books' => $books,
            'user' => $user,
            'request' => $request,
            'search_checkbox' => $sortByPopularity,
        ]);
    }


    public function create(Request $request): string
    {
        $errors = [];
        $authors = Authors::all();
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'author_id' => ['required'],
                'title' => ['required'],
                'year_publication' => ['required', 'numeric'],
                'price' => ['required', 'numeric']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально',
                'numeric' => 'Поле :field должно быть числом'
            ]);

            if($validator->fails()){
                $errors = $validator->errors();
                return new View('site.create_book',
                    ['errors' => $errors, 'authors' => $authors, 'old' => $request->all()]);
            }

            if (Books::create($request->all())) {
                app()->route->redirect('/books');
            }
        }
        return (new View())->render('site.create_book', ['authors' => $authors]);
    }
}