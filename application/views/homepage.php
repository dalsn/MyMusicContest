<?php defined('BASEPATH') OR exit('No direct script access allowed');

	$msg = $this->session->userdata('uploadmsg');
?>

<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>MyMusic Contest</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	</head>
	<body>
		

		<div class="container-fluid">

			<div>
				<a href="<?php echo base_url('home'); ?>"><img src="<?php echo base_url('/imgs/Logo.png'); ?>"\></a>
			</div>

			<h1>Welcome!</h1>

	        <?php 
	            echo form_open_multipart('home/do_upload');
	            if (!empty($msg)) {
	                echo '<div style="color:red;">'. $msg .'</div>';
	            }
	        ?>
	        
	        <table>
	            <thead></thead>
	            <tbody>
	                <tr>
	                    <p>Upload CSV report file</p>
	                </tr>
	                <tr>
	                    <td colspan = "2">
	                        <input class="btn btn-default" type="file" name="csvfile" size="50" />
	                        <p class="help-block">You can only upload csv files. Max-Size: 3MB</p>
	                        <br />
	                    </td>
	                </tr>
	            </tbody>
	        </table>

	        	<input class="btn btn-primary" type="submit" value="Upload" />
	        <?php echo form_close(); ?>

	        <br><br>
	    	<a class="btn btn-success" href="<?php echo base_url('home/load_table'); ?>"> View Table >> </a>
	    </div>
	</body>
</html>
