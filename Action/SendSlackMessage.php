<?php

namespace Kanboard\Plugin\AutomaticAction\Action;

use Kanboard\Model\Task;
use Kanboard\Action\Base;

/**
 * Send a Slack message when changing the task color
 *
 * @package action
 * @author  Frederic Guillot
 */
class SendSlackMessage extends Base
{
    /**
     * Get the list of compatible events
     *
     * @access public
     * @return array
     */
    public function getCompatibleEvents()
    {
        return array(
            Task::EVENT_UPDATE,
        );
    }

    /**
     * Get the required parameter for the action (defined by the user)
     *
     * @access public
     * @return array
     */
    public function getActionRequiredParameters()
    {
        return array(
            'color_id' => t('Color'),
            'message' => t('Message'),
        );
    }

    /**
     * Get the required parameter for the event
     *
     * @access public
     * @return string[]
     */
    public function getEventRequiredParameters()
    {
        return array(
            'task_id',
            'color_id',
        );
    }

    /**
     * Execute the action
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool            True if the action was executed or false when not executed
     */
    public function doAction(array $data)
    {
        if ($this->slackWebhook->isActivated($this->getProjectId())) {
            $this->slackWebhook->sendMessage($this->getProjectId(), $this->getParam('message'));
            return true;
        }

        return false;
    }

    /**
     * Check if the event data meet the action condition
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool
     */
    public function hasRequiredCondition(array $data)
    {
        return $data['color_id'] == $this->getParam('color_id');
    }
}
