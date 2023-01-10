<?php

namespace Queents\TomatoNotifications\Traits;

use Queents\TomatoNotifications\Models\UserNotification;
use Queents\TomatoNotifications\Models\UserToken;

trait InteractWithNotifications
{

    public function initializeUseNotifications()
    {
        $this->appends[] = 'fcm';
        $this->appends[] = 'fcmID';
    }

    public function setFcmAttribute($value)
    {
        $this->fcm = $value;
    }

    public function getFcmAttribute()
    {
        return 'fcm-web';
    }

    public function setFcmIdAttribute($value)
    {
        $this->fcmId = $value;
    }

    public function getFcmIdAttribute()
    {
        return $this->id;
    }

    public function getUserNotifications()
    {
        return $this->morphMany(UserNotification::class, 'model');
    }

    public function userTokensFcm()
    {
        return $this->morphOne(UserToken::class, 'model')->where('provider', $this->fcm);
    }

    public function userTokensPusher()
    {
        return $this->morphOne(UserToken::class, 'model')->where('provider', 'pusher');
    }

    public function routeNotificationForFcm()
    {
        return $this->userTokensFcm ? $this->userTokensFcm->provider_token : '';
    }
}
