<?php
/*
 * CLC Project version 5.0
 * User Profile version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
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

	@if(Session::get('id') == $user->getId())
	<tr>
		<td>Password:</td>
		<td>{{$user->getPassword()}}</td>
	</tr>
	@endif

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

	@if(Session::get('id') == $user->getId())
	<tr>
		<td>Phone Number:</td>
		<td>{{$user->getPhonenumber()}}</td>
	</tr>
	@endif

	<tr>
		<td>City:</td>
		<td>{{$user->getCity()}}</td>
	</tr>
</table>

@if(Session::get('id') == $user->getId())
<form action='editProfile' method='POST'>
	{{ csrf_field() }} 
	<input type='hidden' name='id' value="{{ $user->getID()}}">
	<input type="submit" value="Edit" />
</form>
@endif

@else
<h2>Must be logged in to view profile!!!</h2>
@endif @endsection
