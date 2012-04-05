<?php

function fetchArray (&$statement)
{
	$data = mysqli_stmt_result_metadata($statement);
	$fields = array();
	$out = array();

	$fields[0] = $statement;
	$count = 1;

	while($field = mysqli_fetch_field($data))
	{
		$fields[$count] = &$out[$field->name];
		$count++;
	}

	call_user_func_array(mysqli_stmt_bind_result, $fields);
	mysqli_stmt_fetch($statement);
	
	return (count($out) == 0) ? false : $out;
}

function bindParameters (&$stmt, &$bindParams)
{
	$bindParamsReferences = array();
	$bindParamsMethod = new ReflectionMethod('mysqli_stmt', 'bind_param');
		
	$typeDefinitionString = array_shift($bindParams);
	
	foreach($bindParams as $key => $value) {
		$bindParamsReferences[$key] = &$bindParams[$key];
	}

	array_unshift($bindParamsReferences,$typeDefinitionString);
	$bindParamsMethod->invokeArgs($stmt,$bindParamsReferences);
}

?>