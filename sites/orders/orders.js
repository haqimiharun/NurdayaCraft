$(document).ready( function () {
    loadDataGrid();

    $('input[name="product_status"]').click(function (e) { 
        test = $('input[name="product_status"]:checked').val();
        //alert(test);
        
    });

    $("#deleteOrder").click(function (e) { 
        deleteOrder();
    });

    $("#signOutBtn").click(function (e) { 
        $.ajax({
            type: "POST",
            url: "bgprocess.php",
            data: {
                action_flag:'logout'
            },
        });
    });

    $("#editSaveBtn").click(function (e) {
        
        // alert();
        var forms = document.querySelectorAll('.edit-needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }else{
                    $("#editForm").submit();
                }
                form.classList.add('was-validated')
            })

            //location.reload();
    });


   
} );

//load product information
function loadDataGrid(){
    $(document).ready(function () {
        function edit_icon(data,type,row){
            var icon = '<button type="button" class="btn"><img src="../../images/editicon.png" name="editBtn" height="24"></button>';
            return icon;
        }
        $('#datagrid').DataTable( {
            pageLength: 10,
            "columnDefs": [
              { "width": "2px", className: 'dt-center', "targets": 0, orderable: false,render:edit_icon},
              { "width": "150px", className: 'dt-center', "targets": 2},
              { "width": "20px", className: 'dt-center', "targets": 3},
              { "width": "100px", className: 'dt-center', "targets": 4},
              { "width": "10px", className: 'dt-center', "targets": 5},
              { "width": "10px", className: 'dt-center', "targets": 6}
            ]
        } );

        $('#datagrid tbody').on('click', 'td', function () { 
            var table = $('#datagrid').DataTable();   
            var colIdx = table.column( table.cell(this).index().column ).dataSrc();
            var editFlag = table.row( $(this).parent('tr') ).data()[0]
            
            if(colIdx == 0){
                var cellVal = table.row( $(this).parent('tr') ).data()[0];
                //alert(cellVal);
                loadEditor(cellVal);
                //window.location = 'product.php?action_flag=' + cellVal;
            }
        });
    });   
}




//load product to edit
function loadEditor(order_id){
	$(document).ready(function(e){
		
		$.ajax({
			type: 'POST',
            url: 'bgprocess.php',
			data: {
				action_flag:'getEditData',
				order_id:order_id	
			},
			success: function(data){
                var obj = JSON.parse(data);
				
				$("#edit_order_id").val(obj.order_id);
				$("#fname").val(obj.first_name);
				$("#lname").val(obj.last_name);
				$("#addresses").val(obj.addresses);
				$("#address2").val(obj.address2);
				$("#city").val(obj.city);
				$("#postcode").val(obj.postcode);
				$("#state").val(obj.states);
				$("#phone_no").val(obj.phone_number);
				$("#tracking_no").val(obj.tracking_no);
				if (obj.tracking_no == ''){
					$("#tracking_no").prop("disabled", false);
					$("#editSaveBtn").show();
					$("#deleteOrder").hide();
                    
				}
				else {
					$("#tracking_no").prop("disabled", true);
					$("#editSaveBtn").hide();
					$("#deleteOrder").show();
				}
				$('#edit_modal').modal('show');
			
			},
			error: function( ){
			},
		});
	});
}

//delete product
function deleteOrder(){
    $(document).ready(function () {
        var edit_order_id=$("#edit_order_id").val();
        //alert(product_id);
        $.ajax({
            type: "POST",
            url: "bgprocess.php",
            data: {
                action_flag:'delete',
                edit_order_id:edit_order_id
            },
            success: function (data) {
                if(data!=1){
                    alert("Order Failed to Delete");
                }
                location.reload();
            }
        });
    });
}

