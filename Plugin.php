<?php

namespace Plugin\AutomaticAction;

use Core\Plugin\Base;

class Plugin extends Base
{
    public function initialize()
    {
        $this->action->extendActions(
            '\Plugin\AutomaticAction\Action\SendSlackMessage', // Use absolute namespace
            t('Send a message to Slack when the task color change')
        );
    }
}
