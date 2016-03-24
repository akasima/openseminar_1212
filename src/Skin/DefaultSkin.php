<?php
namespace Akasima\OpenSeminar\Skin;

use Xpressengine\Skin\AbstractSkin;
use View;

class DefaultSkin extends AbstractSkin
{
    public function render()
    {
        return View::make(sprintf('openseminar_1212::views.user.%s', $this->view), $this->data);
    }
}
