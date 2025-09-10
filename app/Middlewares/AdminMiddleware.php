<?php

namespace Middlewares;

use Model\LibrarianRoles;
use Src\Auth\Auth;
use Src\Request;

class AdminMiddleware
{
    public function handle(Request $request)
    {
        $user = Auth::user();

        if ($user->role->role_name != 'Администратор') {
            app()->route->redirect('/librarians');
        }
    }
}