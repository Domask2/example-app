<?php

namespace App\Providers;

use App\Models\DataBase;
use App\Models\DataSource;
use App\Models\DataSourceAccess;
use App\Models\User;
use App\Policies\DataBasePolicy;
use App\Policies\DataSourceAccessPolicy;
use App\Policies\DataSourcePolicy;
use App\Policies\UserPolicy;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\SimpleMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        DataBase::class => DataBasePolicy::class,
        DataSource::class => DataSourcePolicy::class,
        DataSourceAccess::class => DataSourceAccessPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function ($user, string $token) {
            return 'http://localhost:3000/reset-password?token='.$token;
        });

//        ResetPassword::toMailUsing(function ($notifiable, $url) {
//            return (new MailMessage)
//                ->greeting('Здравствуйте!')
//                ->subject('Верификация почты')
//                ->line('Вы или кто то другой зарегистрировались на сайте PLINOR.')
//                ->line('Если это были вы, то подтвердите свою регистрацию перейдя по ссылке ниже, в противном случай просто проигнарируйте это письмо.')
//                ->action('Подтвердите почту', $url);
//        });

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->greeting('Здравствуйте!')
                ->subject('Верификация почты')
                ->line('Вы или кто то другой зарегистрировались на сайте PLINOR.')
                ->line('Если это были вы, то подтвердите свою регистрацию перейдя по ссылке ниже, в противном случай просто проигнарируйте это письмо.')
                ->action('Подтвердите почту', $url);
        });
    }
}
