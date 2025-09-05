<div class="row">
	<div class="col-md-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<a href="student?opt=mgst" style="color:white;">
					Total Student : <span class="badge"><?php echo $countTotalStudent; ?></span>
				</a>
			</div>
		</div>
	</div>

	<div class="col-md-3">
		<div class="panel panel-success">
			<div class="panel-heading">
				<a href="teacher">
					Total Teacher : <span class="badge"><?php echo $countTotalTeacher; ?></span>
				</a>
			</div>
		</div>
	</div>

	<div class="col-md-3">
		<div class="panel panel-info">
			<div class="panel-heading">
				<a href="classes">
					Total Class : <span class="badge"><?php echo $countTotalClasses; ?></span>
				</a>

			</div>
		</div>
	</div>

	<div class="col-md-3">
		<div class="panel panel-warning">
			<div class="panel-heading">
				<a href="marksheet?opt=mngms">
					Total Marksheet : <span class="badge"><?php echo $countTotalMarksheet; ?></span>
				</a>
			</div>
		</div>
	</div>

	<div class="col-md-5">
		<div class="panel panel-primary">
			<div class="panel-heading"> Lifetime Income </div>
			<div class="panel-body">
				<center>
					<h3><b><?php echo $totalIncome; ?> </b></h3>
				</center>
			</div>
		</div>

		<div class="panel panel-primary">
			<div class="panel-heading"> Lifetime Expenses </div>
			<div class="panel-body">
				<center>
					<h3><b><?php echo $totalExpenses; ?></b></h3>
				</center>

			</div>
		</div>

		<div class="panel panel-primary">
			<div class="panel-heading "> Current Budget </div>
			<div class="panel-body">
				<center>
					<h3><b><?php echo $totalBudget; ?></b></h3>
				</center>
			</div>
		</div>
	</div>

	<div class="col-md-7">
		<div class="panel panel-primary">
			<div class="panel-heading"
				style="display:flex; justify-content:space-between; align-items:center;">
				<span>
					<i class="glyphicon glyphicon-calendar"></i> Calendar
				</span>
				<select class="form-control input-sm class-filter"
					style="max-width:160px; font-size:12px; padding:2px 6px; border-radius:4px; height:auto;">
					<option value="">All Classes</option>
					<?php foreach ($classes as $class): ?>
						<option value="<?php echo $class['class_id']; ?>">
							<?php echo $class['class_name']; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="panel-body">
				<div id="calendar"></div>
			</div>
		</div>
	</div>

</div>


<script type="text/javascript" src="<?php echo base_url('custom/js/dashboard.js') ?>"></script>