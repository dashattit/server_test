<?php

namespace Middlewares;

use Src\Request;

class TrimMiddleware
{
    public function handle(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            $value = $value === '' ? null : $value;
            $request->set($key, is_string($value) ? trim($value) : $value);
        }
        return $request;
    }
}