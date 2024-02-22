$(document).ready( function () {
    loadDataGrid();
    $("#addBtn").click(function (e) {
        $('#add_modal').modal('show');
    });

    $("#deleteUser").click(function (e) { 
        deleteUser();
    });

    $('input[name="product_status"]').click(function (e) { 
        test = $('input[name="product_status"]:checked').val();
        //alert(test);
        
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

    //Validate Edit User Form
    $("#editSaveBtn").click(function (e) {
        
        // alert();
        var forms = document.querySelectorAll('.edit-needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                if($("#edit_user_password1").val()==$("#edit_user_password").val()){
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                    }else{
                        $("#editForm").submit();
                    }
                }else{
                    alert('Password Not Match');
                    e.stopPropagation();
                    e.preventDefault();
                }
                
                form.classList.add('was-validated')
            })

            //location.reload();
    });


    //Validate User Form
    $("#addSaveBtn").click(function (e) { 
        //alert();
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                if($("#user_password1").val()==$("#user_password").val()){
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                    }else{
                        $("#addForm").submit();
                    }
                }else{
                    alert('Password Not Match');
                    e.stopPropagation();
                    e.preventDefault();
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

    $("#user_email").focusout(function(e){
        var data = $("#user_email").val();
        checkExist(data);
    });
    
    $("#edit_user_email").focusout(function(e){
        var data = $("#edit_user_email").val();
        checkExist(data);
    });

   
} );

//load user information
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
              { "width": "10px", className: 'dt-center', "targets": 2},
              { "width": "5px", className: 'dt-center', "targets": 3},
              { "width": "2px", className: 'dt-center', "targets": 4}
            ]
        } );

        $('#datagrid tbody').on('click', 'td', function () { 
            var table = $('#datagrid').DataTable();   
            var colIdx = table.column( table.cell(this).index().column ).dataSrc();
            var editFlag = table.row( $(this).parent('tr') ).data()[0]
            
            if(colIdx == 0){
                var cellVal = table.row( $(this).parent('tr') ).data()[0];
                // alert(cellVal);
                loadEditor(cellVal);
                //window.location = 'product.php?action_flag=' + cellVal;
            }
        });
    });   
}




//load user to edit
function loadEditor(user_id){
	$(document).ready(function(e){
		
		$.ajax({
			type: 'POST',
            url: 'bgprocess.php',
			data: {
				action_flag:'getEditData',
				user_id:user_id	
			},
			success: function(data){
                var obj = JSON.parse(data);
				
				$("#edit_user_id").val(obj.user_id);
				$("#edit_user_name").val(obj.user_name);
				$("#edit_user_email").val(obj.user_email);
				$("#edit_user_type").val(obj.user_type_name);
				if (obj.user_status == 'Y'){
					$("#edit_flexRadioDefault1").prop("checked", true);
				}
				else {
					$("#edit_flexRadioDefault2").prop("checked", true);
				}
                if(obj.user_type_name=='ADMIN'){
                    $("#deleteUser").hide();
                }else{
                    $("#deleteUser").show();
                }
				$('#edit_modal').modal('show');
			
			},
			error: function( ){
			},
		});
	});
}

function checkExist(email) {
    $(document).ready(function(e){
        $.ajax({
            type: "POST",
            url: "bgprocess.php",
            
			data: {
				action_flag:'checkExist',
				email:email
			},
            success: function (data) {
                if(data==1){
                    alert("Email Already Exist");
                    $("#addSaveBtn").prop("disabled", true);
                    $("#editSaveBtn").prop("disabled", true);
                    return true;
                }else{
                    $("#addSaveBtn").prop("disabled", false);
                    $("#editSaveBtn").prop("disabled", false);
                    return false;
                }
            }
            
        });
    });
}

//delete user
function deleteUser(){
    $(document).ready(function () {
        var user_id=$("#edit_user_id").val();
        //alert(product_id);
        $.ajax({
            type: "POST",
            url: "bgprocess.php",
            data: {
                action_flag:'delete',
                user_id:user_id
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