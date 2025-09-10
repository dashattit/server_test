<?php
namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class AuthMiddleware
{
    public function handle(Request $request, string $role = null)
    {
        if (!Auth::check()) {
            app()->route->redirect('/login');
        }

        $user = Auth::user();

        if ($role === 'admin' && !$user->isAdmin()) {
            app()->route->redirect('/hello');
        }

        if ($role === 'librarian' && !$user->isLibrarian()) {
            app()->route->redirect('/hello');
        }
    }
}
