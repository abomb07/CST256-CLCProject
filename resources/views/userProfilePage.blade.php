<?php
/*
 * CLC Project version 3.0
 * User Profile version 2.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * User Profile Page
 */
?>

@extends('layouts.appmaster')
@section('title','User Profile Page')

@section('content')
@if(Session::get('principal') == true)

<h2>User Profile</h2>
<table>
	<tr>
		<td>Username:</td>
		<td>{{$user->getUsername()}}</td>
	</tr>

	<tr>
		<td>Password:</td>
		<td>{{$user->getPassword()}}</td>
	</tr>

	<tr>
		<td>First Name:</td>
		<td>{{$user->getFirstname()}}</td>
	</tr>

	<tr>
		<td>Last Name:</td>
		<td>{{$user->getLastname()}}</td>
	</tr>

	<tr>
		<td>Email:</td>
		<td>{{$user->getEmail()}}</td>
	</tr>

	<tr>
		<td>Phone Number:</td>
		<td>{{$user->getPhonenumber()}}</td>
	</tr>

	<tr>
		<td>City:</td>
		<td>{{$user->getCity()}}</td>
	</tr>
</table>

<form action='editProfile' method='POST'>
	{{ csrf_field() }} 
	<input type='hidden' name='id' value="{{ $user->getID()}}">
	<input type="submit" value="Edit" />
</form>

@else
<h2>Must be logged in to view profile!!!</h2>
@endif @endsection
