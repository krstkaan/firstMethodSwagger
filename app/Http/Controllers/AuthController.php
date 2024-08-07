<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\TwoFactorResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\TwoFactorResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Post(
 *     path="/setup",
 *     summary="Setup two-factor authentication",
 *     description="Setup two-factor authentication for a user",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No Content"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Two Factor Resource",
 *         @OA\JsonContent(ref="#/components/schemas/TwoFactorResource")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 * 
 * 
 * 
 */
class AuthController extends Controller
{
    public function setup(LoginRequest $request): JsonResponse|TwoFactorResource
    {
        $request->authenticate();
        $user = $request->user();

        if ($user->two_factor_secret) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }

        $secret = $this->google2fa->generateSecretKey();
        $user->two_factor_secret = $secret;
        $user->save();

        return new TwoFactorResource($user);
    }
}


