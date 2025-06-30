<?php

declare(strict_types=1);

use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api.key', 'cast.query', 'throttle:60,1'])
    ->group(function (): void {
        Route::get(
            'organizations/search-by-name',
            [OrganizationController::class, 'getByName']
        )->name('organizations.searchByName');

        Route::get(
            'organizations/activity/{activityId}',
            [OrganizationController::class, 'getByActivity']
        )->whereNumber('activityId')
            ->name('organizations.searchByActivity');

        Route::get(
            'organizations/building/{buildingId}',
            [OrganizationController::class, 'getByBuilding']
        )->whereNumber('buildingId')
            ->name('organizations.listByBuilding');

        Route::get(
            'organizations/within-radius',
            [OrganizationController::class, 'getWithinRadius']
        )->name('organizations.withinRadius');

        Route::apiResource(
            'organizations',
            OrganizationController::class
        )->names([
            'index'   => 'organizations.index',
            'show'    => 'organizations.show',
            'store'   => 'organizations.store',
            'update'  => 'organizations.update',
            'destroy' => 'organizations.destroy',
        ]);
    });
