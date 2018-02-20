<?php

$texfilename='mypapers.tex';
$resultfile='mypapers.html';
$compileGlobalDir=__DIR__.'/uploads/';



// Check if we've uploaded a file
if (!empty($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    // Be sure we're dealing with an upload
    if (is_uploaded_file($_FILES['file']['tmp_name']) === false) {
        throw new \Exception('Error on upload: Invalid file definition');
    }

    // Rename the uploaded file
    $uploadName = $_FILES['file']['name'];
    $filename = round(microtime(true)).mt_rand();
    $compiledir = $compileGlobalDir.$filename.'/';
    $fullfilename = $compiledir.$filename;

    mkdir($compiledir);
    copy(__DIR__.'/'.$texfilename,$compiledir.$texfilename);

    move_uploaded_file($_FILES['file']['tmp_name'], $fullfilename.".bib");
    

    //compile file


	$compile_command='cd '.$compiledir.' && ht latex "\def\bibfilename{'.$fullfilename.'}\input '.$texfilename.'"';
	$bibl_command='cd '.$compiledir.' && bibtex mypapers';

	$log="";
	$log.= $compile_command.":<br>";
	$log.= nl2br(shell_exec ($compile_command));
	$log.= "<hr>";
	$log.= $bibl_command.":<br>";
	$log.= nl2br(shell_exec ($bibl_command));
	$log.= "<hr>";
	$log.= nl2br(shell_exec ($compile_command));

	if (file_exists ( $compiledir.$resultfile )){
		echo file_get_contents($compiledir.$resultfile);
	} else {
		echo "<br>Something went wrong while compiling, here is log:<br><hr>".$log;
	}

	array_map('unlink', glob("$compiledir*.*"));
	rmdir($compiledir);

} else {
	echo "something went wrong!";
}

?>