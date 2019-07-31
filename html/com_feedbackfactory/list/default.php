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

if (3 === (int)\Joomla\CMS\Version::MAJOR_VERSION) {
    JHtml::_('formbehavior.chosen', 'select');
}

JHtml::script('media/com_feedbackfactory/assets/frontend/js/views/list.js');

?>

<div class="feedbackfactory-view feedbackfactory-view-<?php echo $this->getName(); ?>">

    <h2><?php echo $this->title; ?></h2>

    {module 134}

    <?php if ($this->form): ?>
        <form action="<?php echo $this->action; ?>" method="get" data-form="filters" class="filters">
            <div class="form-row ">
                <?php foreach ($this->form->getFieldset('filter') as $field): ?>
                    <div class="auto">
                        <?php echo $field->input; ?>
                    </div>
                <?php endforeach; ?>

                <?php if ($this->form->getData()->toArray()): ?>
                <a href="#" style="vertical-align: middle;" data-filter="reset" class="muted text-muted"><i class="fas fa-times"></i><?php echo FactoryText::_('list_filters_clear'); ?></a>
            <?php endif; ?>
        </div>
    </form>
<?php endif; ?>

<div class="card border-light" >

    <?php if ($this->items && $this->listSort): ?>
        <div class="card-header">
            <?php

            $items=$this->listSort;
            $filter=$this->filter;
            $extraQuery=$this->extraQuery;
            foreach ($items as $dir => $label):

                $uri = clone JUri::getInstance();
                $arrow = '';

                if ($dir === $filter['dir']) {
                    $arrow = '<i class="fas fa-sort-'. ('asc' === $filter['sort'] ? 'up' : 'down') .'"></i>';
                    $sort = ('asc' === $filter['sort'] ? 'desc' : 'asc');
                } else {
                    $sort = $filter['sort'];
                }

                $query = $uri->getQuery(true);
                $query['filter']['dir'] = $dir;
                $query['filter']['sort'] = $sort;

                $query += $extraQuery;

                $uri->setQuery($query);
                $float="right";
                if($dir==="votes")
                    $float="left";
                ?>
                <div class="float-<?php echo $float;?>">
                    <a href="<?php echo $uri->toString();?>" class="px-2"><?php echo $label;?> <?php echo $arrow;?></a>
                </div>

            <?php endforeach;
            ?>
        </div>
    <?php endif; ?>

    <?php 
    $items=$this->items;
    $pagination=$this->pagination;
    $config=$this->config;
    $name=$this->getName();
    $display=$this->display;
    ?>
    <div class="list-group">
        <?php foreach ($items as $item): ?>
            <div class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="row">
                    
                    <div class="col-md-2 text-center">
                        <?php echo JHtml::_('FeedbackFactoryList.votes', $item->votes); ?>
                        <?php echo JHtml::_('FeedbackFactoryList.voteButton', array(
                            'configuration'  => $config,
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
                            <?php echo JHtml::_('string.truncate', $item->description, 300, true, false); ?>
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
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="pagination">
                <?php echo $pagination->getPagesLinks(); ?>
            </div>

            <?php if (!$items): ?>
                <p><?php echo FactoryText::_($name . '_no_feedback_found'); ?></p>
            <?php endif; ?>

        </div>
