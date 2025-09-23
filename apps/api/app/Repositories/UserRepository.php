<?php 

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exceptions\AuthException;

class UserRepository
{
    /**
     * Save OTP for a user atomically.
     *
     * @param string $phone
     * @param string $otp
     * @param int $expiresMinutes
     * @return User
     * @throws AuthException
     */
    public function saveOtp(string $phone, string $otp, int $expiresMinutes = 5): User
    {
        try {
            return DB::transaction(function () use ($phone, $otp, $expiresMinutes) {
                $user = User::firstOrCreate(['phone' => $phone], ['phone_verified_at' => null]);

                $user->otp = Hash::make($otp);
                $user->otp_expires_at = Carbon::now()->addMinutes($expiresMinutes);
                $user->save();

                return $user;
            });
        } catch (\Throwable $e) {
            throw new AuthException("Failed to save OTP: " . $e->getMessage());
        }
    }

    /**
     * Verify OTP atomically.
     *
     * @param string $phone
     * @param string $otp
     * @return User
     * @throws AuthException
     */
    public function verifyOtp(string $phone, string $otp): User
    {
        try {
            return DB::transaction(function () use ($phone, $otp) {
                $user = User::where('phone', $phone)->first();

                if (!$user) {
                    throw new AuthException("User not found");
                }

                if (!$user->otp || !$user->otp_expires_at || $user->otp_expires_at->isPast()) {
                    throw new AuthException("OTP expired or invalid");
                }

                if (!Hash::check($otp, $user->otp)) {
                    throw new AuthException("Invalid OTP code");
                }

                $user->otp = null;
                $user->otp_expires_at = null;
                if (!$user->phone_verified_at) {
                    $user->phone_verified_at = now();
                }
                $user->save();

                return $user;
            });
        } catch (AuthException $ae) {
            throw $ae; // propagate known auth exceptions
        } catch (\Throwable $e) {
            throw new AuthException("Failed to verify OTP: " . $e->getMessage());
        }
    }
}
