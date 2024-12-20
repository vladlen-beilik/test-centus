<?php

use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers;
use Laravel\Jetstream\Http\Controllers\Inertia as InertiaControllers;
use Laravel\Jetstream\Jetstream;

Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {
    if (Jetstream::hasTermsAndPrivacyPolicyFeature()) {
        Route::get('/terms-of-service', [InertiaControllers\TermsOfServiceController::class, 'show'])->name('terms.show');
        Route::get('/privacy-policy', [InertiaControllers\PrivacyPolicyController::class, 'show'])->name('policy.show');
    }

    $authMiddleware = config('jetstream.guard')
        ? 'auth:'.config('jetstream.guard')
        : 'auth';

    $authSessionMiddleware = config('jetstream.auth_session', false)
        ? config('jetstream.auth_session')
        : null;

    Route::group(['middleware' => array_values(array_filter([$authMiddleware, $authSessionMiddleware]))], function () {
        // User & Profile...
        Route::get('/user/profile', [InertiaControllers\UserProfileController::class, 'show'])
            ->name('profile.show');

        // Settings...
        Route::get('/user/alerts', [\App\Http\Controllers\UserAlertsController::class, 'show'])
            ->name('alerts.show');

        Route::post('/user/alerts-get-cities', [\App\Http\Controllers\UserAlertsController::class, 'getCities'])
            ->name('alerts.getCities');

        Route::post('/user/alerts', [\App\Http\Controllers\UserAlertsController::class, 'update'])
            ->name('alerts.update');

        Route::delete('/user/alerts/{id}', [\App\Http\Controllers\UserAlertsController::class, 'delete'])
            ->name('alerts.delete');


        Route::delete('/user/other-browser-sessions', [InertiaControllers\OtherBrowserSessionsController::class, 'destroy'])
            ->name('other-browser-sessions.destroy');

        Route::delete('/user/profile-photo', [InertiaControllers\ProfilePhotoController::class, 'destroy'])
            ->name('current-user-photo.destroy');

        if (Jetstream::hasAccountDeletionFeatures()) {
            Route::delete('/user', [InertiaControllers\CurrentUserController::class, 'destroy'])
                ->name('current-user.destroy');
        }

        Route::group(['middleware' => 'verified'], function () {
            // API...
            if (Jetstream::hasApiFeatures()) {
                Route::get('/user/api-tokens', [InertiaControllers\ApiTokenController::class, 'index'])->name('api-tokens.index');
                Route::post('/user/api-tokens', [InertiaControllers\ApiTokenController::class, 'store'])->name('api-tokens.store');
                Route::put('/user/api-tokens/{token}', [InertiaControllers\ApiTokenController::class, 'update'])->name('api-tokens.update');
                Route::delete('/user/api-tokens/{token}', [InertiaControllers\ApiTokenController::class, 'destroy'])->name('api-tokens.destroy');
            }

            // Teams...
            if (Jetstream::hasTeamFeatures()) {
                Route::get('/teams/create', [InertiaControllers\TeamController::class, 'create'])->name('teams.create');
                Route::post('/teams', [InertiaControllers\TeamController::class, 'store'])->name('teams.store');
                Route::get('/teams/{team}', [InertiaControllers\TeamController::class, 'show'])->name('teams.show');
                Route::put('/teams/{team}', [InertiaControllers\TeamController::class, 'update'])->name('teams.update');
                Route::delete('/teams/{team}', [InertiaControllers\TeamController::class, 'destroy'])->name('teams.destroy');
                Route::put('/current-team', [Controllers\CurrentTeamController::class, 'update'])->name('current-team.update');
                Route::post('/teams/{team}/members', [InertiaControllers\TeamMemberController::class, 'store'])->name('team-members.store');
                Route::put('/teams/{team}/members/{user}', [InertiaControllers\TeamMemberController::class, 'update'])->name('team-members.update');
                Route::delete('/teams/{team}/members/{user}', [InertiaControllers\TeamMemberController::class, 'destroy'])->name('team-members.destroy');

                Route::get('/team-invitations/{invitation}', [Controllers\TeamInvitationController::class, 'accept'])
                    ->middleware(['signed'])
                    ->name('team-invitations.accept');

                Route::delete('/team-invitations/{invitation}', [Controllers\TeamInvitationController::class, 'destroy'])
                    ->name('team-invitations.destroy');
            }
        });
    });
});
