<?php
namespace Akasima\OpenSeminar\Controller;

use Akasima\OpenSeminar\Model\PointLog;
use App\Http\Controllers\Controller;
use XePresenter;
use Redirect;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Http\Request;

class ManagerController extends Controller
{

    public function index()
    {
        /** @var \Xpressengine\Config\ConfigManager $configManager */
        $configManager = app('xe.config');
        $config = $configManager->get('openseminar');
        if ($config === null) {
            $config = new ConfigEntity();

            $config->set('document_point', 2);
            $config->set('comment_point', 1);
            $configManager->add('openseminar', $config->getPureAll());
        }

        return XePresenter::make('openseminar_1212::views.manager.index', [
            'config' => $config,
        ]);
    }

    public function updateConfig(Request $request)
    {
        /** @var \Xpressengine\Config\ConfigManager $configManager */
        $configManager = app('xe.config');
        $configManager->put('openseminar', [
            'document_point' => $request->get('document_point'),
            'comment_point' => $request->get('comment_point'),
        ]);

        return Redirect::to(route('manage.openseminar_1212.index'));
    }

    public function pointLog()
    {
        $list = PointLog::orderBy('createdAt', 'desc')->get();

        return XePresenter::make('openseminar_1212::views.manager.pointLog', [
            'list' => $list
        ]);
    }
}
