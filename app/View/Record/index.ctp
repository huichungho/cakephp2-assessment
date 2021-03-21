
<div class="row-fluid">
	<table class="table table-bordered" id="table_records">
		<thead>
			<tr>
				<th>ID</th>
				<th>NAME</th>	
			</tr>
		</thead>
		<tbody>
			<?php foreach($records as $record):?>
			<tr>
				<td><?php echo $record['Record']['id']?></td>
				<td><?php echo $record['Record']['name']?></td>
			</tr>	
			<?php endforeach;?>
		</tbody>
	</table>
	<div class="row pull-right">
		<?php echo $this->Paginator->first(__('<< First', true), array('class' => 'number-first'));?>
		<?php echo $this->Paginator->numbers(array('class' => 'numbers', 'first' => false, 'last' => false));?>
		<?php echo $this->Paginator->last(__('>> Last', true), array('class' => 'number-end'));?>
	</div>
</div>
<?php $this->start('script_own')?>
<script>
$(document).ready(function(){
	$("#table_records").dataTable({
		"paging": false,//Dont want paging 
		"bPaginate": false, //hide pagination
		"bInfo": false, // hide showing entries
	});
})
</script>
<?php $this->end()?>