<?php

namespace TomatoPHP\TomatoNotifications\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Toast;
use TomatoPHP\TomatoNotifications\Models\NotificationsTemplate;
use TomatoPHP\TomatoNotifications\Models\UserNotification;
use TomatoPHP\TomatoNotifications\Models\UserToken;

class NotificationsController extends Controller
{
    public function index()
    {
        $notification = UserNotification::where('model_type',User::class)
            ->where('model_id', auth()->user()->id)
            ->orWhere('model_id', null)
            ->orderBy('id', 'desc')
            ->take(10)->get();

        foreach ($notification as $item) {
            $item->date = $item->created_at->diffForHumans();
            if ($item->template_id) {
                $template = NotificationsTemplate::find($item->template_id);
                $item->image = count($template->getMedia('image')) ? $template->getMedia('image')->first()->getUrl() : url('images/default.png');
            }
        }
        return view('tomato-notifications::user-notifications.user', [
            "notifications" => $notification
        ]);
    }

    public function clearUser(): \Illuminate\Http\RedirectResponse
    {
        UserNotification::where('model_type',User::class)
            ->where('model_id', auth()->user()->id)
            ->orderBy('id', 'desc')
            ->take(10)->delete();

        Toast::title(trans('tomato-notifications::global.notifications.success'))->success()->autoDismiss(2);
        return redirect()->back();
    }

    public function token(Request $request)
    {
        $request->validate([
            "token" => "required|string",
            "provider" => "required|string",
            "model" => "required|string",
            "model_id" => "required"
        ]);

        $checkEx = UserToken::where('model_type', $request->get('model'))
            ->where('model_id', $request->get('model_id'))
            ->where('provider', $request->get('provider'))
            ->first();

        if (!$checkEx) {
            $token = new UserToken();
            $token->model_type = $request->get('model');
            $token->model_id = $request->get('model_id');
            $token->provider = $request->get('provider');
            $token->provider_token = $request->get('token');
            $token->save();

            return back();
        } else {
            $checkEx->provider_token = $request->get('token');
            $checkEx->save();

            return back();
        }
    }
}
