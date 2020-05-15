<?php 
	$obj = json_decode($_GET["x"]);

	if(!strcmp($obj->operation, "listScanners"))
	{
		echo(shell_exec("scanimage -f\"%m;%d%n\""));
		//scan("Test", "png", 75, 10, 10);
	}
	else if(!strcmp($obj->operation, "scan"))
	{
		scan($obj->device, $obj->fileType, $obj->dpi, $obj->width, $obj->height);
	}

	function scan($device, $fileFormat, $dpi, $width, $height)
	{		
		$fileTypus = [
			"png" => "image/png",
			"jpeg" => "image/jpeg",
			"tiff" => "image/tiff",
			"pdf" => "application/pdf",
			"pnm" => "image/x-portable-anymap"
		];

		if(!(is_numeric($dpi) && is_numeric($width) && is_numeric($height)))
			return;

		error_log("Hallo?!", 4);

		/*if(!array_key_exists($fileFormat, $fileTypus));
			return;*/

		$cmdout = "";
		$ecode = -666;
		$arg_device = "-d " . escapeshellarg($device);
		$arg_width = ($width > 0) ? "--x {$width}" : "";
		$arg_height = ($height > 0) ? "--y {$height}" : "";
		$arg_dpi = ($dpi > 0) ? "--resolution {$dpi}" : "";
		$arg_scanformat = "--format {$fileFormat}";

		$mimeT = $fileTypus[strtolower($fileFormat)];
		header("Content-type: {$mimeT}");
		error_log("scanimage {$arg_device} {$arg_scanformat} {$arg_dpi} {$arg_width} {$arg_height}", 4);
		passthru("scanimage {$arg_device} {$arg_scanformat} {$arg_dpi} {$arg_width} {$arg_height}", $ecode);

		//echo($mimeT);
		//echo("scanimage {$arg_device} {$arg_scanformat} {$arg_dpi} {$arg_width} {$arg_height}");
	}
?>