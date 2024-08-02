<?php

namespace App\Http\Controllers;

use App\Architecture\Services\User\UserService;
use App\Http\Resources\UserResource;
use ErrorException;
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

            if ($user == null) {
                throw new ErrorException("Usuário não encontrado");
            }

            $user = new UserResource($user);

            return response()->json($user);
        }
        catch (ErrorException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 404);
        }
        catch(Exception $e) {
            return response()->json([
                'error' => 'An error occurred while processing your request.'
            ], 500);
        }

    }

}
