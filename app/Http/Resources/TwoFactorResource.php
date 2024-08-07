<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="TwoFactorResource",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="User ID"
 *     ),
 *     @OA\Property(
 *         property="two_factor_secret",
 *         type="string",
 *         description="Two factor authentication secret"
 *     )
 * )
 */
class TwoFactorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'two_factor_secret' => $this->two_factor_secret,
        ];
    }
}

