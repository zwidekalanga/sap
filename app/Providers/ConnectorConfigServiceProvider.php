<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

use App\Connectors\Sap\Di\Server\Clients\Client;
use App\Connectors\Sap\Di\Server\Connector;
use App\Connectors\Sap\Di\Server\Builder;
use App\Models\Auth;

class ConnectorConfigServiceProvider extends ServiceProvider
{
    private $session;
    /**
     * Bootstrap any application services.
     *
     * @param Request $request
     * @return void
     */
    public function boot(Request $request) {
        if ($request->hasHeader('Authorization')) {
            $this->session = $request->header('Authorization');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Client::class, function ($app) {
            return new Client();
        });

        $this->app->singleton(Connector::class, function ($app) {
            $connector = new Connector($app->make(Client::class));

            if (isset($this->session)) {
                $connector->setClientSession($this->session);
            }

            return $connector;
        });

        $this->app->bind(Builder::class, function ($app) {
            return new Builder($app->make(Connector::class));
        });
    }
}