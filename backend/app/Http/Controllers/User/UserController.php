<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\ResponseService\ResponseService;

class UserController extends Controller
{   
    /**
     * Summary of index
     * @return JsonResponse
     */
    public function index()
    {
        $user = User::all();

        return response()->json(ResponseService::success($user, 'Liste des utilisateurs récupérée avec succès'));
    }
}


