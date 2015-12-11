<?php
namespace Akasima\OpenSeminar\Migration;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class Point implements Migration
{
    /**
     * install
     *
     * @return void
     */
    public function install()
    {
        if (Schema::hasTable('point') === false) {
            Schema::create('point', function (Blueprint $table) {
                $table->string('userId', 255);
                $table->string('point', 255);
                $table->timestamp('createdAt');
                $table->timestamp('updatedAt');

                $table->primary(array('userId'));
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
