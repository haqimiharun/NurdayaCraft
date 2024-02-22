$(document).ready(function(e){
	
	$("#searchBtn").click(function(e) {
		loadDataGrid();
	});
	
	$("#addBtn").click(function(e) {
		$('#add_modal').modal('show');
	});
	
	$("#addSaveBtn").click(function(e){
		$("#addForm").submit();
	});
	
	$("#editSaveBtn").click(function(e){
		$("#editForm").submit();
	});
	
	$("#deleteCompany").click(function(e){
		deleteCompany();
	});
	
	$("#edit_company_name").keyup(function(e){
		changeUpper(this.value);
	});
	
	$("#company_name").keyup(function(e){
		changeUpper(this.value);
	});
	
	$("#company_name").focusout(function(e){
		checkDuplicate();
	});
	
	$("#edit_company_name").focusout(function(e){
		//checkDuplicate();
	});
	
	$("#time_limit").keyup(function(e) {
		if(isNaN($("#time_limit").val()))
		{
			this.value = '';
			showTips('time_limit','Invalid Number!'); 
		}
	});
	
	$("#edit_time_limit").keyup(function(e) {
		if(isNaN($("#edit_time_limit").val()))
		{
			this.value = '';
			showTips('edit_time_limit','Invalid Number!'); 
		}
	});
	
	var add_options = { 
		beforeSerialize: prepareInput,
		beforeSubmit:  add_validateInput,
		success: add_showChangeResponse   
	};
	
	$("#addForm").ajaxForm(add_options);
	
	var edit_options = { 
		beforeSerialize: prepareInput,
		beforeSubmit:  edit_validateInput,
		success: edit_showChangeResponse   
	}; 
	
	$("#editForm").ajaxForm(edit_options);  
	
});

function loadDataGrid(){
	
	$(document).ready(function(e) { 
		function editicon( data, type, row ) {				
			var icon;
			if($("#user_access").val() != 0){ icon = '<img src="'+rootpath+'/images/pencil.png" style="cursor:pointer" height="24" >'; }
			else { icon = '<img src="'+rootpath+'/images/pencil_disabled.png" height="24">'; }
			return icon;
		} 
		if ($("#org_id").val().trim() == ''){
			showTips('org_id','Please select organization!');
		}else{
			$.ajax({
				type: 'POST',
				url: 'bgprocess.cfm',
				data: {
					action_flag:'loadDataGrid',
					status:$("#status").val(),
					org_id:$("#org_id").val()
				},
				beforeSend: function( ) { 
				},
				success:function(data){ 
							data = he.decode(data);
							var jsonArr = data.split('~~');
							var jsonObj = JSON.parse(jsonArr[1])
							var jsonData = jsonObj['DATA']; 
							$('#datagrid tbody').off();
							$(".grid_wrapper").show();
							if( $("#datagrid tfoot").length == 0 ){
								$("#datagrid").find('thead').after( '<tfoot>' + $("#datagrid").find('thead').html() + '</tfoot>');
							} 
							
							$('#datagrid').DataTable( { 
								 data: jsonData,
								 pageLength: 10,
								 columnDefs: [
									{ width: "20px", targets: 0, className: 'dt-center', orderable: false,render:editicon} ,
									{ width: "200px", targets: 1, className: 'dt-left'} 
								  ]
							} );
								
							$(".grid_title").html( $('#datagrid').attr('title'));  
							
							//click 
							$('#datagrid tbody').on('click', 'td', function () { 
								var table = $('#datagrid').DataTable();   
								var colIdx = table.column( table.cell(this).index().column ).dataSrc();
								var editFlag = table.row( $(this).parent('tr') ).data()[0]
								
								if(colIdx == 0 && $("#user_access").val() != 0){
									var cellVal = table.row( $(this).parent('tr') ).data()[1];   
									loadEditor(cellVal); 
								}
								
								
							});
							
						},
					error:function(){}
			})
		}
	}
)}

function loadEditor(company_name){
	$(document).ready(function(e){
		
		$.ajax({
			type: 'POST',
			url: 'bgprocess.cfm',
			data: {
				action_flag:'getEditData',
				company_name:company_name	
			},
			beforeSend: function( ){
			},
			success: function(data){
				var dataArr = data.split("~~");	 
				
				$("#company_id").val(dataArr[1]);
				$("#edit_company_name").val(dataArr[2]); 
				$("#edit_short_name").val(dataArr[3]); 
				$("#edit_company_address").val(dataArr[4]); 
				$("#edit_company_telephone").val(dataArr[5]);
				$("#edit_time_limit").val(dataArr[6]); 
				if (dataArr[7] == 'Y'){
					$("#edit_status").prop("checked", true);
				}
				else {
					$("#edit_status").prop("checked", false);
				}
				$('#edit_modal').modal('show');
			
			},
			error: function( ){
			},
		});
	});
}

function checkDuplicate() {
	$(document).ready(function(e){
		
		var company_name = $("#company_name").val();

		if (company_name== ''){
			showTips('company_name','Please insert company name!');
		}
		else if (company_name != ''){
			$.ajax({
				type: 'POST',
				url: 'bgprocess.cfm',
				data: {
					loadingOverlay:false,
					action_flag:'checkDuplicate',
					company_name:company_name
				},
				success:function(data){
					var dataArr = data.split("~~");
					
					if(dataArr[1] == 'success')
					{
					 invalidcounter = 0
					 $("#addSaveBtn").prop("disabled", false);
					}
					else if(dataArr[1] == 'failed'){
					  showTips('company_name','Company name already existed!');
					  invalidcounter = 1
					  $("#addSaveBtn").prop("disabled", true);	
					}
					
				},
				error:function(){}
			});
		}
	});
}

function add_validateInput(formData, jqForm, options){
	if ($("#short_name").val().trim() == ''){
		showTips('short_name','Please insert company short name!');
		return false;
	}
	else if ($("#company_address").val().trim() == ''){
		showTips('company_address','Please insert company address!');
		return false;
	}
	else if ($("#company_tel").val().trim() == ''){
		showTips('company_tel','Please insert company telephone number!');
		return false;
	}
	else if ($("#time_limit").val().trim() == ''){
		showTips('time_limit','Please insert company time limit!');
		return false;
	}
	else{
		return true;
	}
}

function edit_validateInput(formData, jqForm, options) {  
	if ($("#edit_short_name").val().trim() == ''){
		showTips('edit_short_name','Please insert company short name!');
		return false;
	}
	else if ($("#edit_company_address").val().trim() == ''){
		showTips('edit_company_address','Please insert company address!');
		return false;
	}
	else if ($("#edit_company_telephone").val().trim() == ''){
		showTips('edit_company_telephone','Please insert company telephone number!');
		return false;
	}
	else if ($("#edit_time_limit").val().trim() == ''){
		showTips('edit_time_limit','Please insert company time limit!');
		return false;
	}
	else{
		return true;
	}
}  

function deleteCompany(){
	$(document).ready(function(e){
		
		var company_id = $("#company_id").val();
		
		$.ajax({
				type: 'POST',
				url: 'bgprocess.cfm',
				data: {
					action_flag:'deleteCompany',
					company_id:company_id
				}, 
				success:function(data){
					 var dataArr = data.split("~~");
					 
					 if(dataArr[1] == 'success'){
						window.parent.notify('success', 'Selected Company is successfully deleted!');
						$("#edit_modal").modal('hide');
						loadDataGrid();
					 }
					 else{
					 	window.parent.notify('error', responseArr[2]); 
					 }
				},
				error:function(){}
			}); 
	});
}

function add_showChangeResponse(responseText, statusText, xhr, $form)  {  
	var responseArr = responseText.split("~~");   

	if(responseArr[1]== "success"){	 
		window.parent.notify('success', 'New Company is successfully added');
		$("#add_modal").modal('hide'); 
		loadDataGrid();
	}  
	else { 
		window.parent.notify('error',responseArr[2]); 
	}  
}

function edit_showChangeResponse(responseText, statusText, xhr, $form)  {
	
	var responseArr = responseText.split("~~");   

	if(responseArr[1]== "success"){	 
		window.parent.notify('success','Selected Company successfully updated'); 
		$("#edit_modal").modal('hide');
		loadDataGrid();
	} 
	else if(responseArr[1]== "noupdate"){	 
		window.parent.notify('warning', responseArr[2]); 
		$("#edit_modal").modal('hide');
	}  
	else { 
		window.parent.notify('error', responseArr[2]); 
	} 
}

function changeUpper(value){
	$(document).ready(function(e) {
		var company_name = value.toUpperCase();
		$("#edit_company_name").val(company_name);
		$("#company_name").val(company_name);
	});
}

