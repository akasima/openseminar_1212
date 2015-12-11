<?php
namespace Akasima\OpenSeminar\Skin;

use Xpressengine\Skin\AbstractSkin;
use View;

class DefaultSkin extends AbstractSkin
{
    public function render()
    {
        return View::make('openseminar_1212::views/user/' . $this->view, $this->data);
    }
}
