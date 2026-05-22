<?php

namespace App\Providers;

use App\Dashboard\Contracts\DashboardComponentFactoryInterface;
use App\Dashboard\Factories\EnterpriseDashboardComponentFactory;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Penalty;
use App\Observers\DashboardCacheObserver;
use App\Repositories\AddOnRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CarRepository;
use App\Repositories\Contracts\AddOnRepositoryInterface;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\CarRepositoryInterface;
use App\Repositories\Contracts\DashboardRepositoryInterface;
use App\Repositories\Contracts\DendaRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\DashboardRepository;
use App\Repositories\DendaRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use App\Services\User\UserNavigationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DashboardRepositoryInterface::class, DashboardRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(DendaRepositoryInterface::class, DendaRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(CarRepositoryInterface::class, CarRepository::class);
        $this->app->bind(AddOnRepositoryInterface::class, AddOnRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(DashboardComponentFactoryInterface::class, EnterpriseDashboardComponentFactory::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Order::observe(DashboardCacheObserver::class);
        Payment::observe(DashboardCacheObserver::class);
        Penalty::observe(DashboardCacheObserver::class);

        View::composer(['layouts.User.header', 'layouts.User.sidebar'], function ($view): void {
            if (! Auth::check()) {
                return;
            }

            $view->with('userNavMetrics', app(UserNavigationService::class)->metrics(Auth::id()));
        });
    }
}
