<?php
namespace Akasima\OpenSeminar\Controller;

use Akasima\OpenSeminar\Module\MyModule;
use App\Http\Controllers\Controller;
use Presenter;
use Redirect;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        Presenter::setSkin(MyModule::getId());
    }

    public function index()
    {
        return Presenter::make('index', [
        ]);
//        return Presenter::make('openseminar_1212::views/user/index', [
//        ]);
    }

    public function show($url, $id)
    {
        return Presenter::make('show', [
            'id' => $id,
        ]);
//        return Presenter::make('openseminar_1212::views/user/show', [
//            'id' => $id,
//        ]);
    }

}
