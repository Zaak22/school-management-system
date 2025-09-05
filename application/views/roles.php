<ol class="breadcrumb">
	<li><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
	<li class="active">Manage Roles</li>
</ol>

<div class="panel panel-default">
	<div class="panel-body">
		<fieldset>
			<legend>Manage Roles</legend>

			<div id="messages"></div>

			<div class="pull pull-right">
				<button type="button" class="btn btn-info" data-toggle="modal" data-target="#addRole" id="addRoleModelBtn">
					<i class="glyphicon glyphicon-plus-sign"></i> Add Role
				</button>
			</div>

			<br /> <br /> <br />

			<table id="manageRoleTable" class="table table-bordered">
				<thead>
					<tr>
						<th>Role ID</th>
						<th>Role Name</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>

		</fieldset>
	</div>
</div>


<!-- Add Role Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addRole">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Add Role</h4>
			</div>

			<form class="form-horizontal" method="post" id="createRoleForm" action="roles/create" enctype="multipart/form-data">

				<div class="modal-body">

					<div id="add-role-messages"></div>

					<div class="form-group">
						<label for="role_name" class="col-sm-2 control-label">Role Name :</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="role_name" name="role_name" placeholder="Role Name">
						</div>
					</div>

					<div class="form-group">
						<label for="permissions" class="col-sm-2 control-label">Permissions :</label>
						<div class="col-sm-10">
							<select multiple class="form-control" id="permissions" name="permissions[]">
								<?php foreach ($permissions as $permission): ?>
									<option value="<?= $permission['permission_id']; ?>">
										<?= $permission['description']; ?>
									</option>
								<?php endforeach; ?>
							</select>
							<p class="help-block">You can search and select multiple permissions.</p>
						</div>
					</div>

				</div>
				<!-- /.modal-body -->

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>

			</form>

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Edit Role Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="updateRoleModal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Edit Role</h4>
			</div>

			<form class="form-horizontal" method="post" id="updateRoleInfoForm" action="roles/updateInfo">
				<div class="modal-body">
					<div id="edit-role-messages"></div>

					<div class="form-group">
						<label for="editRoleName" class="col-sm-2 control-label">Role Name :</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="editRoleName" name="editRoleName" placeholder="Role Name">
						</div>
					</div>

					<!-- Multi-select for permissions -->
					<div class="form-group">
						<label for="editPermissions" class="col-sm-2 control-label">Permissions :</label>
						<div class="col-sm-10">
							<select multiple class="form-control" id="editPermissions" name="editPermissions[]">
								<?php foreach ($permissions as $permission): ?>
									<option value="<?= $permission['permission_id']; ?>">
										<?= $permission['description']; ?>
									</option>
								<?php endforeach; ?>
							</select>
							<p class="help-block">You can search and select multiple permissions.</p>
						</div>
					</div>
				</div>
				<!-- /.modal-body -->

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- remove role -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeRoleModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Remove Role</h4>
			</div>
			<div class="modal-body">
				<div id="remove-messages"></div>
				<p>Do you really want to remove ?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="removeRoleBtn">Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript" src="<?php echo base_url('custom/js/roles.js') ?>"></script>