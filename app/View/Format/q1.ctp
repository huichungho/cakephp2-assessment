
<div id="message1">


<?php echo $this->Form->create('Type',array('id'=>'form_type','type'=>'file','class'=>'','method'=>'POST','url'=>'/Format/q1_result','autocomplete'=>'off','inputDefaults'=>array(
				
				'label'=>false,'div'=>false,'type'=>'text','required'=>false)))?>
	
<?php echo __("Hi, please choose a type below:")?>
<br><br>

<?php $options_new = array(

		// Pop-up
 		// 'Type1' => __('<span class="showDialog" data-id="dialog_1" style="color:blue">Type1</span><div id="dialog_1" class="hide dialog" title="Type 1">
 		// 		<span style="display:inline-block"><ul><li>Description .......</li>
 		// 		<li>Description 2</li></ul></span>
 		// 		</div>'),
		// 'Type2' => __('<span class="showDialog" data-id="dialog_2" style="color:blue">Type2</span><div id="dialog_2" class="hide dialog" title="Type 2">
 		// 		<span style="display:inline-block"><ul><li>Desc 1 .....</li>
 		// 		<li>Desc 2...</li></ul></span>
 		// 		</div>')


		// Tooltip

		'Type1' => __('<a class="tool_tip" style="color:blue" href="#" data-toggle="hover" 
			data-content="⏺ Description 1...">Type1</a>
			'),
		'Type2' => __('<a class="tool_tip" style="color:blue" href="#" data-toggle="hover" 
			data-content="⏺ Description 2...">Type2</a>
			'),

		);?>

<?php echo $this->Form->input('type', array('legend'=>false, 'type' => 'radio', 'options'=>$options_new,'before'=>'<label class="radio line notcheck">','after'=>'</label>' ,'separator'=>'</label><label class="radio line notcheck">'));?>

<?php echo $this->Form->submit('Save', array('class' => 'btn btn-primary pull-right')); ?>
<?php echo $this->Form->end();?>

</div>

<style>

.tool_tip {

	/* prevent disappear right after popup */
	padding-right: 3px;
}

.showDialog:hover{
	text-decoration: underline;
}

#message1 .radio{
	vertical-align: top;
	font-size: 13px;
}

.control-label{
	font-weight: bold;
}

.wrap {
	white-space: pre-wrap;
}

</style>

<?php $this->start('script_own')?>
<script>

$(document).ready(function(){

	// Pop-up

	// $(".dialog").dialog({
	// 	autoOpen: false,
	// 	width: '500px',
	// 	modal: true,
	// 	dialogClass: 'ui-dialog-blue'
	// });

	
	// $(".showDialog").click(function(){ var id = $(this).data('id'); $("#"+id).dialog('open'); });




	// Tooltip
	// $('[data-toggle="popover"]').mouseOver();
	$('[data-toggle="hover"]').popover({ trigger: "hover" });
})


</script>
<?php $this->end()?>