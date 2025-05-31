<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;

class UserPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('user')
            ->path('user') // La URL será /user
            ->brandName("Panel User - LMS UNIMET")
            ->login()
            ->registration() // Opcional: permite registro de usuarios
            ->passwordReset(); // Opcional: recuperación de contraseña
            
    }
}