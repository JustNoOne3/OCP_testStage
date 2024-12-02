<?php

namespace App\Providers;

use Filament\Tables\Actions\Action;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Observers\UserObserver;
use App\Models\Establishment;
use App\Observers\EstablishmentObserver;
use App\Models\Month13th;
use App\Observers\Month13thObserver;
use App\Models\AccidentReport;
use App\Observers\AccRepObserver;
use App\Models\IllnessReport;
use App\Observers\IllRepObserver;
use App\Models\IAReport;
use App\Observers\AccIllObserver;
use App\Models\NIAReport;
use App\Observers\NoAccIllObserver;
use App\Models\TeleReportHead;
use App\Observers\TeleHeadObserver;
use App\Models\TeleReportBranch;
use App\Observers\TeleBranchObserver;
use App\Models\Employees;
use App\Observers\EmpObserver;
use App\Models\Mtprf;
use App\Observers\MtprfObserver;

use App\Models\FlexibleWork;
use App\Observers\FlexibleWorkObserver;

use Livewire;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Http\Responses\LogoutResponse;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LogoutResponseContract::class, LogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    { 
        User::observe(UserObserver::class);
        Establishment::observe(EstablishmentObserver::class);
        Month13th::observe(Month13thObserver::class);
        Table::configureUsing(function (Table $table): void {
            $table
                ->emptyStateHeading('No data yet')
                ->striped()
                ->defaultPaginationPageOption(10)
                ->paginated([10, 25, 50, 100])
                ->extremePaginationLinks()
                ->defaultSort('created_at', 'desc');
        });
        AccidentReport::observe(AccRepObserver::class);
        IllnessReport::observe(IllRepObserver::class);
        IAReport::observe(AccIllObserver::class);
        NIAReport::observe(NoAccIllObserver::class);
        TeleReportHead::observe(TeleHeadObserver::class);
        TeleReportBranch::observe(TeleBranchObserver::class);
        Employees::observe(EmpObserver::class);
        FlexibleWork::observe(FlexibleWorkObserver::class);
        Mtprf::observe(MtprfObserver::class);
        Gate::define('banner-manager', function (User $user) {
            return Auth::user()->hasRole('super_admin');
        });
    }
}
