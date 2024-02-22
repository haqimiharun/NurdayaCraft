$(document).ready( function () {
    loadDataGrid();
    $("#addBtn").click(function (e) {
        $('#add_modal').modal('show');
    });

    $('input[name="product_status"]').click(function (e) { 
        test = $('input[name="product_status"]:checked').val();
        //alert(test);
        
    });

    $("#deleteCategory").click(function (e) { 
        deleteCategory();
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

    $("#addSaveBtn").click(function (e) { 
        //alert();
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }else{
                    if(checkExist($("#category_name").val())){
                        alert("Categpry Name Already Exist");
                    }else{
                        $("#addForm").submit();
                    }
                }
                form.classList.add('was-validated')
            })
       
        
    });

    

    $("#product_promotion_type").change(function (e) { 
        if($("#product_promotion_type").val()!=''){
            $("#promotion_rate").prop('disabled',false);
            $("#promotion_rate").prop('required',true);
        }else{
            $("#promotion_rate").prop('disabled',true);
            $("#promotion_rate").prop('required',false);
        }
        
    });

    $("#edit_product_promotion_type").change(function (e) { 
        if($("#edit_product_promotion_type").val()!=''){
            $("#edit_promotion_rate").prop('disabled',false);
            $("#edit_promotion_rate").prop('required',true);
        }else{
            $("#edit_promotion_rate").prop('disabled',true);
            $("#edit_promotion_rate").prop('required',false);
        }
        
    });

    $("#category_name").focusout(function(e){
        var data = $("#category_name").val();
        checkExist(data);
    });
    
    $("#edit_category_name").focusout(function(e){
        var data = $("#edit_category_name").val();
        checkExist(data);
    });

   
} );

//load category information
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
              { "width": "2px", className: 'dt-center', "targets": 2}
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

//delete category
function deleteCategory(){
    $(document).ready(function () {
        var category_id=$("#edit_category_id").val();
        //alert(product_id);
        $.ajax({
            type: "POST",
            url: "bgprocess.php",
            data: {
                action_flag:'delete',
                category_id:category_id
            },
            success: function (data) {
                if(data!=1){
                    alert("Product Failed to Delete");
                }
                location.reload();
            }
        });
    });
}



//load product to edit
function loadEditor(category_id){
	$(document).ready(function(e){
		
		$.ajax({
			type: 'POST',
            url: 'bgprocess.php',
			data: {
				action_flag:'getEditData',
				category_id:category_id	
			},
			success: function(data){
                var obj = JSON.parse(data);
				$("#edit_category_id").val(obj.category_id);
				$("#edit_category_name").val(obj.category_name);
				if (obj.category_status == 'Y'){
					$("#edit_flexRadioDefault1").prop("checked", true);
				}
				else {
					$("#edit_flexRadioDefault2").prop("checked", true);
				}
				$('#edit_modal').modal('show');
			
			},
			error: function( ){
			},
		});
	});
}

//check if category already exist
function checkExist(name) {
    $(document).ready(function(e){
        $.ajax({
            type: "POST",
            url: "bgprocess.php",
            
			data: {
				action_flag:'checkExist',
				name:name
			},
            success: function (data) {
                if(data==1){
                    alert("Category Name Already Exist");
                    $("#addSaveBtn").prop("disabled", true);
                    return true;
                }else{
                    $("#addSaveBtn").prop("disabled", false);
                    return false;
                }
            }
            
        });
    });
}
