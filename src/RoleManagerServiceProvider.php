<?php
/**
* RoleManager Service Provider
* @version v1.0.0
* @author Saiful Alam
* @package RoleManager
*/
namespace MSAR\RoleManager;

use Schema;
use MSAR\RoleManager\Models\Permission;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class RoleManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/role_manager.php' => config_path('role_manager.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBladeExtensions();
    }


    protected function registerBladeExtensions()
    {
        $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
            
            $bladeCompiler->directive('hasrole', function ($arguments) {
                return "<?php if( rmHasRole({$arguments}) ): ?>";
            });
            $bladeCompiler->directive('elsehasrole', function ($arguments) {
                return "<?php elseif( rmHasRole({$arguments}) ): ?>";
            });
            $bladeCompiler->directive('endhasrole', function () {
                return '<?php endif; ?>';
            });

            $bladeCompiler->directive('ucan', function ($arguments) {
                return "<?php if( rmHasPermission({$arguments}) ): ?>";
            });
            $bladeCompiler->directive('elseucan', function ($arguments) {
                return "<?php elseif( rmHasPermission({$arguments}) ): ?>";
            });
            $bladeCompiler->directive('enducan', function () {
                return '<?php endif; ?>';
            });

        });
    }
}
