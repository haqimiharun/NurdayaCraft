<!--- 
Version      Developer              Date          Remarks
1.0.0   Mohamed Hazizi Hamdan    1 Oct 2019    First Release Modernization
--->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contractor</title>
<cfinclude template="#rootpath#/corporate-1.0.cfm">
<script language="javascript" src="company.js"></script>

<cfquery name="getOrg" datasource="#dscorpfw#">
	SELECT org_id, descr FROM frm_organizations
    WHERE org_id = <cfqueryparam cfsqltype="cf_sql_varchar" value="#session.org_id#">
</cfquery>

</head>

 <style type="text/css">
 .modal-dialog {
    max-width: 1000px; 
 }
 </style>
 
<body>
<cfoutput>
<div class="ui_wrapper"></div>
<div class="ui_title"></div>
<!--Search Form-->
	<form action="" method="post">
    	<div>
        	<div class="l_col">
            	Organization
            </div>
            
            <div class="r_col">
            	<select class="u-full-width" id="org_id">
                	<option value="">-- PLEASE SELECT --</option>
                    <cfloop query="getOrg">
                    	<option value="#org_id#">#descr#</option>
                    </cfloop>
                </select>
            </div>
            
        	<div class="l_col">
              <label>Status</label>
            </div>
            
            <div class="r_col">
              <select class="u-full-width" id="status">
              	<option value="" selected>-- All --</option>
                <option value="Y">ACTIVE</option>
                <option value="N">INACTIVE</option> 
              </select>
            </div>
            
        </div>
            
        <div class="button_row">
        	<div class="f_col">
				<button type="button" class="btn btn-secondary closeTab">Close</button>
				<button type="button" class="btn btn-secondary reloadTab">Reset</button>
				<button type="button" class="btn btn-primary" id="searchBtn">Search</button>
				<button type="button" class="btn btn-primary" id="addBtn">Add</button>
            </div>
        </div>
    </form>
    
    <br />

    <!-- Grid Display Information -->
    <div class="grid_wrapper"> 
		<table id="datagrid" class="display cell-border compact nowrap " title="Company List">
            <thead>
                <tr>
                    <th>Edit</th>
                    <th>Company Name</th>
                    <th>Company Address</th>
                    <th>Company Telephone No</th>
                    <th>Last Updated Date</th>
                    <th>Last Updated By</th>
                    <th>Status</th>          
                </tr>
            </thead>  
        </table>
	</div>
    
    <!-- Add New -->
      
    <div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
      <div class="modal-dialog" role="document">
        <div class="modal-content" >
            	<div class="modal-header">
                    <span class="modal-title" >Add company</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
          		</div>
                <div class="modal-body">
                	<form action="bgprocess.cfm" name="addForm" id="addForm" method="post">
                    	<input type="hidden" name="action_flag" value="add" />
                        
                        <div>
                        	<div class="l_col">Name</div>
                            <div class="r_col">
                            	<input type="text" class="u-full-width" name="company_name" id="company_name" />
                            </div>
                            
                            <div class="l_col">Short Name</div>
                            <div class="r_col">
                            	<input type="text"class="u-full-width" name="short_name" id="short_name" />
                            </div>
                        </div>
                        
                        <div>
                        	<div class="l_col">Address</div>
                            <div class="r_col">
                            	<input type="text"class="u-full-width" name="company_address" id="company_address" />
                            </div>
                            
                            
                        	<div class="l_col">Telephone No.</div>
                            <div class="r_col">
                            	<input type="text"class="u-full-width" name="company_tel" id="company_tel" />
                            </div>
                        </div>
                        <div >
                            <div class="l_col">Time Limit (MINUTE)</div>
                            <div class="r_col"><input type="text" class="u-full-width" name="time_limit" id="time_limit" /></div>
                            
                            <div class="l_col">
                                <label>Status </label> 
                            </div>
                            
                            <div class="r_col">
                              <input class="switch-input switch" type="checkbox" name="edit_status" id="edit_status" 
                              checked data-on="ACTIVE" data-off="INACTIVE">
                            </div> 
               			</div>
                    </form>
                </div>
                
                 	<div class="modal-footer">
            			<button type="button" class="btn btn-primary" id="addSaveBtn"  data-toggle="confirmation">Save</button>
            			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          			</div>
            </div>
        </div>
    </div>
    
    <!-- Edit Modal -->
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
    	<div class="modal-dialog" role="document">
        	<div class="modal-content" >
            
            	<div class="modal-header">
                    <span class="modal-title" >Edit Company</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
          		</div>
                
                <div class="modal-body">
                	<form action="bgprocess.cfm" method="post" name="editForm" id="editForm">
                    	<input type="hidden" name="action_flag" id="action_flag" value="edit" />
                        <input type="hidden" name="company_id" id="company_id" />
                        <div>
                        	<div class="l_col">
                            	Name
                            </div>
                            <div class="r_col">
                            	<input type="text" class="u-full-width" id="edit_company_name" name="edit_company_name" />
                            </div>
                            
                        	<div class="l_col">
                        		Short Name    	
                            </div>
                            <div class="r_col">
                            	<input type="text" class="u-full-width" name="edit_short_name" id="edit_short_name" />
                            </div>
                        </div>
                        
                        <div>
                        	<div class="l_col">
                            	Address
                            </div>
                            <div class="r_col">
                            	<input type="text" class="u-full-width" name="edit_company_address" id="edit_company_address" />
                            </div>
                            
                            <div class="l_col">
                            	Telephone Number
                            </div>
                            <div class="r_col">
                            	<input type="text" class="u-full-width" name="edit_company_telephone" id="edit_company_telephone"  />
                            </div>  
                        </div>
                        <div >
                            <div class="l_col">Time Limit (MINUTE)</div>
                            <div class="r_col"><input type="text" class="u-full-width" name="edit_time_limit" id="edit_time_limit" readonly/></div>
                            
                            <div class="l_col">
                                <label>Status </label> 
                            </div>
                            
                            <div class="r_col">
                              <input class="switch-input switch" type="checkbox" name="edit_status" id="edit_status" 
                              checked data-on="ACTIVE" data-off="INACTIVE">
                            </div> 
               			</div>
                    </form>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="editSaveBtn" data-toggle="confirmation">Save</button>
                    <button type="button" class="btn btn-danger" id="deleteCompany"  data-toggle="confirmation">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
                
            </div>
        </div>
    </div>
</cfoutput>
</body>
</html>