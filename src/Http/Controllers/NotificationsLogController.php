<?php

namespace Queents\TomatoNotifications\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Queents\TomatoNotifications\Http\Requests\NotificationsLog\NotificationsLogStoreRequest;
use Queents\TomatoNotifications\Http\Requests\NotificationsLog\NotificationsLogUpdateRequest;
use Queents\TomatoNotifications\Models\NotificationsLogs;
use Queents\TomatoNotifications\Tables\NotificationsLogTable;
use Queents\TomatoPHP\Services\Tomato;

class NotificationsLogController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return Tomato::index(
            request: $request,
            view: 'tomato-notifications::notifications-logs.index',
            table: NotificationsLogTable::class,
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function api(Request $request): JsonResponse
    {
        return Tomato::json(
            request: $request,
            model: NotificationsLogs::class,
        );
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return Tomato::create(
            view: 'tomato-notifications::notifications-logs.create',
        );
    }

    /**
     * @param NotificationsLogStoreRequest $request
     * @return RedirectResponse
     */
    public function store(NotificationsLogStoreRequest $request): RedirectResponse
    {
        $response = Tomato::store(
            request: $request,
            model: NotificationsLogs::class,
            message: 'NotificationsLog created successfully',
            redirect: 'admin.notifications-logs.index',
        );

        return $response['redirect'];
    }

    /**
     * @param NotificationsLogs $model
     * @return View
     */
    public function show(NotificationsLogs $model): View
    {
        return Tomato::get(
            model: $model,
            view: 'tomato-notifications::notifications-logs.show',
        );
    }

    /**
     * @param NotificationsLogs $model
     * @return View
     */
    public function edit(NotificationsLogs $model): View
    {
        return Tomato::get(
            model: $model,
            view: 'tomato-notifications::notifications-logs.edit',
        );
    }

    /**
     * @param NotificationsLogUpdateRequest $request
     * @param NotificationsLogs $model
     * @return RedirectResponse
     */
    public function update(NotificationsLogUpdateRequest $request, NotificationsLogs $model): RedirectResponse
    {
        $response = Tomato::update(
            request: $request,
            model: $model,
            message: 'NotificationsLog updated successfully',
            redirect: 'admin.notifications-logs.index',
        );

        return $response['redirect'];
    }

    /**
     * @param NotificationsLogs $model
     * @return RedirectResponse
     */
    public function destroy(NotificationsLogs $model): RedirectResponse
    {
        return Tomato::destroy(
            model: $model,
            message: 'NotificationsLog deleted successfully',
            redirect: 'admin.notifications-logs.index',
        );
    }
}
