<?php

namespace Controller;

use Illuminate\Support\Facades\Date;
use Model\BookDeliveries;
use Model\Books;
use Model\Librarians;
use Model\Readers;
use Src\Validator\Validator;
use Src\View;
use Src\Request;
use Src\Auth\Auth;

class BookDeliveriesController
{
    public function issue(Request $request): string
    {
        $librarians = Librarians::all();
        $readers = Readers::all();
        $freeBooks = Books::whereNotIn('id', function ($query) {
            $query->select('book_id')
                ->from('book_deliveries')
                ->whereNull('date_return');
        })->get();

        if ($request->method === 'POST') {
            $data = $request->all();
            $data['book_id'] = $data['book_id'] ?? null;
            $data['ticket_number'] = $data['ticket_number'] ?? null;
            $data['library_id'] = app()->auth::user()->id;
            $data['date_extradition'] = date('Y-m-d H:i:s');

            $validator = new Validator($data, [
                'library_id' => ['required'],
                'book_id' => ['required'],
                'ticket_number' => ['required'],
                'date_extradition' => ['required'],
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);

            if($validator->fails()){
                return new View('site.issue_book',
                    ['errors' => $validator->errors(), 'freeBooks' => $freeBooks, 'librarians' => $librarians, 'readers' => $readers]);
            }

            if (BookDeliveries::create($data)) {
                app()->route->redirect('/books');
            }
        }
        return (new View())->render('site.issue_book', ['freeBooks' => $freeBooks, 'librarians' => $librarians, 'readers' => $readers]);
    }

    public function accept(Request $request): string
    {
        $books = collect();
        $readers = Readers::all();
        $data = $request->all();
        $selectedReader = $data['ticket_number'] ?? null;

        if ($selectedReader) {
            $books = Books::whereIn('id', function ($query) use ($selectedReader) {
                $query->select('book_id')
                    ->from('book_deliveries')
                    ->where('ticket_number', $selectedReader)
                    ->whereNull('date_return');
            })->get();
        }

        if ($request->method === 'POST') {
            $data = $request->all();
            $data['date_return'] = date('Y-m-d H:i:s');

            $validator = new Validator($data, [
                'book_id' => ['required'],
                'ticket_number' => ['required'],
                'date_return' => ['required']
            ], [
                'required' => 'Поле :field пусто'
            ]);

            if ($validator->fails()) {
                return new View('site.accept_book', [
                    'errors' => $validator->errors(),
                    'books' => $books,
                    'readers' => $readers,
                    'selectedReader' => $selectedReader
                ]);
            }

            $delivery = BookDeliveries::where('ticket_number', $data['ticket_number'])
                ->where('book_id', $data['book_id'])
                ->whereNull('date_return')
                ->first();

            if ($delivery) {
                $delivery->update(['date_return' => $data['date_return']]);
                app()->route->redirect('/books');
            } else {
                return new View('site.accept_book', [
                    'errors' => ['book_id' => ['Эта книга не выдана данному читателю']],
                    'books' => $books,
                    'readers' => $readers,
                    'selectedReader' => $selectedReader
                ]);
            }
        }

        return (new View())->render('site.accept_book', [
            'books' => $books,
            'readers' => $readers,
            'selectedReader' => $selectedReader
        ]);
    }
}