<ol class="breadcrumb">
	<li><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
	<li class="active">Manage Users</li>
</ol>

<div class="panel panel-default">
	<div class="panel-body">
		<fieldset>
			<legend>Manage Users</legend>

			<div id="messages"></div>

			<div class="pull pull-right">
				<button type="button" class="btn btn-info" data-toggle="modal" data-target="#addUser" id="addUserModelBtn">
					<i class="glyphicon glyphicon-plus-sign"></i> Add User
				</button>
			</div>

			<br /> <br /> <br />

			<table id="manageUserTable" class="table table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Username</th>
						<th>Full Name</th>
						<th>Email</th>
						<th>Role</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>

		</fieldset>
	</div>
</div>

<!-- Add User Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addUser">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title">Add User</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form method="post" id="createUserForm" action="users/create" enctype="multipart/form-data">

				<div class="modal-body">

					<div id="add-user-messages"></div>

					<div class="form-group row">
						<label for="username" class="col-sm-2 col-form-label">Username:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="username" name="username" placeholder="Username">
						</div>
					</div>

					<div class="form-group row">
						<label for="fname" class="col-sm-2 col-form-label">First Name:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="fname" name="fname" placeholder="First Name">
						</div>
					</div>

					<div class="form-group row">
						<label for="lname" class="col-sm-2 col-form-label">Last Name:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name">
						</div>
					</div>

					<div class="form-group row">
						<label for="email" class="col-sm-2 col-form-label">Email:</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" id="email" name="email" placeholder="Email">
						</div>
					</div>

					<div class="form-group row">
						<label for="role_id" class="col-sm-2 col-form-label">Role:</label>
						<div class="col-sm-10">
							<select name="role_id" id="role_id" class="form-control">
								<option value="">-- Select Role --</option>
								<?php foreach ($roles as $role): ?>
									<option value="<?= $role['role_id']; ?>">
										<?= $role['role_name']; ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="password" class="col-sm-2 col-form-label">Password:</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="password" name="password" placeholder="Password">
						</div>
					</div>

					<div class="form-group row">
						<label for="confirm_password" class="col-sm-2 col-form-label">Confirm Password:</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
							<small id="passwordMatchMsg" class="form-text text-danger" style="display:none;">Passwords do not match</small>
						</div>
					</div>

				</div>
				<!-- /.modal-body -->

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>

			</form>

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Edit User Modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="updateUserModal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title">Edit User</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<div id="edit-user-messages"></div>
				<form method="post" id="updateUserInfoForm" action="users/updateInfo">
					<div class="modal-body">
						<div id="add-user-messages"></div>

						<div class="form-group row">
							<label for="editUsername" class="col-sm-2 col-form-label">Username:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="editUsername" name="editUsername" placeholder="Username">
							</div>
						</div>

						<div class="form-group row">
							<label for="editFname" class="col-sm-2 col-form-label">First Name:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="editFname" name="editFname" placeholder="First Name">
							</div>
						</div>

						<div class="form-group row">
							<label for="editLname" class="col-sm-2 col-form-label">Last Name:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="editLname" name="editLname" placeholder="Last Name">
							</div>
						</div>

						<div class="form-group row">
							<label for="editEmail" class="col-sm-2 col-form-label">Email:</label>
							<div class="col-sm-10">
								<input type="email" class="form-control" id="editEmail" name="editEmail" placeholder="Email">
							</div>
						</div>

						<div class="form-group row">
							<label for="editRoleId" class="col-sm-2 col-form-label">Role:</label>
							<div class="col-sm-10">
								<select name="editRoleId" id="editRoleId" class="form-control">
									<option value="">-- Select Role --</option>
									<?php foreach ($roles as $role): ?>
										<option value="<?= $role['role_id']; ?>">
											<?= $role['role_name']; ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label for="editPassword" class="col-sm-2 col-form-label">Password:</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" id="editPassword" name="editPassword" placeholder="Password">
							</div>
						</div>

						<div class="form-group row">
							<label for="editConfirmPassword" class="col-sm-2 col-form-label">Confirm Password:</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" id="editConfirmPassword" name="editConfirmPassword" placeholder="Confirm Password">
								<small id="passwordMatchMsg" class="form-text text-danger" style="display:none;">Passwords do not match</small>
							</div>
						</div>

					</div>
					<!-- /.modal-body -->

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
		<!-- /.modal-body -->

	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- remove user -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeUserModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Remove User</h4>
			</div>
			<div class="modal-body">
				<div id="remove-messages"></div>
				<p>Do you really want to remove ?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="removeUserBtn">Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript" src="<?php echo base_url('custom/js/users.js') ?>"></script>