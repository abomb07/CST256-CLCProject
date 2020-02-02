<?php 
/* CLC Project version 1.0
 * homePage version 1.0
 * Adam Bender and Jim Nguyen
 * January 19th, 2020
 * Registration Form
 */
?>
@extends('layouts.appmaster')
@section('title','Login Failed Page')

@section('content')
<form action = "processRegister" method = "POST">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token()?> "/>
<h2>Register</h2>
<table> 
<tr>
<td>Username: </td>
<td><input type= "text" name = "username" /> </td>
</tr>

<tr>
<td>Password: </td>
<td><input type= "password" name = "password" /> </td>
</tr>

<tr>
<td>First Name: </td>
<td><input type= "text" name = "firstname" /> </td>
</tr>

<tr>
<td>Last Name: </td>
<td><input type= "text" name = "lastname" /> </td>
</tr>
<tr>
<td>Email: </td>
<td><input type= "text" name = "email" /> </td>
</tr>

<tr>
<td>Role: </td>
<td><input type= "text" name = "role" /> </td>
</tr>

<tr>
<td colspan = "2" align = "center">
<input type = "submit" value = "Register" />
</td>
</tr>
</table>
</form>
@endsection