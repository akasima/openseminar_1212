<?php
namespace Akasima\OpenSeminar\Model;

use Xpressengine\Database\Eloquent\DynamicModel;

class Point extends DynamicModel
{
    protected $table = 'point';
    protected $primaryKey = 'userId';
}
