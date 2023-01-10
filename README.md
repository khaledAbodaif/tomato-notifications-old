# Tomato Notifications

🍅 Laravel Notifications Channel with GUI to send notifications with templates for [Tomato Admin](https://github.com/queents/tomato-admin) build for Splade [Splade](https://splade.dev/)

we are build a full notification system for you with multi provider like mail, firebase, pusher, discord, slack, messagebird and open the way to add more all of this working on queue and have a lot of helpers to make it easy to use this notification on your system

## Installation

```bash
composer require queents/tomato-notifications
```
after install use this command to install the package and publish assets

```bash
php artisan tomato-notifications:install
```

## Setup Model for Notifications


to setup any model to get notification you

```php
<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Queents\TomatoNotifications\Traits\InteractWithNotifications;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use InteractWithNotifications;
    ...
```

and you must set the settings for FCM to get realtime notification

## Queue

the notification is run on queue, so you must run the queue worker to send the notifications

```bash
php artisan queue:work
```

## Create Template
to create a new template you can use template CRUD and make sure that the template key is unique because you will use it on every single notifications.

## Send Notification
to send a notification you must use our helper SendNotification::class like

```php
SendNotification::make($template->providers)
    ->template($template->key)
    ->findTitle($matchesTitle)
    ->replaceTitle($titleFill)
    ->findBody($matchesBody)
    ->replaceBody($titleBody)
    ->model(User::class)
    ->id(User::first()->id)
    ->privacy('private')
    ->fire();
```

where $template is select of template by key and $matchesTitle and $matchesBody is array of matches to replace on the template and $titleFill and $titleBody is array of values to replace the matches

## Support

you can join our discord server to get support [VILT Admin](https://discord.gg/HUNYbgKDdx)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Queen Tech Solutions](https://github.com/queents)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
