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

?>
<div class="registration<?php echo $this->pageclass_sfx; ?>">
	<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
		<h2>Cadastro de Usuário</h2>
		Campos marcados com <span class="star">*</span> são obrigatórios.<br/><br/>

		<div class='row'>
			<div class="col-sm-6">
				<!-- Campos padrão-->
				<?php 
				$urs_fields= ['name','username','password1','password2','email1','email2', 'captcha'];

				foreach ($urs_fields as $urs_field_name) :
					$field=$this->form->getFieldXml($urs_field_name);
					$required_class='';
					$required_attr='';
					$required_txt='';

					if ($field[required]=true){
						$required_class='required';
						$required_attr='required="required" aria-required="true"';
						$required_txt='<span class="star">&nbsp;*</span>';
					}
					?>

					<div class="form-group">
						<label for="jform_<?php echo $urs_field_name;?>"><?php echo JText::_($field['label']) .$required_txt; ?>
						<?php if (!empty($field['description'])){ ?>
							<spam data-toggle="tooltip" data-placement="right" title="<?php echo JText::_($field['description']); ?>"><small><i class="fas fa-question-circle"></i></small></spam>
						<?php } ?>
					</label>
					<?php if ($urs_field_name==="captcha"){

						echo $this->form->getInput($urs_field_name);

					} else{ ?>
					<input type="<?php echo $field['type'];?>" class="form-control <?php echo $required_class;?>" id="jform_<?php echo $urs_field_name;?>" name="jform[<?php echo $urs_field_name;?>]" placeholder="" <?php echo $required_attr;?>>
				<?php } ?>

				</div>

			<?php endforeach;?>
		</div>

		<div class="col-sm-6">
			<!-- Campos personalizados-->
			<?php 

			$new_fields= ['cpf','telefone','prefeitura','entidadenit','cargo'];

			foreach ($new_fields as $new_field_name) :
				$field=$this->form->getFieldXml($new_field_name,'com_fields');
				$field_form=$this->form->getInput($new_field_name,'com_fields');

				$required_class='';
				$required_attr='';
				$required_txt='';

				if ($field[required]=true){
					$required_class='required';
					$required_attr='required="required" aria-required="true"';
					$required_txt='<span class="star">&nbsp;*</span>';
				}
				else{
					$required_class='';
					$required_attr='';
					$required_txt='';
				}
				?>

				<div class="form-group">
					<label for="jform_com_fields_<?php echo $new_field_name;?>"><?php echo $field['label'] .$required_txt; ?>
					<?php if (!empty($field['description'])){ ?>
						<spam data-toggle="tooltip" data-placement="right" title="<?php echo JText::_($field['description']); ?>"><small><i class="fas fa-question-circle"></i></small></spam>
					<?php } ?>

				</label>

				<?php if($new_field_name=="prefeitura"){ ?>
					<div class="row">
						<div class="col-sm-6">
							<select class="form-control" id="jform_com_fields_prefeitura2" val="">
								<option hidden selected>Selecione uma opção</option>
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
										foreach ($opcoes as $opcao):?>
											<option value="<?php echo $opcao;?>"> <?php echo $opcao;?></option>
										<?php endforeach;?>
									</optgroup>
									<optgroup label="Outras">
									<option value="SEAPEC">Secretaria de Agricultura, Pecuária, Pesca e Abastecimento - Gov. RJ</option>
									<option value="Outra">Outra Prefeitura</option>
								</optgroup>

								</select>
							</div>
							<div class="col-sm-6">
								<input type="<?php echo $field['type'];?>" class="form-control <?php echo $required_class;?>" id="jform_com_fields_<?php echo $new_field_name;?>" name="jform[com_fields][<?php echo $new_field_name;?>]" placeholder="" <?php echo $required_attr;?> >
							</div>
						</div>
						<?php 
						}
						else{
							echo $field_form;
						}
						?>
					</div>

				<?php endforeach;?>



			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary validate">
					<?php echo JText::_('JREGISTER'); ?>
				</button>
				<a class="btn" href="<?php echo JRoute::_(''); ?>" title="<?php echo JText::_('JCANCEL'); ?>">
					<?php echo JText::_('JCANCEL'); ?>
				</a>
				<input type="hidden" name="option" value="com_users" />
				<input type="hidden" name="task" value="registration.register" />
			</div>
		</div>
		<?php echo JHtml::_('form.token'); ?>

	</form>
</div>


<script type="text/javascript">
	(function ($) {	
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip()


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

			$('#jform_com_fields_prefeitura').attr('readonly', true);
			$("#jform_com_fields_prefeitura").parent().hide();
			$("#jform_com_fields_entidadenit").parent().hide();




		});
	})(jQuery);
</script>