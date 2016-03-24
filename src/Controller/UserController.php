<?php
namespace Akasima\OpenSeminar\Controller;

use XePresenter;
use Redirect;
use Akasima\OpenSeminar\Module\MyModule;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        XePresenter::setSkinTargetId(MyModule::getId());
    }

    public function index()
    {
        return XePresenter::make('index', [
        ]);
    }

    public function show($url, $id)
    {
        return XePresenter::make('show', [
            'id' => $id,
        ]);
    }

}
