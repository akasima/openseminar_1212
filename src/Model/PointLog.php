<?php
namespace Akasima\OpenSeminar\Model;

use Xpressengine\Database\Eloquent\DynamicModel;

class PointLog extends DynamicModel
{
    protected $table = 'point_log';
    public $timestamps = false;
}
