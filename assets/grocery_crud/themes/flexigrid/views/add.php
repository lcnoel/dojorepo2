<script type="text/javascript">
	$(document).ready(function(){

	    $('#field-codmiembro').prop('readonly', true);
        $('#field-codmiembro').prop('placeholder', 'Código de Miembro');

		/*$('#field-dojo').change(function(){
			if($('#field-dojo').val()==""){
				$('#field-codmiembro').val('');
            }else if($('#field-dojo').val()=="Ciudad de Panamá, Panamá"){
                $('#field-codmiembro').val('ABPAPA');
			}else if($('#field-dojo').val()=="David, Chiriquí"){
				$('#field-codmiembro').val('ABPACH');
			}else if($('#field-dojo').val()=="Cartago, Costa Rica"){
				$('#field-codmiembro').val('ABPACA');
			}
		});*/

        $('#field-edad,#field-menor,#field-cumplemes').prop('readonly', true);
		$('#field-edad').click(function(){
			var dob = $('#field-fechanac').val();
			if(dob != '')
			{
				var str=dob.split('-');
				var firstdate=new Date(str[0],str[1],str[2]);
				var mes = firstdate.getMonth();
				var today = new Date();
				var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
				var age = parseInt(dayDiff);
				$('#field-edad').val(age);

				if(age < 18){
					$('#field-menor').val('Sí');
				}else if(age >= 18){
					$('#field-menor').val('No');
				}
				if (mes  == '01'){$('#field-cumplemes').val('Enero');}
				else if (mes  == '02'){$('#field-cumplemes').val('Febrero');}
				else if (mes  == '03'){$('#field-cumplemes').val('Marzo');}
				else if (mes  == '04'){$('#field-cumplemes').val('Abril');}
				else if (mes  == '05'){$('#field-cumplemes').val('Mayo');}
				else if (mes  == '06'){$('#field-cumplemes').val('Junio');}
				else if (mes  == '07'){$('#field-cumplemes').val('Julio');}
				else if (mes  == '08'){$('#field-cumplemes').val('Agosto');}
				else if (mes  == '09'){$('#field-cumplemes').val('Septiembre');}
				else if (mes  == '10'){$('#field-cumplemes').val('Octubre');}
				else if (mes  == '11'){$('#field-cumplemes').val('Noviembre');}
				else if (mes  == '12'){$('#field-cumplemes').val('Diciembre');}
			}
		});
        $('#field-fechanac').change(function(){
			$('#field-edad').val('');
			$('#field-menor').val('');
			$('#field-cumplemes').val('');
		});
	});
</script>
<?php

	$this->set_css($this->default_theme_path.'/flexigrid/css/flexigrid.css');
	$this->set_js_lib($this->default_theme_path.'/flexigrid/js/jquery.form.js');
    $this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.form.min.js');
	$this->set_js_config($this->default_theme_path.'/flexigrid/js/flexigrid-add.js');

	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.noty.js');
	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/config/jquery.noty.config.js');
?>
<div class="flexigrid crud-form" style='width: 100%;' data-unique-hash="<?php echo $unique_hash; ?>">
	<div class="mDiv">
		<div class="ftitle">
			<div class='ftitle-left'>
				<?php echo $this->l('form_add'); ?> <?php echo $subject?>
			</div>
			<div class='clear'></div>
		</div>
		<div title="<?php echo $this->l('minimize_maximize');?>" class="ptogtitle">
			<span></span>
		</div>
	</div>
<div id='main-table-box'>
	<?php echo form_open( $insert_url, 'method="post" id="crudForm"  enctype="multipart/form-data"'); ?>
		<div class='form-div'>
			<?php
			$counter = 0;
				foreach($fields as $field)
				{
					$even_odd = $counter % 2 == 0 ? 'odd' : 'even';
					$counter++;
			?>
			<div class='form-field-box <?php echo $even_odd?>' id="<?php echo $field->field_name; ?>_field_box">
				<div class='form-display-as-box' id="<?php echo $field->field_name; ?>_display_as_box">
					<?php echo $input_fields[$field->field_name]->display_as; ?><?php echo ($input_fields[$field->field_name]->required)? "<span class='required'>*</span> " : ""; ?> :
				</div>
				<div class='form-input-box' id="<?php echo $field->field_name; ?>_input_box">
					<!--<?php echo "TEXTO DE PRUEBA"; ?>-->
					<?php
						if($field->field_name == 'estado'){
					?>
						<select id="field-estado" class="chosen-select" name="estado">
							<option value="Por Aprobar">Por Aprobar</option>
							<option value="Activo">Activo</option>
							<option value="Inactivo">Inactivo</option>
						</select>
					<?php
						}/*elseif($field->field_name == 'codmiembro'){
                            echo check_PA();
                        }*/
                        else{
                            echo $input_fields[$field->field_name]->input;
                        }
                    ?>
				</div>
				<div class='clear'></div>
			</div>
			<?php }?>
			<!-- Start of hidden inputs -->
				<?php
					foreach($hidden_fields as $hidden_field){
						echo $hidden_field->input;
					}
				?>
			<!-- End of hidden inputs -->
			<?php if ($is_ajax) { ?><input type="hidden" name="is_ajax" value="true" /><?php }?>

			<div id='report-error' class='report-div error'></div>
			<div id='report-success' class='report-div success'></div>
		</div>
		<div class="pDiv">
			<div class='form-button-box'>
				<input id="form-button-save" type='submit' value='<?php echo $this->l('form_save'); ?>'  class="btn btn-large"/>
			</div>
<?php 	if(!$this->unset_back_to_list) { ?>
			<div class='form-button-box'>
				<input type='button' value='<?php echo $this->l('form_save_and_go_back'); ?>' id="save-and-go-back-button"  class="btn btn-large"/>
			</div>
			<div class='form-button-box'>
				<input type='button' value='<?php echo $this->l('form_cancel'); ?>' class="btn btn-large" id="cancel-button" />
			</div>
<?php 	} ?>
			<div class='form-button-box'>
				<div class='small-loading' id='FormLoading'><?php echo $this->l('form_insert_loading'); ?></div>
			</div>
			<div class='clear'></div>
		</div>
	<?php echo form_close(); ?>
</div>
</div>
<script>
	var validation_url = '<?php echo $validation_url?>';
	var list_url = '<?php echo $list_url?>';

	var message_alert_add_form = "<?php echo $this->l('alert_add_form')?>";
	var message_insert_error = "<?php echo $this->l('insert_error')?>";
</script>