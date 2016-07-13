<?php
namespace Akasima\OpenSeminar;

use Auth;
use Route;
use Schema;
use XeFrontend;
use XePresenter;
use Illuminate\Database\Schema\Blueprint;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Http\Request;
use Xpressengine\Plugin\AbstractPlugin;
use Akasima\OpenSeminar\Model\Point;
use Akasima\OpenSeminar\Model\PointLog;
use Xpressengine\Plugins\Board\Models\Board;
use Xpressengine\Plugins\Comment\Handler as CommentHandler;
use Xpressengine\Plugins\Board\Handler as BoardHandler;
use Xpressengine\Plugins\Comment\Models\Comment;
use Xpressengine\User\UserInterface;

/**
 * pr test
 */
class Plugin extends AbstractPlugin
{
    /**
     * 이 메소드는 활성화(activate) 된 플러그인이 부트될 때 항상 실행됩니다.
     *
     * @return void
     */
    public function boot()
    {
        $this->route();

        $this->registerSettingsMenu();

        $this->registerCommand();

        $this->pointInterception();

    }

    protected function registerCommand()
    {
        $commands = [Command\RemoveLog::class];
        app('events')->listen('artisan.start', function ($artisan) use ($commands) {
            $artisan->resolveCommands($commands);
        });
    }

    protected function registerSettingsMenu()
    {
        app('xe.register')->push('settings/menu', 'contents.point', [
            'title' => '포인트',
            'display' => true,
            'description' => 'blur blur~',
            'link' => route('manage.openseminar_1212.point_log'),
            'ordering' => 3001
        ]);
    }

    /**
     * 댓글 등록 시 글 작성자에게 이메일 발송
     * 인터셉셥 사용
     *
     * @see http://xpressengine.io/docs/3.0/Interception#사용법
     * @see http://xpressengine.io/plugin/xe_aoplist
     * @return void
     */
    protected function pointInterception()
    {
        // 게시물 등록 인터셉트
        intercept(
            BoardHandler::class . '@add',
            static::getId() . '::board.add',
            function ($addFunc, array $args, UserInterface $user, ConfigEntity $config) {
                /** @var Board $board */
                $board = $addFunc($args, $user, $config);

                $pointLog = new PointLog();
                $pointLog->userId = $user->getId();
                $pointLog->point = 2;

//            관리자에서 설정한 값으로 사용하도록
//            $config = app('xe.config')->get('openseminar');
//            $pointLog->point = $config->get('document_point');

                $pointLog->createdAt = date('Y-m-d H:i:s');
                $pointLog->save();

                $point = Point::find($user->getId());
                if ($point === null) {
                    $point = new Point();
                }
                $point->userId = $user->getId();
                $point->point = $pointLog->where('userId', $user->getId())->sum('point');
                $point->save();

                return $board;
            }
        );

        // 댓글 등록 인터셉트트
       intercept(
            CommentHandler::class . '@create',
            static::getId() . '::comment.add',
            function ($addFunc, array $inputs, UserInterface $user = null) {
                /** @var Comment $comment */
                $comment = $addFunc($inputs, $user);

                if ($user == null) {
                    $user = Auth::user();
                }

                $pointLog = new PointLog();
                $pointLog->userId = $user->getId();
                $pointLog->point = 1;

//            관리자에서 설정한 값으로 사용하도록
//            $config = app('xe.config')->get('openseminar');
//            $pointLog->point = $config->get('comment_point');

                $pointLog->createdAt = date('Y-m-d H:i:s');
                $pointLog->save();

                $point = Point::find($user->getId());
                if ($point === null) {
                    $point = new Point();
                }
                $point->userId = $user->getId();
                $point->point = $pointLog->where('userId', $user->getId())->sum('point');
                $point->save();

                return $comment;
            }
        );
    }

    protected function route()
    {
        // implement code
        Route::settings(self::getId(), function () {
            Route::get('/', ['as' => 'manage.openseminar_1212.index', 'uses' => 'ManagerController@index']);
            Route::post('/', ['as' => 'manage.openseminar_1212.updateConfig', 'uses' => 'ManagerController@updateConfig']);
            Route::get('/pointLog', ['as' => 'manage.openseminar_1212.point_log', 'uses' => 'ManagerController@pointLog']);
        }, ['namespace' => 'Akasima\OpenSeminar\Controller']);

        Route::fixed(
            $this->getId(),
            function () {
                Route::get(
                    '/',
                    [
                        'as' => 'openseminar_1212::index',
                        'uses' => function (Request $request) {

                            $title = 'Open seminar 2015-12-12';

                            // set browser title
                            Frontend::title($title);

                            // load css file
                            Frontend::css($this->asset('assets/style.css'))->load();

                            // output
                            return Presenter::make('index', ['title' => $title]);

                        }
                    ]
                );
            }
        );

    }

    /**
     * 플러그인이 활성화될 때 실행할 코드를 여기에 작성한다.
     *
     * @param string|null $installedVersion 현재 XpressEngine에 설치된 플러그인의 버전정보
     *
     * @return void
     */
    public function activate($installedVersion = null)
    {
        // implement code
        parent::activate($installedVersion);
    }

    /**
     * 플러그인을 설치한다. 플러그인이 설치될 때 실행할 코드를 여기에 작성한다
     *
     * @return void
     */
    public function install()
    {
        // implement code
		// #1 plugin 에서 테이블 생성은 Migration 을 사용하지 않고 Schema 직접 사용
		$this->createTables();

        parent::install();
    }

	protected function createTables()
	{
        if (Schema::hasTable('points') === false) {
            Schema::create('points', function (Blueprint $table) {
                $table->string('userId', 255);
                $table->string('point', 255);
                $table->timestamp('createdAt');
                $table->timestamp('updatedAt');

                $table->primary(array('userId'));
            });
        }

        if (Schema::hasTable('point_logs') === false) {
            Schema::create('point_logs', function (Blueprint $table) {
                $table->increments('id');
                $table->string('userId', 255);
                $table->string('point', 255);
                $table->timestamp('createdAt');
            });
        }
	}

    /**
     * 해당 플러그인이 설치된 상태라면 true, 설치되어있지 않다면 false를 반환한다.
     * 이 메소드를 구현하지 않았다면 기본적으로 설치된 상태(true)를 반환한다.
     *
     * @param string $installedVersion 이 플러그인의 현재 설치된 버전정보
     *
     * @return boolean 플러그인의 설치 유무
     */
    public function checkInstall($installedVersion = null)
    {
        // implement code
        return parent::checkInstall($installedVersion);
    }

    /**
     * 플러그인을 업데이트한다.
     *
     * @param string|null $installedVersion 현재 XpressEngine에 설치된 플러그인의 버전정보
     *
     * @return void
     */
    public function update($installedVersion = null)
    {
        // implement code
        parent::update($installedVersion);
    }

    public function getSettingsURI()
    {
        return route('manage.openseminar_1212.index');
    }
}
