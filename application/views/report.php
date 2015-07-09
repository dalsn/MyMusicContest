<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>MyMusic Table Report</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	</head>
	<body>
		

		<div class="container-fluid">

			<div>
				<a href="<?php echo base_url('home'); ?>"><img src="<?php echo base_url('/imgs/Logo.png'); ?>"\></a>
			</div>

	        <h1>Voilà!</h1>
	        <form class="form-inline" action="<?php echo base_url('home/search'); ?>" method="post" name="searchip">
				<div class="form-group">
					<!-- <label for="search">Search</label> -->
					<input type="text" class="form-control" id="search" placeholder="IP Address" name="ipaddress">
				</div>
				<button type="submit" class="btn btn-default">Search</button>
				<br><br>
			</form>
			<form class="form-inline" action="<?php echo base_url('home/searchdates'); ?>" method="post" name="searchdate">
				<p>Filter by date</p>
				<div class="form-group">
				<select class="form-control input-sm" name="selectdate">
					<option value="1">Expiry date</option>
					<option value="2">Download date</option>
				</select>
				</div>
				
				<div class="form-group">
					<label for="date1">From</label>
					<input type="text" class="form-control" id="date1" placeholder="dd-mm-yyyy" name="date1">
					<label for="date2">To</label>
					<input type="text" class="form-control" id="date2" placeholder="dd-mm-yyyy" name="date2">
				</div>
				<button type="submit" class="btn btn-default">Go >></button>
				<br><br>
			</form>
	        <div class="table-responsive">
	        <p style="font-weight:bold;"> Total records: <?php echo count($records); ?> </p>
		        <table class="table table-bordered table-hover">
		            <thead>
		            	<td>ID</td>
		            	<td>Track ID</td>
		            	<td>IP Address</td>
		            	<td>Expiry Date</td>
		            	<td>Transaction ID</td>
		            	<td>Status</td>
		            	<td>Source</td>
		            	<td>Type</td>
		            	<td>Download Date</td>
		            </thead>
		            <tbody>
		          	<?php

		          		if (!empty($records)) {

		            		foreach ($records as $record) {
		            ?>
		                <tr>
			                <td><?php echo $record->id; ?></td>
			                <td><?php echo $record->track_id; ?></td>
			            	<td><?php echo $record->ip_address; ?></td>
			            	<td><?php echo $record->expiry_date; ?></td>
			            	<td><?php echo $record->transaction_id; ?></td>
			            	<td><?php echo $record->dl_status; ?></td>
			            	<td><?php echo $record->dl_source; ?></td>
			            	<td><?php echo $record->dl_type; ?></td>
			            	<td><?php echo $record->dl_date; ?></td>		            	
		                </tr>
		            <?php 
		            		}
		            	} else { ?>
		            	<tr>
			                <td colspan="9">No record found!</td>		            	
		                </tr>
		            <?php 
		            	}
		            ?>
		            </tbody>
		        </table>
		    </div>

	    </div>
	    
	</body>
</html>
