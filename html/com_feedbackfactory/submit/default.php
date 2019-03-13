<?php

/**
-------------------------------------------------------------------------
feedbackfactory - Feedback Factory 3.0.8
-------------------------------------------------------------------------
 * @author thePHPfactory
 * @copyright Copyright (C) 2011 SKEPSIS Consult SRL. All Rights Reserved.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * Websites: http://www.thePHPfactory.com
 * Technical Support: Forum - http://www.thePHPfactory.com/forum/
-------------------------------------------------------------------------
*/

defined('_JEXEC') or die;

JHtml::_('formbehavior.chosen', 'select');

JHtml::stylesheet('media/com_feedbackfactory/assets/common/font-awesome/css/font-awesome.min.css');
JHtml::stylesheet('media/com_feedbackfactory/assets/frontend/css/stylesheet.css');

?>

<div class="feedbackfactory-view feedbackfactory-view-<?php echo $this->getName(); ?>">

    <h2><?php echo $this->title; ?></h2>
    
    {module 135}

    <form novalidate="novalidate" action="<?php echo FactoryRoute::task('feedback.submit'); ?>" method="post">

        <div class="row-fluid">
            <div class="span12">
                <?php echo $this->form->renderFieldset('content'); ?>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span6">
                <?php echo $this->form->renderFieldset('details'); ?>
            </div>
            <div class="span6">
                <?php echo $this->form->renderFieldset('notifications'); ?>
            </div>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">
                <?php echo FactoryText::_('feedback_submit_button'); ?>
            </button>

            <span class="small muted text-muted" style="margin-left: 10px;">
                <span class="star" style="margin-right: 3px;">*</span><?php echo FactoryText::_('feedback_submit_marked_fields_info'); ?>
            </span>
        </div>
    </form>
</div>
