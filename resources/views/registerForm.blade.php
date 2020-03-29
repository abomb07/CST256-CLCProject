<?php 
/* CLC Project version 5.0
 * homePage version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
 * Registration Form
 */
?>
@extends('layouts.appmaster')
@section('title','Register Page')

@section('content')
<form action = "processRegister" method = "POST">
{{ csrf_field() }}
<h2>Register</h2>
<table> 
<tr>
<td>Username: </td>
<td><input type= "text" name = "username" placeholder = "UserName"/> {{$errors->first('username')}}</td>
</tr>

<tr>
<td>Password: </td>
<td><input type= "password" name = "password" placeholder = "Password"/> {{$errors->first('password')}}</td>
</tr>

<tr>
<td>First Name: </td>
<td><input type= "text" name = "firstname" placeholder = "First Name"/> {{$errors->first('firstname')}}</td>
</tr>

<tr>
<td>Last Name: </td>
<td><input type= "text" name = "lastname" placeholder = "Last Name"/> {{$errors->first('lastname')}}</td>
</tr>

<tr>
<td>Email: </td>
<td><input type= "text" name = "email" placeholder = "Email" /> {{$errors->first('email')}}</td>
</tr>

<tr>
<td>Phone Number: </td>
<td><input type= "text" name = "phonenumber" placeholder = "(123)-456-7890"/> {{$errors->first('phonenumber')}}</td>
</tr>

<tr>
<td>City: </td>
<td><input type= "text" name = "city" placeholder = "City"/> {{$errors->first('city')}}</td>
</tr>

<tr>
<td>Role: </td>
<td><select class="form-control" id="role" name="role"> 
			<option>user</option>
			<option>admin</option>
			</select>
{{$errors->first('role')}}
</td>
</tr>

<tr>
<td colspan = "2" align = "center">
<input type = "submit" value = "Register" />
</td>
</tr>
</table>
</form>

@endsection