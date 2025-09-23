<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Services\Sms\AfromessageSmsService;
use App\Exceptions\AuthException;
use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OtpAuthController extends Controller
{
    protected AfromessageSmsService $sms;
    protected UserRepository $users;

    public function __construct(AfromessageSmsService $sms, UserRepository $users)
    {
        $this->sms = $sms;
        $this->users = $users;
    }

    /**
     * Request an OTP for the given phone number.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function requestOtp(Request $request): JsonResponse
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'max:32'],
            'purpose' => ['nullable', 'in:login,signup,reset'],
        ]);

        $phone = $data['phone'];

        try {
            // Generate OTP
            $length = (int) config('auth.otp_length', env('OTP_LENGTH', 6));
            $expireMinutes = (int) config('auth.otp_expire_minutes', env('OTP_EXPIRE_MINUTES', 10));
            $rawOtp = str_pad((string) random_int(0, (int) pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);

            // Save OTP via repository
            $user = $this->users->saveOtp($phone, $rawOtp, $expireMinutes);

            // Reset attempt counter
            Cache::put("otp_attempts:{$phone}", 0, now()->addMinutes($expireMinutes + 10));

            // Send SMS
            $message = "Your PharmaLink login code is: {$rawOtp}. It expires in {$expireMinutes} minutes.";
            $sendResp = $this->sms->send($phone, $message);

            if (! $sendResp['success']) {
                // Optional: clear OTP if send fails
                $user->otp = null;
                $user->otp_expires_at = null;
                $user->save();

                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to send OTP',
                    'details' => $sendResp['error'] ?? $sendResp['response'] ?? null,
                ], 500);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent',
                'data' => new UserResource($user),
                'expires_in_minutes' => $expireMinutes,
            ], 200);

        } catch (AuthException $ae) {
            return response()->json([
                'status' => 'error',
                'message' => $ae->getMessage(),
            ], $ae->getCode());
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unexpected error: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Verify the OTP and issue a Sanctum token.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function verifyOtp(Request $request): JsonResponse
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'max:32'],
            'code' => ['required', 'string'],
        ]);

        try {
            $user = $this->users->verifyOtp($data['phone'], $data['code']);

            // Clear attempts
            Cache::forget("otp_attempts:{$data['phone']}");

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Authenticated',
                'data' => new UserResource($user),
                'token' => $token,
            ], 200);
        } catch (AuthException $ae) {
            return response()->json([
                'status' => 'error',
                'message' => $ae->getMessage(),
            ], $ae->getCode());
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unexpected error: '.$e->getMessage(),
            ], 500);
        }
    }
}
