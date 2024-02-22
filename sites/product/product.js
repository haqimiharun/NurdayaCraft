
$(document).ready( function () {
    loadDataGrid();

    $("#addBtn").click(function (e) {
        $('#add_modal').modal('show');
    });

    $('input[name="product_status"]').click(function (e) { 
        test = $('input[name="product_status"]:checked').val();
        //alert(test);
        
    });

    $("#deleteProduct").click(function (e) { 
        deleteProduct();
    });

    $("#deleteImageProduct").click(function (e) {
        deleteImage();
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
                    $("#addForm").submit();
                }
                form.classList.add('was-validated')
            })
       
        
    });

    $("#editImageSaveBtn").click(function (e) { 
        //alert();
        var forms = document.querySelectorAll('.edit-image-needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }else{
                    $("#editImageForm").submit();
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

    $("#product_name").focusout(function(e){
        var data = $("#product_name").val();
        checkExist(data);
    });
    
    // $("#edit_product_name").focusout(function(e){
    //     var data = $("#edit_product_name").val();
    //     checkExist(data);
    // });

   
} );

//load product information
function loadDataGrid(){
    $(document).ready(function () {
        function edit_icon(data,type,row){
            var icon = '<button type="button" class="btn"><img src="../../images/editicon.png" name="editBtn" height="24"></button>';
            return icon;
        }
        function image_icon(){
            var icon= '<button type="button" class="btn"><img src="../../images/editimageicon.png" name="editBtn" height="24"></button>';
            return icon;
        }
        $('#datagrid').DataTable( {
            pageLength: 10,
            "columnDefs": [
              { "width": "2px", className: 'dt-center', "targets": 0, orderable: false,render:edit_icon},
              { "width": "2px", className: 'dt-center', "targets": 1, orderable: false,render:image_icon},
              { "width": "80px", className: 'dt-center', "targets": 3},
              { "width": "40px", className: 'dt-center', "targets": 4},
              { "width": "5px", className: 'dt-center', "targets": 5},
              { "width": "2px", className: 'dt-center', "targets": 6},
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
            }else if(colIdx == 1){
                var cellVal = table.row( $(this).parent('tr') ).data()[0];
                loadImage(cellVal);
            }
        });
    });   
}

//delete product
function deleteProduct(){
    $(document).ready(function () {
        var product_id=$("#edit_product_id").val();
        //alert(product_id);
        $.ajax({
            type: "POST",
            url: "bgprocess.php",
            data: {
                action_flag:'delete',
                product_id:product_id
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

//delete product image
function deleteImage(){
    $(document).ready(function () {
        var product_id=$("#edit_image_product_id").val();
        //alert(product_id);
        $.ajax({
            type: "POST",
            url: "bgprocess.php",
            data: {
                action_flag:'deleteImage',
                product_id:product_id
            },
            success: function (data) {
                if(data!=1){
                    alert(data);
                }
                location.reload();
                
            }
        });
    });
}

//load product to edit
function loadEditor(product_id){
	$(document).ready(function(e){
		
		$.ajax({
			type: 'POST',
            url: 'bgprocess.php',
			data: {
				action_flag:'getEditData',
				product_id:product_id	
			},
			success: function(data){
                var obj = JSON.parse(data);
				
				$("#edit_product_id").val(obj.product_id);
				$("#edit_product_name").val(obj.product_name);
				$("#edit_product_desc").val(obj.product_description);
				$("#edit_product_price").val(obj.product_price);
				$("#edit_product_qty").val(obj.product_qty);
				$("#edit_product_category").val(obj.category_id).change;
				if (obj.product_status == 'Y'){
					$("#edit_flexRadioDefault1").prop("checked", true);
				}
				else {
					$("#edit_flexRadioDefault2").prop("checked", true);
				}
                //alert(obj.promotion_type);
                if(obj.promotion_type!=''){
                    $("#edit_product_promotion_type").val(obj.promotion_type).change;
                    $("#edit_promotion_rate").val(obj.rate);
                    $("#edit_promotion_rate").prop('disabled',false);
                    $("#edit_promotion_rate").prop('required',true);
                }else{
                    $("#edit_promotion_rate").prop('disabled',true);
                    $("#edit_promotion_rate").prop('required',false);
                }
				$('#edit_modal').modal('show');
			
			},
			error: function( ){
			},
		});
	});
}

function loadImage(product_id){
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: "bgprocess.php",
            data: {
                action_flag:'getImage',
                product_id:product_id
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if(obj.product_image==''){
                    $("#preview_image").hide();
                }else{
                    $imageURL = obj.product_image;
                    $imageSrc = 'uploads/'+$imageURL;
                    $("#preview_image").attr("src", $imageSrc);
                }
                $('#edit_image_modal').modal('show');
                $('#edit_image_product_id').val(obj.product_id);
                $('#edit_image_product_name').val(obj.product_name);
            }
        });
    });
}

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
                    alert("Product Name Already Exist");
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