<?php 
/* CLC Project version 1.0
 * Login version 1.0
 * Adam Bender and Jim Nguyen
 * January 19th, 2020
 * Login Form
 */
?>
@extends('layouts.appmaster')
@section('title','Login Page')

@section('content')
<form action = "processLogin" method = "POST">
	<input type = "hidden" name = "_token"
	value = "<?php echo csrf_token()?> "/>
	<table> 
	<tr>
		<td>User Name: </td>
		<td><input type= "text" name = "username" /> </td>
	</tr>
	
	<tr>
		<td>Password: </td>
		<td><input type= "password" name = "password" /> </td>
	</tr>
	
	<tr>
		<td colspan = "2" align = "center">
			<input type = "submit" value = "Submit" />
		</td>
	</tr>
	</table>
</form>
@endsection