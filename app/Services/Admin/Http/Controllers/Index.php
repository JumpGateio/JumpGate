<?php

namespace App\Services\Admin\Http\Controllers;

use App\Services\Users\Models\User;
use Illuminate\Support\Str;

class Index extends Base
{
    public function __invoke()
    {
        $title  = 'Admin Dashboard';
        $routes = [
            'users' => route('admin.index.users'),
        ];

        return $this->response(
            compact('title', 'routes')
        );
    }

    public function users()
    {
        $data = User::with('status')
            ->orderByNameAsc()
            ->take(5)
            ->get()
            ->transform(function ($user) {
                return [
                    'id'         => $user->id,
                    'email'      => $user->email,
                    'status'     => $user->status->label,
                    'deleted_at' => $user->deleted_at,
                ];
            });

        $count = User::count();
        $count .= ' ' . Str::plural('user', $count);

        return $this->success(compact('data', 'count'));
    }
}
