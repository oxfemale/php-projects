<?php

$GLOBALS['counter'] = 0;
$filename = "C:\\Belkasoft\\Evidence Center.exe";
$handle = fopen($filename, "rb");
$contents = '';

function FindNameRename($filename){
$handle = fopen($filename, "rb");
  while (!feof($handle)) {
	$contents = fread($handle, 1);
	#<Module>
	if ($contents == '<') 
	{
$contents = fread($handle, 1);
if ($contents == 'M') 
{
$contents = fread($handle, 1);
if ($contents == 'o') 
{
$contents = fread($handle, 1);
if ($contents == 'd') 
{
$contents = fread($handle, 1);
if ($contents == 'u') 
{
$contents = fread($handle, 1);
if ($contents == 'l') 
{
$contents = fread($handle, 1);
if ($contents == 'e') 
{
$contents = fread($handle, 1);
if ($contents == '>') 
{
$contents = fread($handle, 1);
break;
}

}
}
}
}
}
}
}
}

$contents = fread($handle, 30);
$contents = strstr($contents, chr(0), true);
fclose($handle);
$contents = strtolower($contents);
	if( strstr($contents,".dll") or strstr($contents,".exe") ) 
	{
	print "filename: ".$contents."\r\n";
	$contents = "dump_".$contents;
	rename($filename, $contents);
	}
}

function dumpfile($handle, $start_offset, $hex){
	$GLOBALS['counter']++;	
	$filename = "dump_".$GLOBALS['counter'].".dmp";
	print $filename."\r\n";
	fseek($handle, $start_offset);
	$howsize = $hex - $start_offset;
print "Read/Write size: ".$howsize."\r\n";
	$dump = fread($handle, $howsize);
	$fp = fopen($filename, "wb");

	$fwrite = fwrite($fp, $dump);
        if ($fwrite === false) {
		print "error write dump\r\n";
		fclose($fp);
	        return $written;
        }
        fclose($fp);
	FindNameRename($filename);

}

function DumpMZP($handle, $start_offset) {
  while (!feof($handle)) {
	$contents = fread($handle, 1);
	if ($contents == 'M') 
	{
		$contents = fread($handle, 1);
		if ($contents == 'Z') 
		{
			$contents = fread($handle, 1);
			if ($contents == chr(144)) 
			{
				$hex = ftell($handle) - 3;
				print "end file offset: ".$hex."\r\n";
				
				dumpfile($handle, $start_offset, $hex);
				fseek($handle, $hex);

				return $counter;
			}

		}
	}
	
  }
}


while (!feof($handle)) {
	$contents = fread($handle, 1);
	$hex = ftell($handle);
	#print "offset ".$hex." bytes \r\n";
	if ($contents == 'M') 
	{
#print "find M\r\n";
		$contents = fread($handle, 1);
		if ($contents == "Z")
		{
#print "find Z\r\n";
			$contents = fread($handle, 1);
			if ($contents == chr(144)) 
			{
#print "find P\r\n";
				$hex = ftell($handle) - 3;
				print "start file offset: ".$hex."\r\n";
				DumpMZP($handle, $hex);
			}
		}
	}
	
}

fclose($handle);
?>
