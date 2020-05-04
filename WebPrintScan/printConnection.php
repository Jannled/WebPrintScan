<?php 
	$obj = json_decode($_GET["x"]);

	if(!strcmp($obj->operation, "listScanners"))
	{
		echo(shell_exec("scanimage -f\"%m;%d%n\""));
	}
	else if(!strcmp($obj->operation, "scan"))
	{
		scan($obj->device, $obj->fileType, $obj->dpi, $obj->width, $obj->height, $obj->fileID);
	}

	function scan($device, $fileFormat, $dpi, $width, $height, $fileID)
	{
		$cmdout = "";
		$ecode = -666;
		$arg_fileName = "/tmp/scans/{$fileID}.{$fileFormat}";
		$arg_width = ($width > 0) ? "--x {$width}" : "";
		$arg_height = ($height > 0) ? "--y {$height}" : "";
		$arg_dpi = ($dpi > 0) ? "--resolution {$dpi}" : "";

		header('Content-type: image/png');
		passthru("scanimage -d {$device} --format {$fileFormat} {$arg_dpi} {$arg_width} {$arg_height}", $ecode);
	}
?>