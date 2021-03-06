<?php

namespace ArielMejiaDev\JsonApiAuth\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'json-api-auth:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Json Api Authentication controllers and routes.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Controllers...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers/JsonApiAuth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/App/Http/Controllers/JsonApiAuth', app_path('Http/Controllers/JsonApiAuth'));

        // Requests...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Requests/JsonApiAuth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/App/Http/Requests/JsonApiAuth', app_path('Http/Requests/JsonApiAuth'));

        // Notifications...
        (new Filesystem)->ensureDirectoryExists(app_path('Notifications/JsonApiAuth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/App/Notifications/JsonApiAuth', app_path('Notifications/JsonApiAuth'));

        // Actions...
        (new Filesystem)->ensureDirectoryExists(app_path('Actions/JsonApiAuth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/App/Actions/JsonApiAuth', app_path('Actions/JsonApiAuth'));

        // Translate files...
        (new Filesystem)->ensureDirectoryExists(resource_path('lang'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/lang', resource_path('lang/en'));

        // Tests...
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/tests/Feature', base_path('tests/Feature'));

        // Routes...
        copy(__DIR__.'/../../stubs/routes/api.php', base_path('routes/api.php'));
        copy(__DIR__.'/../../stubs/routes/auth.php', base_path('routes/json-api-auth.php'));

        // Config...
        copy(__DIR__.'/../../stubs/config/config.php', base_path('config/json-api-auth.php'));

        $this->output->success('Json Api Authentication scaffolding installed successfully here the routes of the package:');

        $this->createRoutesTable();
    }


    /**
     * At command runtime the routes files are not available yet, so its necessary to build it manually
     */
    public function createRoutesTable()
    {
        $headers = ['Method', 'URI', 'Name'];

        $routes = [
            [
                'method' => 'POST',
                'uri' => 'api/confirm-password',
                'name' => 'json-api-auth.password.confirm',
            ],
            [
                'method' => 'POST',
                'uri' => 'api/email/verification-notification',
                'name' => 'json-api-auth.verification.send',
            ],
            [
                'method' => 'POST',
                'uri' => 'api/forgot-password',
                'name' => 'json-api-auth.password.email',
            ],
            [
                'method' => 'POST',
                'uri' => 'api/login',
                'name' => 'json-api-auth.login',
            ],
            [
                'method' => 'GET|HEAD',
                'uri' => 'api/logout',
                'name' => 'json-api-auth.logout',
            ],
            [
                'method' => 'POST',
                'uri' => 'api/register',
                'name' => 'json-api-auth.register',
            ],
            [
                'method' => 'POST',
                'uri' => 'api/reset-password',
                'name' => 'json-api-auth.password.update',
            ],
            [
                'method' => 'GET|HEAD',
                'uri' => 'api/verify-email/{id}/{hash}',
                'name' => 'json-api-auth.verification.verify',
            ],
        ];

        $this->table($headers, $routes);
    }
}
