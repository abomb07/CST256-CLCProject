<?php 
/* CLC Project version 5.0
 * Login Form version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
 * Login Form
 */
?>
@extends('layouts.appmaster')
@section('title','Login Page')

@section('content')
<h2>Login</h2>
<form action = "processLogin" method = "POST">
	{{ csrf_field() }}
	<table> 
	<tr>
		<td>Username: </td>
		<td><input type= "text" name = "username" /> {{$errors->first('username')}}</td>
	</tr>
	
	<tr>
		<td>Password: </td>
		<td><input type= "password" name = "password" /> {{$errors->first('password')}}</td>
	</tr>
	
	<tr>
		<td colspan = "2" align = "center">
			<input type = "submit" value = "Login" />
		</td>
	</tr>
	</table>
</form>

@endsection