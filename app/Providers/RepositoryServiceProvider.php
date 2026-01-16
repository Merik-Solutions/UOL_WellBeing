<?php

namespace App\Providers;

use App\Repositories\interfaces\AdminRepository;
use App\Repositories\interfaces\UserRepository;
use App\Repositories\SQL\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    public function bindRepo($directory, $namespace, $app)
    {
        $directory = $directory . '/../Repositories/SQL';
        if (!is_dir($directory)) {
            return false;
        }

        $scanned_directory = array_slice(scandir($directory), 2);
        $contractNamespace = $namespace . '\Repositories\interfaces';
        $RepositoryNamespace = $namespace . '\Repositories\SQL';
        foreach ($scanned_directory as $repo) {
            $model = str_replace(['Repository', '.php', 'Eloquent'], '', $repo);

            $interface = $contractNamespace . '\\' . $model . 'Repository';
            $repository =
                $RepositoryNamespace . '\\' . $model . 'RepositoryEloquent';

            $this->app->bind($interface, $repository);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bindRepo(__DIR__, 'App', $this->app);
    }
}
