<div class="alert  ">
<button class="close" data-dismiss="alert"></button>
Question: Advanced Input Field</div>

<p>
1. Make the Description, Quantity, Unit price field as text at first. When user clicks the text, it changes to input field for use to edit. Refer to the following video.

</p>


<p>
2. When user clicks the add button at left top of table, it wil auto insert a new row into the table with empty value. Pay attention to the input field name. For example the quantity field

<?php echo htmlentities('<input name="data[1][quantity]" class="">')?> ,  you have to change the data[1][quantity] to other name such as data[2][quantity] or data["any other not used number"][quantity]

</p>



<div class="alert alert-success">
<button class="close" data-dismiss="alert"></button>
The table you start with <br>*developer note*: (1) database can store and retain blank records. (2) new records's transaction_id will always be 1 to bypass foreign key constrains for testing purposes</div>

<div id="loading"></div>

<table class="table table-outline table-striped table-hover table-bordered">
<thead>
<th><span id="add_item_button" class="btn mini green addbutton" onclick="addToObj=false">
											<i class="icon-plus"></i></span></th>
<th>Description</th>
<th>Quantity</th>
<th>UOM</th>
<th>Unit Price</th>
<th>Amt</th>
</thead>

<tbody></tbody>

</table>

<p></p>
<div class="alert alert-info ">
<button class="close" data-dismiss="alert"></button>
Video Instruction</div>

<p style="text-align:left;">
<video width="78%"   controls>
  <source src="<?php echo Router::url("/video/q3_2.mov") ?>">
Your browser does not support the video tag.
</video>
</p>



<?php $this->start('script_own');?>
<script>

// function to extract text only (without tags)
$.fn.immediateText = function() {
    return this.contents().not(this.children()).text();
};

function editRowTrigger(row) {

	// on click
	$(`tr:nth-child(${row}) td:not(:last-child)`).on('click',  function(){
		const input = $(this).find("input, textarea");
		if (input.css('display') != 'block') {
			const previous_val = $(this).immediateText();
			input.css('display','block');	
			$(this).html($('<div>').append(input.clone()).html());
			$(this).find("input, textarea").val(previous_val);
			$(this).find("input, textarea").focus();
		}
		
	// on loses focus
    }).on('focusout',  function(){
		const input = $(this).children('input, textarea').first();
		input.css('display','none');
		const previous_val = input.val();
		$(this).html($(this).children('input, textarea').first().val() + $('<div>').append(input.clone()).html());

		// calculate amount
		const row   = $(this).parent().index()+1;
		const qty   = $(`tr:nth-child(${row}) td:nth-child(3)`).immediateText();
		const price = $(`tr:nth-child(${row}) td:nth-child(5)`).immediateText();
		const amt   = (qty*price).toFixed(2);

		const desc  = $(`tr:nth-child(${row}) td:nth-child(2)`).immediateText();
		const uom   = $(`tr:nth-child(${row}) td:nth-child(4)`).immediateText();

		// print price to 'Amt' field
		$(`tr:nth-child(${row}) td:nth-child(6)`).html(`$${amt}`);
		// console.log(`row (${row}): quantity = ${qty}, price = ${price}, sum = ${amt}`);

		// save value to db
		const id = $(this).closest('tr').attr('id');
		saveData({
			'id' : row,
			'transaction_id': id,
			'description': desc,
			'uom': uom,
			'quantity': qty,
			'unit_price': price,
			'sum' : amt
		});
	});

}

function deleteRowTrigger(row) {

	let id = row;
	$(`tr:nth-child(${id}) .col_delete`).click(function(){
		this.closest('tr').remove();
		deleteData(id);
	});
}

function addNewRow(item=null) {

	// alert("suppose to add a new row");
	let row = $("table tr").length;

	if (item != null && item.slotin != null) {
		row = item.slotin;
		item = null;
	}

	if (item != null) {
		row = item.id;

		// format output
		item.quantity = item.quantity == null ? '0.00' : item.quantity;
		item.unit_price = item.unit_price == null ? '0.00' : item.unit_price;
		item.sum = item.sum === null ? '$0.00' : '$'+item.sum;
		item.uom = item.uom === null ? '' : item.uom;

		console.log('adding from db');

		$('table > tbody:last-child').append(`
			<tr id="${item.id}">
				<td class="col_delete"><span class="delete_button">❌</span></td>
				<td class="col_desc">${item.description}<textarea name="data[${row}][description]" class="m-wrap description required" rows="2" ></textarea></td>
				<td class="col_qty">${item.quantity}<input name="data[${row}][quantity]" class=""></td>
				<td class="col_uom">${item.uom}<input name="data[${row}][uom]" class=""></td>
				<td class="col_price">${item.unit_price}<input name="data[${row}][unit_price]" class=""></td>
				<td style="cursor: not-allowed;" class="col_amt">${item.sum}</td>
			</tr>`
		);
		// console.log('dumping in data ' + item.id);
	} else {

		$('table > tbody:last-child').append(`
			<tr id="1">
				<td class="col_delete"><span class="delete_button">❌</span></td>
				<td class="col_desc"><textarea name="data[${row}][description]" class="m-wrap description required" rows="2" ></textarea></td>
				<td class="col_qty"><input name="data[${row}][quantity]" class=""></td>
				<td class="col_uom"><input name="data[${row}][uom]" class=""></td>
				<td class="col_price"><input name="data[${row}][unit_price]" class=""></td>
				<td style="cursor: not-allowed;" class="col_amt"></td>
			</tr>`
		);
	}
	
	registerEvent(row);

	// $("tr").each(function () {
	// 	$(this).removeClass("striped");
	// });

	// $("tr:even").each(function () {
	// 	$(this).addClass("striped");
	// });
}


function registerEvent(row) {
	// register event
	editRowTrigger(row);
	deleteRowTrigger(row);
}

function loadData() {
	console.log('loading data');

	$.ajax({
		url: "/TransactionItem/index",
		type: 'POST',
		dataType: 'json',
		success: function(data){
			// alert("success");
			let counter = 1;
			$.each(data, function(_, item){
				const fx = () => {
					$('div#loading').html(`Loading data from database (${counter})`);

					const eachItem = item.TransactionItem;
					while (counter != eachItem.id) {
						// previously skipped id resulting in empty record in middle
						addNewRow({'slotin': counter});
						counter++;
					}
					addNewRow(eachItem);
					counter++;
				}
				timerid = setTimeout( fx, 100 );
			});
		}
	});
}

function saveData(item) {
	console.log('saving data ');

	$.ajax({
		url: "/TransactionItem/store",
		type: 'POST',
		data: item,
		dataType: 'json',
		success: function(data){
			console.log(data);
		}
	});
}

function deleteData(id) {
	console.log('deleting data ' + id);

	$.ajax({
		url: "/TransactionItem/delete",
		type: 'POST',
		data: {'id':id},
		dataType: 'json',
		success: function(data){
			console.log(data);
		}
	});
}


$(document).ready(function(){

	loadData();

	$("#add_item_button").click(function(){
		addNewRow();
	});

});
</script>

<style>

	.col_desc {
		width:70%;
	}
	.col_qty {
		width:10%;
	}
	.col_price {
		width:10%;
	}
	textarea, input{
		width:98%;
    	display: none;
	}
</style>

<?php $this->end();?>

