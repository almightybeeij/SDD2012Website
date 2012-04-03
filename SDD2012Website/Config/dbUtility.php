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
	
	return (count($out) == 0) ? false : $out;
}

function bindParameters (&$parameters)
{
	$params = array();
	
	for ($i = 1; $i < sizeof($parameters); $i++)
	{
		$params[$i - 1] = $parameters[$i];
	}
	
	call_user_func_array(mysqli_stmt_bind_param, $parameters);
}

?>