<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\Register;
use Afsakar\FilamentOtpLogin\FilamentOtpLoginPlugin;
use Illuminate\Support\Facades\Auth;
use Kenepa\Banner\BannerPlugin;
use App\Settings\GeneralSettings;
use App\Livewire\MyProfileExtended;
use EightyNine\FilamentPasswordExpiry\PasswordExpiryPlugin;

class BwcFocalPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('bwc_focal')
            ->path('bwc_focal')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->sidebarCollapsibleOnDesktop()

            ->login(Login::class)
            ->emailVerification()
            ->favicon(asset('images/favicon.ico'))
            ->brandName(fn (GeneralSettings $settings) => $settings->brand_name)
            ->brandLogo(asset('storage/sites/logo.png'))
            ->brandLogoHeight(fn (GeneralSettings $settings) => $settings->brand_logoHeight)
            ->colors(fn (GeneralSettings $settings) => $settings->site_theme)
            ->databaseNotifications()->databaseNotificationsPolling('30s')
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])

            ->passwordReset()
            ->loginRouteSlug('login')
            ->registrationRouteSlug('register')
            ->passwordResetRoutePrefix('password-reset')
            ->passwordResetRequestRouteSlug('request')
            ->passwordResetRouteSlug('reset')
            ->emailVerificationRoutePrefix('email-verification')
            ->emailVerificationPromptRouteSlug('prompt')
            ->emailVerificationRouteSlug('verify')

            ->discoverResources(in: app_path('Filament/BwcFocal/Resources'), for: 'App\\Filament\\BwcFocal\\Resources')
            ->discoverPages(in: app_path('Filament/BwcFocal/Pages'), for: 'App\\Filament\\BwcFocal\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/BwcFocal/Widgets'), for: 'App\\Filament\\BwcFocal\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                \BezhanSalleh\FilamentExceptions\FilamentExceptionsPlugin::make(),
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 2,
                        'sm' => 1
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
                \Jeffgreco13\FilamentBreezy\BreezyCore::make()
                    ->myProfile(
                        shouldRegisterUserMenu: true,
                        shouldRegisterNavigation: false,
                        navigationGroup: 'Settings',
                        hasAvatars: true,
                        slug: 'my-profile'
                    )
                    ->myProfileComponents([
                        'personal_info' => MyProfileExtended::class,
                    ])
                    ->enableTwoFactorAuthentication(
                        force: false,
                        // action: CustomTwoFactorPage::class 
                    ),
                BannerPlugin::make()
                    ->bannerManagerAccessPermission('banner-manager'),
                FilamentOtpLoginPlugin::make(),
                // PasswordExpiryPlugin::make(),
            ]);
    }
}
