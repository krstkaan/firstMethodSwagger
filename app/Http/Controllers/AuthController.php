<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\TwoFactorResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request; 

/**
 * @OA\Post(
 *     path="/setup",
 *     summary="Setup two-factor authentication",
 *     description="Setup two-factor authentication for a user. This endpoint allows a user to enable two-factor authentication. If the user already has a two-factor authentication secret, the endpoint will return a 204 No Content response. Otherwise, it will generate a new secret and return it in the response.",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No Content",
 *         @OA\JsonContent(
 *             type="object",
 *             example={}
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Two Factor Resource",
 *         @OA\JsonContent(ref="#/components/schemas/TwoFactorResource")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Unauthorized"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad Request",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Bad Request"
 *             )
 *         )
 *     )
 * )
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


