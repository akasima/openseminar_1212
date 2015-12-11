<?php
namespace Akasima\OpenSeminar\Migration;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class PointLog implements Migration
{
    /**
     * install
     *
     * @return void
     */
    public function install()
    {
        if (Schema::hasTable('point_log') === false) {
            Schema::create('point_log', function (Blueprint $table) {
                $table->increments('id');
                $table->string('userId', 255);
                $table->string('point', 255);
                $table->timestamp('createdAt');
            });
        }
    }

    /**
     * update
     *
     * @param string $currentVersion version
     * @return void
     */
    public function update($currentVersion)
    {

    }

    /**
     * check install
     *
     * @return void
     */
    public function checkInstall()
    {
    }

    /**
     * check update
     *
     * @param string $currentVersion version
     * @return void
     */
    public function checkUpdate($currentVersion)
    {
    }
}
