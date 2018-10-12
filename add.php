<!DOCTYPE html>
<html>
<head>
	<title>Add More</title>
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />	
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>
<body>

 <div class="table-responsive">
	<table class="table  invoice-detail-table create-invoice com-create-sales-table product_det_table">
		<thead>
		<tr>
			<th>Location </th>
			<th>Name</th>
			<th>Contact</th>
			<th>Address</th>
			<th></th>
		</tr>
		</thead>
		<tbody id="field_wrapper" class="product_table_tbody">
	
		<tr>
			
			
			<td>
				<input type="text" min="1" class="form-control sales_prod_qunat" value="1" name="location[]" autocomplete="off" required />
			</td>

			<td>
				<input type="text" class="form-control product_rate"  name="name[]" >
			</td>
			
			<td>
				<input type="text" class="form-control product_amount" name="contact[]"		</td>
			<td><input type="text" class="form-control product_amount" id="finalperamountdata" name="address[]" value=""></td>
			<td>
	
				<a class="btn btn-primary btn-add-task waves-effect waves-light add_new_product" href="javascript:void(0);" title="Add More" ><i class="fa fa-plus"></i></a> 
		
			</td>

			
		</tr>	

		</tbody>
	</table>
</div>			












</body>
</html>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/common.js"></script>

<script type="text/javascript">
	
// function to add more new in product table
$('.product_table_tbody').on('click','.add_new_product',function(){
	

	$('.product_table_tbody').append('<tr><td><input type="text" class="form-control prod_basic_unit" placeholder="Basic Unit" value="" name="location[]"></td><td><input type="number" min="1" class="form-control sales_prod_qunat" value="1" name="name[]"></td> <td><input type="text" class="form-control product_rate" value="" name="contact[]" onkeypress="return isNumberKey(event)"></td> <td><input type="text" class="form-control product_amount" id="finalperamountdata" name="address[]" value=""></td><td><a href="javascript:void(0);" class="btn btn-danger btn-add-task waves-effect waves-light remove_prod_tr" title="Remove Field"><i class="fa fa-minus"></i></a></td></tr>');
	$(".js-example-data-array").select2();
});

// function to remove product form product table
$('.product_table_tbody').on('click','.remove_prod_tr',function(){
	$(this).parents('tr').remove();
});


</script>

<?php
	$product_ids=1
                if(count($product_ids)!=0){
                    for($i=0; $i< count($product_ids); $i++){
  						
  						$salespdt_details[] = array(
	                         'product_id' => $product_ids[$i],
	                         'quantity' =>  $quantity[$i],
	                         'basicproductunit' => $basic_unit[$i],
	                         'product_rate' => $product_rate[$i],
	                        );

  						//Insert
                    }


                  	for($i=0; $i<count($salespdt_details); $i++){
                  		$salespdt_details[$i]['salesorder_id'] = $salesorder_ids;
                  		$this->db->insert('crm_salesorder_prodetails', $salespdt_details[$i]);
                  	} 
            	}
	

?>