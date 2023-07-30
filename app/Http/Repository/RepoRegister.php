<?php
namespace App\Http\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\RepositoryInterface\RegisterInterface;

class RepoRegister implements RegisterInterface
{
    private $userModel;
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function register($request)
    {
        $request['password'] = Hash::make($request['password']);
        $request['verification_code'] = rand(100000, 999999);
        $user = $this->userModel::create($request->toArray());

        Log::info("Verification code for user {$user->id}: {$request['verification_code']}");

        $token = $user->createToken('auth-token')->plainTextToken;
        $user['token'] = $token;

        return $user;
    }

    public function login($request)
{

    $user = User::where('phone_number', $request->phone_number)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return 'InvaledCredentials';
    }
    if (! $user->verification_code) {
        return 'notVerified';
    }

    $token = $user->createToken('auth-token')->plainTextToken;
    $user['token'] = $token;

    return $user;
}

}
