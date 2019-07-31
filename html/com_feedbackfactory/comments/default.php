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

JHtml::stylesheet('media/com_feedbackfactory/assets/frontend/css/stylesheet.css');

?>

<a name="comments"></a>

<?php if (!$this->items): ?>
    <p><?php echo FactoryText::_('comments_no_comment_found'); ?></p>
<?php else: ?>
    <div class="comments">
        <?php foreach ($this->items as $item): ?>
            <div class="comment">
                <div class="avatar float-left mr-3">
                    <img src="<?php echo $this->getAvatarSource($item->user_id, $item->email); ?>" class="img-thumbnail"/>
                </div>

                <div class="card user">
                    <div class="card-body content">
                        <?php echo JHtml::_('FeedbackFactory.nl2p', $item->content); ?>
                    </div>

                    <div class="card-footer details">
                        <span class="user">
                          <?php echo $item->name; ?>
                        </span>

                                    <small class="muted text-muted">
                          <i class="fas fa-clock"> </i> <?php echo JHtml::_('date', $item->created_at); ?>
                        </small>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="pagination">
        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
<?php endif; ?>
