<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Route::get('register', [RegisteredUserController::class, 'create'])
    //             ->name('register');

    // Route::post('register', [RegisteredUserController::class, 'store']);

    // Route::get('login', [AuthenticatedSessionController::class, 'create'])
    //             ->name('login');

    // Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('Mots-de-passe-oublier', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('Mots-de-passe-oublier', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('Reinitialisation-mots-de-passe/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('Reinitialisation-mots-de-passe', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verifier-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verifier-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('cofirmation-mots-de-passe', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('cofirmation-mots-de-passe', [ConfirmablePasswordController::class, 'store']);

    Route::put('mots-de-passe', [PasswordController::class, 'update'])->name('password.update');

    Route::post('deconnexion', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
