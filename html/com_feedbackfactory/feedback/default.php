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
$item= $this->feedback;
?>

<div class="feedbackfactory-view feedbackfactory-view-<?php echo $this->getName(); ?>">
    <div class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="row">

            <div class="col-md-2 text-center">
                <?php echo JHtml::_('FeedbackFactoryList.votes', $item->votes); ?>
                <?php echo JHtml::_('FeedbackFactoryList.voteButton', array(
                    'configuration'  => $this->config,
                    'feedback_id'    => $item->id,
                    'last_voted_on'  => $item->last_voted_on,
                    'status_votable' => $item->status_votable,
                )); ?>
            </div>

            <div class="col-md-10">
                <h5>
                    <a href="<?php echo FactoryRoute::view('feedback&id=' . (int)$item->id); ?>">
                        <?php echo $item->title; ?>
                    </a>
                </h5>

                <div class="description">
                    <?php echo $item->description; ?>
                </div>
                <hr class="my-0">
                <div >
                    <?php if (!isset($display['status']) || false !== $display['status']): ?>
                        <?php echo JHtml::_('FeedbackFactory.renderStatus', $item->status_label, $item->status_title, $item->status_description); ?>

                    <?php endif; ?>

                    <?php if (!isset($display['category']) || false !== $display['category']): ?>
                        <small><a href="<?php echo JHtml::_('FeedbackFactoryList.linkCategory', $item->category_id); ?>" class="mx-1">
                            <i class="fas fa-tag"></i> <?php echo $item->category_title; ?></a></small>

                        <?php endif; ?>

                        <?php if ($item->has_comments): ?>
                            <small><a href="<?php echo FactoryRoute::view('feedback&id=' . (int)$item->id); ?>#comments" class="mx-1">
                                <i class="fas fa-comments"></i> <?php echo FactoryText::plural('feedback_comments', $item->comments); ?></a></small>

                            <?php endif; ?>

                            <small class="mx-1"> <i class="fas fa-user"></i> <?php echo JHtml::_('FeedbackFactoryList.renderUsername', $item->username); ?></small>
                            <small class="mx-1"><i class="fas fa-clock"> </i><?php echo JHtml::_('date', $item->created_at); ?></small>

                        </div>

                    </div>


                </div></div>

                <?php if ($this->feedback->has_comments): ?>
                    <div class="comments">
                        <div class="list-comments">
                            <h5><?php echo FactoryText::_('feedback_comments_list'); ?></h5>

                            <?php echo $this->comments->display(); ?>
                        </div>
                        <div class="add-comment">
                            <h5><?php echo FactoryText::_('feedback_comments_submit'); ?></h5>

                            <?php echo $this->comment->display(); ?>
                        </div>
                    </div>
                    <?php else: ?>
                        <p class="comments_disabled muted text-muted"><?php echo FactoryText::_('feedback_comments_disabled'); ?></p>
                    <?php endif; ?>
                </div>
