<?php
/* CLC Project version 3.0
 * User Profile version 2.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * Edit User Profile Page
 */
?>
@extends('layouts.appmaster')
@section('title','User Edit Profile Page')

@section('content')
<form action = "processUserProfileEdit" method = "POST">

{{ csrf_field() }}

<input type= "hidden" name = "id" value="{{ $users->getId() }}"/>
<input type= "hidden" name = "role" value="{{ $users->getRole() }}"/>
<input type= "hidden" name = "status" value="{{ $users->getStatus() }}"/>
<h2>User Profile</h2>
<table> 
<tr>
<td>Username: </td>
<td><input type= "text" name = "username" value="{{ $users->getUsername() }}"/> </td>
</tr>

<tr>
<td>Password: </td>
<td><input type= "text" name = "password" value="{{ $users->getPassword() }}"/> </td>
</tr>

<tr>
<td>First Name: </td>
<td><input type= "text" name = "firstname" value="{{ $users->getFirstname() }}"/> </td>
</tr>

<tr>
<td>Last Name: </td>
<td><input type= "text" name = "lastname" value="{{ $users->getLastname() }}"/> </td>
</tr>

<tr>
<td>Email: </td>
<td><input type= "text" name = "email" value="{{ $users->getEmail() }}"/> </td>
</tr>

<tr>
<td>Phone Number: </td>
<td><input type= "text" name = "phonenumber" value="{{ $users->getPhonenumber() }}"/> </td>
</tr>

<tr>
<td>City: </td>
<td><input type= "text" name = "city" value="{{ $users->getCity() }}"/> </td>
</tr>

<tr>
<td colspan = "2" align = "center">
<input type = "submit" value = "Save Changes" />
</td>
</tr>
</table>
</form>

@endsection