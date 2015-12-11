<?php
namespace Akasima\OpenSeminar\Module;

use Xpressengine\Module\AbstractModule;
use View;
use Route;

class MyModule extends AbstractModule
{
    public static function boot()
    {
        self::registerInstanceRoute();
    }

    public static function registerInstanceRoute()
    {
        Route::instance(self::getId(), function () {
            Route::get('/', ['as' => 'index', 'uses' => 'UserController@index']);
            Route::get('/show/{id}', ['as' => 'show', 'uses' => 'UserController@show']);

        }, ['namespace' => 'Akasima\\OpenSeminar\\Controller']);
    }

    /**
     * Return URL about module's detail setting
     * getInstanceSettingURI
     *
     * @param string $instanceId instance id
     *
     * @return mixed
     */
    public static function getInstanceSettingURI($instanceId)
    {
        // TODO: Implement getInstanceSettingURI() method.
    }

    /**
     * Return Create Form View
     * @return mixed
     */
    public function createMenuForm()
    {
        return View::make('openseminar_1212::views/menuType/create', [
        ])->render();
    }

    /**
     * Process to Store
     *
     * @param string $instanceId to store instance id
     * @param array $menuTypeParams for menu type store param array
     * @param array $itemParams except menu type param array
     *
     * @return mixed
     * @internal param $inputs
     *
     */
    public function storeMenu($instanceId, $menuTypeParams, $itemParams)
    {
        /** @var \Xpressengine\Config\ConfigManager $configManager */
        $configManager = app('xe.config');

        if ($configManager->get($this->getId()) === null) {
            $configManager->add($this->getId(), []);
        }

        $configManager->add($this->getId() . '.' . $instanceId, [
            'instanceId' => $instanceId,
            'my_config1' => $menuTypeParams['my_config1'],
            'my_config2' => $menuTypeParams['my_config2'],
        ]);
    }

    /**
     * Return Edit Form View
     *
     * @param string $instanceId to edit instance id
     *
     * @return mixed
     */
    public function editMenuForm($instanceId)
    {
        $config = app('xe.config')->get($this->getId() . '.' . $instanceId);

        return View::make('openseminar_1212::views/menuType/edit', [
            'config' => $config,
        ])->render();
    }

    /**
     * Process to Update
     *
     * @param string $instanceId to update instance id
     * @param array $menuTypeParams for menu type update param array
     * @param array $itemParams except menu type param array
     *
     * @return mixed
     * @internal param $inputs
     *
     */
    public function updateMenu($instanceId, $menuTypeParams, $itemParams)
    {
        /** @var \Xpressengine\Config\ConfigManager $configManager */
        $configManager = app('xe.config');

        $configManager->put($this->getId() . '.' . $instanceId, [
            'instanceId' => $instanceId,
            'my_config1' => $menuTypeParams['my_config1'],
            'my_config2' => $menuTypeParams['my_config2'],
        ]);
    }

    /**
     * summary
     *
     * @param string $instanceId to summary before deletion instance id
     *
     * @return string
     */
    public function summary($instanceId)
    {
        // TODO: Implement summary() method.
    }

    /**
     * Process to delete
     *
     * @param string $instanceId to delete instance id
     *
     * @return mixed
     */
    public function deleteMenu($instanceId)
    {
        // TODO: Implement deleteMenu() method.
    }
}
