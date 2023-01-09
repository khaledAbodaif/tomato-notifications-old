<?php


Route::middleware([
    'auth:sanctum',
    'verified'
])->name('admin.')->group(function () {
    Route::get('admin/notifications', [NotificationsController::class, 'index'])->name('notifications.index');
    Route::post('admin/notifications/bulk', [NotificationsController::class, 'userBulk'])->name('notifications.bulk');
    Route::delete('admin/notifications/{id}/delete', [NotificationsController::class, 'userDestroy'])->name('notifications.destory');
    Route::post('admin/notifications/clear', [NotificationsController::class, 'clearUser'])->name('notifications.clear');

});

Route::post('token', [NotificationsController::class, 'token'])->name('admin.notifications.token');
