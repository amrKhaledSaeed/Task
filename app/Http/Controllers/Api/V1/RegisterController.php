<?php

namespace App\Http\Controllers\Api\V1;

use App\helpers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\RegisterResource;
use App\Http\Resources\GeneralCollection;
use App\Http\RepositoryInterface\RegisterInterface;

class RegisterController extends Controller
{
    private $registerInterface;
    public function __construct(RegisterInterface $registerInterface)
    {
        $this->registerInterface = $registerInterface;
    }
    use helpers;
    public function register(RegisterRequest $request)
{
   $user = $this->registerInterface->register($request);

    return $this->apiResponse(['data' => new RegisterResource($user)]);
}
    public function login(LoginRequest $request)
{
   $user = $this->registerInterface->login($request);
if($user == 'InvaledCredentials') {
    return response()->json(['message' => 'Invalid login credentials'], 401);

}elseif($user == 'notVerified'){
    return response()->json(['message' => 'Account not verified'], 401);
}else{
    return $this->apiResponse(['data' => new RegisterResource($user)]);

}


}


}
