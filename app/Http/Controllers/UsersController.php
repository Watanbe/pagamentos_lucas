<?php

namespace App\Http\Controllers;

use App\Architecture\Services\User\UserService;
use Exception;

class UsersController extends Controller {

    public function __construct(
        protected UserService $userService
    )
    {
    }

    public function getById(int $id) {
        try {
            $user = $this->userService->getById($id);
            dd($user);

            return response()->json($user);
        } catch(Exception $e) {
            dd($e);
        }
    }

}
