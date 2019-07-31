<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('bootstrap.tooltip');


// Load user_profile plugin language
$lang = JFactory::getLanguage();
$lang->load('plg_user_profile', JPATH_ADMINISTRATOR);
$data = $this->form->getData();
?>


<div class="profile-edit<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
		</div>
	<?php endif; ?>
	<script type="text/javascript">
		Joomla.twoFactorMethodChange = function(e)
		{
			var selectedPane = 'com_users_twofactor_' + jQuery('#jform_twofactor_method').val();

			jQuery.each(jQuery('#com_users_twofactor_forms_container>div'), function(i, el)
			{
				if (el.id != selectedPane)
				{
					jQuery('#' + el.id).hide(0);
				}
				else
				{
					jQuery('#' + el.id).show(0);
				}
			});
		}
	</script>

	<form id="member-profile" action="<?php echo JRoute::_('index.php?option=com_users&task=profile.save'); ?>" method="post" class="form-validate form-horizontal " enctype="multipart/form-data">
		<div class="row">
			
			<?php foreach ($this->form->getFieldsets() as $group => $fieldset) : ?>
				<?php $fields = $this->form->getFieldset($group); ?>
				<?php if (count($fields)) : ?>
					<div class="col-sm-6">
						<?php foreach ($fields as $field) : ?>
							<?php // If the field is hidden, just display the input. ?>
							<?php if ($field->hidden) : ?>
								<?php echo $field->input; ?>
								<?php else : ?>
									
									<div class="form-group">
										<label>
											<?php echo $field->label; ?>
											<?php if (!$field->required && $field->type !== 'Spacer' && $field->fieldname !="username" && $field->fieldname !="entidadenit" && $field->fieldname !="cargo" && $field->fieldname !="prefeitura" ) : ?>
												<span class="optional">
													<?php echo JText::_('COM_USERS_OPTIONAL'); ?>
												</span>
											<?php endif; ?>
										</label>

										<?php if ($field->fieldname === 'password1') : ?>
											<?php // Disables autocomplete ?>
											<input type="password" style="display:none">
										<?php endif; ?>
										<?php 
										if ($field->fieldname === 'prefeitura'){
											$val='';
											$val2='';
											$outra='';
											$vazio='';
											if (($data['com_fields']!=null) && array_key_exists("prefeitura",$data['com_fields'])){
												$val=$data['com_fields']->prefeitura;
												$val2=$data['com_fields']->prefeitura;
											}
											else{
												$vazio='selected';
											}
											if ($val=='Outra'){
												$val='';
												$val2=$data['com_fields']->prefeitura;
												$outra='selected';
											}

											?>
											<div class="row">
												<div class="col-sm-6">
													<select class="form-control" id="jform_com_fields_prefeitura2">
														<option hidden <?php echo $vazio;?>>Selecione uma opção</option>
														<optgroup>
															<option value="Niterói">Niterói</option>
														</optgroup>
														<optgroup label="Municípios do CONLESTE">
															<?php $opcoes=[
																'Araruama',
																'Cachoeira de Macacu',
																'Casimiro de Abreu',
																'Guapimirim', 
																'Itaboraí',
																'Magé',
																'Maricá',
																'Niterói',
																'Nova Friburgo',
																'Rio Bonito',
																'São Gonçalo', 
																'Saquarema', 
																'Silva Jardim', 
																'Tanguá',
																'Teresopólis'];
																foreach ($opcoes as $opcao):
																	$selecionada='';
																	if($val==$opcao) $selecionada='selected';
																	?>
																	<option value="<?php echo $opcao;?>" <?php echo $selecionada;?>> <?php echo $opcao;?></option>
																<?php endforeach;?>

															</optgroup>
															<optgroup label="Outras">
									<option value="SEAPEC">Secretaria de Agricultura, Pecuária, Pesca e Abastecimento - Gov. RJ</option>
									<option value="Outra">Outra Prefeitura</option>
								</optgroup>
														</select>
													</div>
													<div class="col-sm-6">
														<input type="<?php echo $field->type;?>" class="form-control" id="jform_com_fields_<?php echo $field->fieldname;?>" name="jform[com_fields][<?php echo $field->fieldname;?>]" placeholder="" value="<?php echo $val2;?>">
													</div>
												</div>
												<?php 
												}
												else{
													echo $field->input;
												} ?>


											</div>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
						<?php if (count($this->twofactormethods) > 1) : ?>
							<fieldset>
								<legend><?php echo JText::_('COM_USERS_PROFILE_TWO_FACTOR_AUTH'); ?></legend>
								<div class="control-group">
									<div class="control-label">
										<label id="jform_twofactor_method-lbl" for="jform_twofactor_method" class="hasTooltip"
										title="<?php echo '<strong>' . JText::_('COM_USERS_PROFILE_TWOFACTOR_LABEL') . '</strong><br />' . JText::_('COM_USERS_PROFILE_TWOFACTOR_DESC'); ?>">
										<?php echo JText::_('COM_USERS_PROFILE_TWOFACTOR_LABEL'); ?>
									</label>
								</div>
								<div class="controls">
									<?php echo JHtml::_('select.genericlist', $this->twofactormethods, 'jform[twofactor][method]', array('onchange' => 'Joomla.twoFactorMethodChange()'), 'value', 'text', $this->otpConfig->method, 'jform_twofactor_method', false); ?>
								</div>
							</div>
							<div id="com_users_twofactor_forms_container">
								<?php foreach ($this->twofactorform as $form) : ?>
									<?php $style = $form['method'] == $this->otpConfig->method ? 'display: block' : 'display: none'; ?>
									<div id="com_users_twofactor_<?php echo $form['method']; ?>" style="<?php echo $style; ?>">
										<?php echo $form['form']; ?>
									</div>
								<?php endforeach; ?>
							</div>
						</fieldset>
						<fieldset>
							<legend>
								<?php echo JText::_('COM_USERS_PROFILE_OTEPS'); ?>
							</legend>
							<div class="alert alert-info">
								<?php echo JText::_('COM_USERS_PROFILE_OTEPS_DESC'); ?>
							</div>
							<?php if (empty($this->otpConfig->otep)) : ?>
								<div class="alert alert-warning">
									<?php echo JText::_('COM_USERS_PROFILE_OTEPS_WAIT_DESC'); ?>
								</div>
								<?php else : ?>
									<?php foreach ($this->otpConfig->otep as $otep) : ?>
										<span class="span3">
											<?php echo substr($otep, 0, 4); ?>-<?php echo substr($otep, 4, 4); ?>-<?php echo substr($otep, 8, 4); ?>-<?php echo substr($otep, 12, 4); ?>
										</span>
									<?php endforeach; ?>
									<div class="clearfix"></div>
								<?php endif; ?>
							</fieldset>
						<?php endif; ?>
						<div class="control-group">
							<div class="controls">
								<button type="submit" class="btn btn-primary validate">
									<?php echo JText::_('JSUBMIT'); ?>
								</button>
								<a class="btn" href="<?php echo JRoute::_('index.php?option=com_users&view=profile'); ?>" title="<?php echo JText::_('JCANCEL'); ?>">
									<?php echo JText::_('JCANCEL'); ?>
								</a>
								<input type="hidden" name="option" value="com_users" />
								<input type="hidden" name="task" value="profile.save" />
							</div>
						</div>
						<?php echo JHtml::_('form.token'); ?>
					</div>
				</form>
			</div>



			<script type="text/javascript">
				(function ($) {	
					$(document).ready(function() {



						$('#jform_com_fields_cpf').mask('000.000.000-00', {placeholder: "___.___.___-___"});

						var telMaskBehavior = function (val) {
							return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
						},
						spOptions = {
							onKeyPress: function(val, e, field, options) {
								field.mask(telMaskBehavior.apply({}, arguments), options);
							}

						};

						$('#jform_com_fields_telefone').mask(telMaskBehavior, spOptions);


						$("#jform_username").parent().hide();
						$("#jform_email2").parent().hide();
						$("#jform_email1").on("change paste keyup", function() {
							$("#jform_email2").val($(this).val()).change(); 
						});

						$("#jform_com_fields_prefeitura2").on("change paste keyup", function() {
							$("#jform_com_fields_prefeitura").val($(this).val()).change(); 

							if($("#jform_com_fields_prefeitura2").val()!="Outra"){
								$('#jform_com_fields_prefeitura').attr('readonly', true);
								$("#jform_com_fields_prefeitura").parent().hide();
							}
							else{
								$('#jform_com_fields_prefeitura').removeAttr('readonly');
								$("#jform_com_fields_prefeitura").parent().show();
								$("#jform_com_fields_prefeitura").val("").change();
							}

							if($("#jform_com_fields_prefeitura2").val()=="Niterói"){
								$("#jform_com_fields_entidadenit").parent().show();
							}
							else{
								$("#jform_com_fields_entidadenit").parent().hide();
								$("#jform_com_fields_entidadenit").val("Nao trabalho na Prefeitura Municipal de Niteroi").change();
							}
						});

						if($("#jform_com_fields_prefeitura2").val()!="Outra"){
							$('#jform_com_fields_prefeitura').attr('readonly', true);
							$("#jform_com_fields_prefeitura").parent().hide();
						}
						else{
							$('#jform_com_fields_prefeitura').removeAttr('readonly');
							$("#jform_com_fields_prefeitura").parent().show();
						}

						if($("#jform_com_fields_prefeitura2").val()=="Niterói"){
							$("#jform_com_fields_entidadenit").parent().show();
						}
						else{
							$("#jform_com_fields_entidadenit").parent().hide();
						}



					});
				})(jQuery);
			</script>