<?php
// GET
foreach( $_GET as $variable => $valor ){
	$_GET [ $variable ] = str_replace ( "'" , "" , $_GET [ $variable ]);
	$_GET [ $variable ] = str_replace ( "&quot;" , "" , $_GET [ $variable ]);
	$_GET [ $variable ] = str_replace ( "--" , "-" , $_GET [ $variable ]);
}
foreach( $_GET as $variable => $valor ){
	$_GET [ $variable ] = str_replace ( "select" , " " , $_GET [ $variable ]);
	$_GET [ $variable ] = str_replace ( "update" , " " , $_GET [ $variable ]);
	$_GET [ $variable ] = str_replace ( "insert" , " " , $_GET [ $variable ]);
	$_GET [ $variable ] = str_replace ( "delete" , " " , $_GET [ $variable ]);
	$_GET [ $variable ] = str_replace ( "script" , " " , $_GET [ $variable ]);
	$_GET [ $variable ] = str_replace ( "trigger" , " " , $_GET [ $variable ]);
	$_GET [ $variable ] = str_replace ( "sleep" , " " , $_GET [ $variable ]);
	$_GET [ $variable ] = str_replace ( "waitfor delay" , " " , $_GET [ $variable ]);
}

// POST
foreach( $_POST as $variable => $valor ){
	$_POST [ $variable ] = str_replace ( "'" , " " , $_POST [ $variable ]);
	$_POST [ $variable ] = str_replace ( "&quot;" , " " , $_POST [ $variable ]);
	$_POST [ $variable ] = str_replace ( "--" , "-" , $_POST [ $variable ]);
}
foreach( $_POST as $variable => $valor ){
	$_POST [ $variable ] = str_replace ( "select" , " " , $_POST [ $variable ]);
	$_POST [ $variable ] = str_replace ( "update" , " " , $_POST [ $variable ]);
	$_POST [ $variable ] = str_replace ( "insert" , " " , $_POST [ $variable ]);
	$_POST [ $variable ] = str_replace ( "delete" , " " , $_POST [ $variable ]);
	$_POST [ $variable ] = str_replace ( "script" , " " , $_POST [ $variable ]);
	$_POST [ $variable ] = str_replace ( "trigger" , " " , $_POST [ $variable ]);
	$_POST [ $variable ] = str_replace ( "sleep" , " " , $_POST [ $variable ]);
	$_POST [ $variable ] = str_replace ( "waitfor delay" , " " , $_POST [ $variable ]);
}
?>