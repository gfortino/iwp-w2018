<?php

// Print this project directory's file listing to screen.
// If you find a directory, enter it recursively.
// Using a function can be useful for recursion.

/*
* Code find on Stack Overflow written by RamRaider
*/
$startfolder=$_SERVER['DOCUMENT_ROOT'];
$files=array();


foreach( new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $startfolder, RecursiveDirectoryIterator::KEY_AS_PATHNAME ), RecursiveIteratorIterator::CHILD_FIRST ) as $file => $info ) {
	if( $info->isFile() && $info->isReadable() ){
		$files[]=array('filename'=>$info->getFilename(),'path'=>realpath( $info->getPathname() ) );
	}
}

echo '<pre>',print_r($files,true),'</pre>';
?>