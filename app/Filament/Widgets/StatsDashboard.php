<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsDashboard extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();
        $stats = [];
        
        
        if (in_array($user?->role, ['admin', 'employee'])) {
            $countCars = \App\Models\Car::count();
            $stats[] = Stat::make('Total Cars', $countCars . ' Cars')
                ->icon('heroicon-o-truck')
                ->color('success');
        }
        
        // hanya role admin yang bisa melihat total users
        if ($user?->role === 'admin') {
            $countUsers = \App\Models\User::count();
            $stats[] = Stat::make('Total Users', $countUsers . ' Users')
                ->icon('heroicon-o-user')
                ->color('primary');
        }
        
       
        if (in_array($user?->role, ['admin', 'employee'])) {
            $countCustomers = \App\Models\Customer::count();
            $stats[] = Stat::make('Total Customers', $countCustomers  . ' Customers')
                ->icon('heroicon-o-users')
                ->color('warning');
        }
        if(in_array($user?->role, ['admin', 'employee'])) {
            $countSales = \App\Models\Sales::count();
            $stats[] = Stat::make('Total Sales', $countSales  . ' Sales')
                
                ->icon('heroicon-o-shopping-bag')
                ->color('danger');
                
        }
            
        return $stats;
    }

    public static function canView(): bool
    {
         return in_array(auth()->user()?->role, ['admin', 'employee']);
    }
}
