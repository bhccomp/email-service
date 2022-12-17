<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\UserEmailConfig;
use Illuminate\Support\Facades\Route;
use Config;
use Illuminate\Support\Facades\Log;


class EmailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /*
        $mail = UserEmailConfig::configuredEmail()->first();

        if (isset($mail->id)) {  
            $config = array(
                'driver'     => strtolower($mail->driver),
                'transport'  => strtolower($mail->driver),
                'host'       => $mail->host,
                'port'       => $mail->port,
                'name'       => $mail->name,
                'address'    => $mail->address,
                'from'       => $mail->name,
                'encryption' => $mail->encryption,
                'username'   => $mail->username,
                'password'   => $mail->password
            );
           
            Config::set('mail', $config); 
            
        }
        */
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
