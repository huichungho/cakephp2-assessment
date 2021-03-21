<div class="row-fluid">

    <div class="alert alert-info">
		<h3>Migration File Upload</h3>
		<br>*Assumptions:
		<br>Member #no only saves numeric value
	</div>

</div>

<?php
echo $this->Form->create('Member', array('type' => 'file'));
echo $this->Form->input('file', array('type' => 'file','required'=>true));
echo $this->Form->submit('Upload', array('class' => 'btn btn-primary'));
echo $this->Form->end();

?>

<script>
</script>
