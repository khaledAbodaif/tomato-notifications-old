<?php

namespace Queents\TomatoNotifications\Services;

use Queents\TomatoNotifications\Models\NotificationsTemplate;
use Queents\TomatoNotifications\Models\UserNotification;
use Queents\TomatoNotifications\Jobs\NotificationJop;
use Queents\TomatoNotifications\Services\Actions\FireEvent;
use Queents\TomatoNotifications\Services\Actions\LoadTemplate;
use Queents\TomatoNotifications\Services\Actions\SendToDatabase;
use Queents\TomatoNotifications\Services\Actions\SendToJob;
use Queents\TomatoNotifications\Services\Concerns\HasCreatedBy;
use Queents\TomatoNotifications\Services\Concerns\HasFindBody;
use Queents\TomatoNotifications\Services\Concerns\HasFindTitle;
use Queents\TomatoNotifications\Services\Concerns\HasIcon;
use Queents\TomatoNotifications\Services\Concerns\HasId;
use Queents\TomatoNotifications\Services\Concerns\HasImage;
use Queents\TomatoNotifications\Services\Concerns\HasLang;
use Queents\TomatoNotifications\Services\Concerns\HasMessage;
use Queents\TomatoNotifications\Services\Concerns\HasModel;
use Queents\TomatoNotifications\Services\Concerns\HasPrivacy;
use Queents\TomatoNotifications\Services\Concerns\HasProviders;
use Queents\TomatoNotifications\Services\Concerns\HasReplaceBody;
use Queents\TomatoNotifications\Services\Concerns\HasReplaceTitle;
use Queents\TomatoNotifications\Services\Concerns\HasTemplate;
use Queents\TomatoNotifications\Services\Concerns\HasTemplateModel;
use Queents\TomatoNotifications\Services\Concerns\HasTitle;
use Queents\TomatoNotifications\Services\Concerns\HasType;
use Queents\TomatoNotifications\Services\Concerns\HasUrl;
use Queents\TomatoNotifications\Services\Concerns\HasUser;
use Queents\TomatoNotifications\Services\Concerns\IsDatabase;

class SendNotification
{
    use HasTitle;
    use HasMessage;
    use HasType;
    use HasProviders;
    use HasPrivacy;
    use HasUrl;
    use HasImage;
    use HasIcon;
    use HasModel;
    use HasTemplate;
    use HasFindTitle;
    use HasFindBody;
    use HasReplaceTitle;
    use HasReplaceBody;
    use HasId;
    use HasCreatedBy;
    use HasUser;
    use HasLang;
    use HasTemplateModel;
    use IsDatabase;

    /*
     * Actions
     */
    use FireEvent;
    use LoadTemplate;
    use SendToDatabase;
    use SendToJob;

    /**
     * @param ?array $providers
     * @return static
     */
    public static function make(?array $providers): static
    {
        return (new static)->providers($providers);
    }
}
