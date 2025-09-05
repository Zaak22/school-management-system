var manageRoleTable;
var base_url = $("#base_url").val();

$(document).ready(function() {
	$("#topNavRole").addClass('active');

	manageRoleTable = $("#manageRoleTable").DataTable({
		'ajax' : base_url + 'roles/fetchRoleData',
		'order' : []
	});

	/*
	*-------------------------------------------------
	* click on the add role model button
	*-------------------------------------------------
	*/
	$("#addRoleModelBtn").unbind('click').bind('click', function() {
		/*remove error messages*/
		$(".form-group").removeClass('has-success').removeClass('has-error');
		$(".text-danger").remove();
		$("#add-role-messages").html('');

		$("#createRoleForm").unbind('submit').bind('submit', function() {
			var form = $(this);
			var formData = new FormData($(this)[0]);
			var url = form.attr('action');
			var type = form.attr('method');

			$.ajax({
				url : url,
				type : type,
				data: formData,
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				async: false,
				success:function(response) {					

					if(response.success == true) {						
						$("#add-role-messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
						  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  response.messages + 
						'</div>');		

						manageRoleTable.ajax.reload(null, false);
						$('.form-group').removeClass('has-error').removeClass('has-success');
						$('.text-danger').remove();
						clearForm();
					}	
					else {									
						if(response.messages instanceof Object) {							
							$.each(response.messages, function(index, value) {
								var key = $("#" + index);

								key.closest('.form-group')
								.removeClass('has-error')
								.removeClass('has-success')
								.addClass(value.length > 0 ? 'has-error' : 'has-success')
								.find('.text-danger').remove();							

								key.after(value);

							});
						}
						else {							
							$("#add-role-messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  response.messages + 
							'</div>');						
						}							
					} // /else
				} // /success
			}); // /ajax

			return false;
		});	
	}); // /click on the add role button

	
});

/*
*-------------------------------------------------
* edits role information function
*-------------------------------------------------
*/
function editRole(roleId = null)
{
	if(roleId) {
		
		$(".form-group").removeClass('has-error').removeClass('has-success');
		$('.text-danger').remove();

		$.ajax({
			url: base_url + 'roles/fetchRoleData/'+roleId,
			type: 'post',
			dataType: 'json',
			success:function(response){
				$("#editRoleName").val(response.role_name);
				$("#editPermissions").val(response.permissions).trigger("change");

				// submit the role information form
				$("#updateRoleInfoForm").unbind('submit').bind('submit', function() {
					var form = $(this);
					var url = form.attr('action');
					var type = form.attr('method');

					$.ajax({
						url: url + '/' + roleId,
						type: type,
						data: form.serialize(),
						dataType: 'json',
						success:function(response) {
							if(response.success == true) {						
								$("#edit-personal-role-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
								  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
								  response.messages + 
								'</div>');		

								manageRoleTable.ajax.reload(null, false);
								$('.form-group').removeClass('has-error').removeClass('has-success');
								$('.text-danger').remove();		
								$("#updateRoleModal").modal('hide');			
							}	
							else {									
								if(response.messages instanceof Object) {							
									$.each(response.messages, function(index, value) {
										var key = $("#" + index);

										key.closest('.form-group')
										.removeClass('has-error')
										.removeClass('has-success')
										.addClass(value.length > 0 ? 'has-error' : 'has-success')
										.find('.text-danger').remove();							

										key.after(value);

									});
								}
								else {							
									$("#edit-personal-role-message").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
									  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									  response.messages + 
									'</div>');						
								}							
							} // /else
						} // /success
					}); // /ajax
					return false;
				});  // /submit the role information form
			} // /success
		}); // /ajax

	} // /if 
}

/*
*-------------------------------------------------
* removes role function
*-------------------------------------------------
*/
function removeRole(roleId = null)
{
	if(roleId) {
		$("#removeRoleBtn").unbind('click').bind('click', function() {
			$.ajax({
				url : base_url + 'roles/remove/'+roleId,
				type: 'post',
				dataType: 'json',
				success:function(response) {
					if(response.success == true) {
						$("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
						  	'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  	response.messages + 
						'</div>');

						manageRoleTable.ajax.reload(null, false);
						$("#removeRoleModal").modal('hide');
					}
					else{
						$("#remove-messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
						  	'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						  	response.messages + 
						'</div>');
					}
				} // /response
			}); // /ajax
		}); // /remove role button clicked of the modal button
	} // /if
}

/*
*-------------------------------------------------
* clears the form 
*-------------------------------------------------
*/
function clearForm()
{
	$('input[type="text"]').val('');
	$('select').val('');
	$(".fileinput-remove-button").click();	
}



$(document).ready(function() {
$('#permissions, #editPermissions').select2({
	placeholder: "Select permissions",
	allowClear: true,
	width: '100%',
	tags: true
});
});
