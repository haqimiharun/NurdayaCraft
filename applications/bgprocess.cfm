<cfif action_flag EQ "loadDataGrid" >
	
    <cfquery name="getData" datasource="#dsvmas#" >
		SELECT Comp_Id, Comp_Name, Comp_Address, Comp_Tel_No, FORMAT(LastEdtDt, 'dd/MM/yyyy hh:mm tt'), LastEdtBy,
        CASE
        WHEN Comp_Status=<cfqueryparam cfsqltype="cf_sql_varchar" value="Y"> THEN 'ACTIVE'
        ELSE <cfqueryparam cfsqltype="cf_sql_varchar" value="INACTIVE">
        END CURRENTSTATUS
        FROM Company
        WHERE Comp_Status != <cfqueryparam cfsqltype="cf_sql_varchar" value="D">
        AND Org_Id = <cfqueryparam cfsqltype="cf_sql_varchar" value="#org_id#">
		<cfif status NEQ ""> 
			AND Comp_Status = <cfqueryparam cfsqltype="cf_sql_varchar" value="#status#" />
		</cfif>
        
	</cfquery>  
	<cfoutput>~~#encodeForHTML(serializeJSON(getData))#~~</cfoutput>

<cfelseif action_flag EQ "getEditData">
	
    <cfquery name="getData" datasource="#dsvmas#">
    	SELECT Comp_Id, Comp_Name, Comp_Short_Name, Comp_Address, Comp_Tel_No, Comp_Min, comp_status
        FROM Company
        
        WHERE Comp_Name = <cfqueryparam cfsqltype="cf_sql_varchar" value="#company_name#"/>
    </cfquery>
    <cfoutput>~~#getData.Comp_Id#~~#getData.Comp_Name#~~#getData.Comp_Short_Name#~~#getData.Comp_Address#~~#getData.Comp_Tel_No#~~#getData.Comp_Min#~~#getData.comp_status#~~</cfoutput>

<cfelseif action_flag EQ "add">
	
    <cfset trx_status = "add">
    <cfset errorMsg = "">
    
    <cfif isDefined("edit_status")>
    	<cfset status = "Y">
    <cfelse>
    	<cfset status = "N">
    </cfif>
    
	<cftransaction action="begin">
    	<cftry>
        	<cfquery name="addData" datasource="#dsvmas#">
    			INSERT INTO Company
                (Comp_Name, Comp_Short_Name, Comp_Address, Comp_Tel_No, Comp_Min, Org_Id, Comp_Status, created_by)
                VALUES
                (
                	<cfqueryparam cfsqltype="cf_sql_varchar" value="#company_name#">,
                    <cfqueryparam cfsqltype="cf_sql_varchar" value="#short_name#">,
                    <cfqueryparam cfsqltype="cf_sql_varchar" value="#company_address#">,
                    <cfqueryparam cfsqltype="cf_sql_varchar" value="#company_tel#">,
                    <cfqueryparam cfsqltype="cf_sql_varchar" value="#time_limit#">,
                    <cfqueryparam cfsqltype="cf_sql_varchar" value="#session.org_id#">,
                    <cfqueryparam cfsqltype="cf_sql_varchar" value="#status#">,
                    <cfqueryparam cfsqltype="cf_sql_varchar" value="#session.username#">
                )
    		</cfquery>
            <cftransaction action="commit">
            	<cfset trx_status = "success">
                <cfset counter = 1>
                
			<cfcatch type="database">
            	<cftransaction action="rollback">
                <cfset trx_status = "failed">
                <cfset errorMsg = "	<b>Message:</b> #CFCATCH.Message#<br>
                                                <b>Native error code:</b> #CFCATCH.NativeErrorCode#<br>
                                                <b>SQLState:</b> #CFCATCH.SQLState#<br>
                                                <b>Detail:</b> #CFCATCH.Detail#<br>
                                  ">			</cfcatch>
             
        </cftry>
    </cftransaction>
    
	<cfoutput>~~#trx_status#~~#errorMsg#~~</cfoutput>
    
<cfelseif action_flag EQ "edit">
	
	<cfset trx_status = "edit">
    <cfset errorMsg = "">
    <cfset counter = 0>
    
	<cfif isDefined("edit_status")>
    	<cfset status =  "Y">
	<cfelse>
    	<cfset status = "N">
    </cfif>
    
    <cftransaction action="begin">
    	<cftry>
            <cfquery name="editData" datasource="#dsvmas#">
                UPDATE Company
                SET 
                LastEdtDt = CURRENT_TIMESTAMP,
                LastEdtBy = <cfqueryparam cfsqltype="cf_sql_varchar" value="#session.username#">,
                <cfif #edit_company_name# NEQ "">
                Comp_Name = <cfqueryparam cfsqltype="cf_sql_varchar" value="#edit_company_name#">,
                </cfif>
                Comp_Short_Name = <cfqueryparam cfsqltype="cf_sql_varchar" value="#edit_short_name#">,
                Comp_Address = <cfqueryparam cfsqltype="cf_sql_varchar" value="#edit_company_address#">,
                Comp_Tel_No = <cfqueryparam cfsqltype="cf_sql_varchar" value="#edit_company_telephone#">,
                Comp_Status = <cfqueryparam cfsqltype="cf_sql_varchar" value="#status#">
                WHERE Comp_Id = <cfqueryparam cfsqltype="cf_sql_varchar" value="#company_id#">
			</cfquery>
            
            <cftransaction action="commit">
            	<cfset trx_status = "success">
                <cfset counter = 1>

			<cfcatch type="database">
            	<cftransaction action="rollback">
                <cfset trx_status = "failed">
                
    		</cfcatch>
		
        </cftry>
        
	</cftransaction>
    
	<cfif counter EQ 0>
		<cfset trx_status = "noupdate" >
        <cfset errorMsg = "	<b>Message:</b> #CFCATCH.Message#<br>
                                                <b>Native error code:</b> #CFCATCH.NativeErrorCode#<br>
                                                <b>SQLState:</b> #CFCATCH.SQLState#<br>
                                                <b>Detail:</b> #CFCATCH.Detail#<br>
                                  ">
	</cfif>
    
	<cfoutput>~~#trx_status#~~#errorMsg#~~</cfoutput>

<cfelseif action_flag EQ "checkDuplicate">
	
    <cfset trx_status = "failed">
    
    <cfquery name="checkExist" datasource="#dsvmas#">
    	SELECT 1 FROM Company
        WHERE Comp_Name = <cfqueryparam cfsqltype="cf_sql_varchar" value="#company_name#">
        AND Comp_Status != <cfqueryparam cfsqltype="cf_sql_varchar" value="D">
        AND Org_Id = <cfqueryparam cfsqltype="cf_sql_varchar" value="#session.org_id#">
    </cfquery>
    
    <cfif checkExist.recordcount EQ 0>
    	<cfset trx_status = "success">
    </cfif>
    
    <cfoutput>~~#trx_status#~~</cfoutput>

<cfelseif action_flag EQ "deleteCompany">
	
    <cfset trx_status = "failed">
    <cfset errorMsg = "">
    
    	<cftransaction action="begin">
        	<cftry>
            	
                <cfquery name="deleteCompany" datasource="#dsvmas#">
                	UPDATE Company
                    SET
                    Comp_Status = <cfqueryparam cfsqltype="cf_sql_varchar" value="D">,
                    LastEdtDt = CURRENT_TIMESTAMP,
                    LastEdtBy = <cfqueryparam cfsqltype="cf_sql_varchar" value="#session.username#">
                    WHERE Comp_Id = <cfqueryparam cfsqltype="cf_sql_varchar" value="#company_id#">
                </cfquery>
                
                <cftransaction action="commit">
                	<cfset trx_status = "success">
				
                <cfcatch type="database">
                	<cftransaction action="rollback">
                    <cfset trx_status = "failed">
                    <cfset errorMsg = "	<b>Message:</b> #CFCATCH.Message#<br>
                                                <b>Native error code:</b> #CFCATCH.NativeErrorCode#<br>
                                                <b>SQLState:</b> #CFCATCH.SQLState#<br>
                                                <b>Detail:</b> #CFCATCH.Detail#<br>
                                  ">
                </cfcatch>	
                
            </cftry>
        </cftransaction>

	<cfoutput>~~#trx_status#~~#errorMsg#~~</cfoutput>

</cfif>