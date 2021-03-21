<div class="portlet box yellow">
	<div class="portlet-title">
		<div class="caption">
			<?php echo __($title)?>
		</div>
	</div>
	<div class="portlet-body">
		<div class="row-fluid view_info">
			<div class="span12 ">

				<div class="tabbable tabbable-custom tabbable-full-width">
					<ul class="nav nav-tabs">

						<li class="active"><a href="#tab_item" data-toggle="tab"><b><i><?php echo __('Orders Report')?></i></b>
						</a></li>
						<li class=""><a href="#tab_order" data-toggle="tab"><?php echo __('Order Dishes')?>
						</a></li>
						<li class=""><a href="#tab_portion" data-toggle="tab"><?php echo __('Dishes Ingredients')?>
						</a></li>


					</ul>

					<div class="tab-content">
						
						<!-- tab 1 - Ingredients -->

						<div class="tab-pane row-fluid active" id="tab_item">

							<div class="row-fluid">
								<table class="table table-bordered dataTable" id="table_orders">
									<thead>
										<tr>
											<th style="width:10%">S/N</th>
											<th colspan="2">Order Name</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach($order_reports as $k => $order_report):?>
										<tr class="item_tr" style="background-color:#fff;">
											<td><span class="row-details row-details-close"></span></td>
											<td colspan="2"><?php echo $k?></td>
										</tr>
										<tr class="hide">
											<td></td>
											<td colspan="2">
												<table style="width:100%">
													<thead>
														<tr>
															<th style="border-left:none;width:50%">Part Name</th>
															<th>Value</th>
														</tr>
													</thead>
													<tbody>
													<?php foreach($order_report as $q => $val):?>
														<tr>
															<td style="border-left:none;width:50%"><?php echo $q?></td>
															<td><?php echo $val?></td>
														</tr>
													<?php endforeach;?>
													</tbody>
												</table>
											</td>
										</tr>
									<?php endforeach;?>
									</tbody>
								</table>
							</div>
						</div>

						<!-- tab 2 - dished -->

						<div class="tab-pane row-fluid" id="tab_order">

							<div class="portlet box green">
								<div class="portlet-title">
									<div class="caption">
										<?php echo __('Orders')?>
									</div>
								</div>
								<div class="portlet-body">
									<div class="row-fluid view_info">
										<div class="span12 ">
											<div class="row-fluid">
												<table class="table table-bordered" id="table_orders">
													<thead>
														<tr>
															<th style="width:10%">ID</th>
															<th>NAME</th>
															<th style="width:25%">Action (click to view order details)</th>		
														</tr>
													</thead>
													<tbody>
														<?php foreach($orders as $order):?>
														<tr>
															<td style="width:10%"><?php echo $order['Order']['id']?></td>
															<td><?php echo $order['Order']['name']?></td>
															<td style="width:20%"><?php echo $this->Html3->link('View Detail','/Order/view/'.$order['Order']['id'])?></td>
														</tr>	
														<?php endforeach;?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>

						<!-- dishes ingredients -->

						<div class="tab-pane row-fluid" id="tab_portion">

							<div class="portlet box green">
								<div class="portlet-title">
									<div class="caption">
										<?php echo __('Portions of Dishes')?>
									</div>
								</div>
								<div class="portlet-body">
									<div class="row-fluid view_info">
										<div class="span12 ">
											<div class="row-fluid">
												<table class="table table-bordered" id="table_portions">
													<thead>
														<tr>
															<th style="width:10%">ID</th>
															<th>NAME</th>
															<th style="width:25%">Action (click to view portion details)</th>		
														</tr>
													</thead>
													<tbody>
														<?php foreach($portions as $portion):?>
														<tr>
															<td style="width:10%"><?php echo $portion['Portion']['id']?></td>
															<td><?php echo $portion['Item']['name']?></td>
															<td style="width:20%"><?php echo $this->Html3->link('View Detail','/Portion/view/'.$portion['Portion']['id'])?></td>
														</tr>	
														<?php endforeach;?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>

					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->start('script_own')?>
<script>
$(document).ready(function(){
	
	$("body").on('click','tbody tr.item_tr',function(){

	  	if($(this).next().hasClass("hide")) {
			$(this).next().removeClass("hide");
	   		$(this).find("td").eq(0).find("span").eq(0).removeClass("row-details-close").addClass("row-details-open");
	 	}else{
	   		$(this).next().addClass("hide");
	   		$(this).find("td").eq(0).find("span").eq(0).removeClass("row-details-open").addClass("row-details-close");
	 	}

	  return false;
	 });
	
})
</script>
<?php $this->end()?>