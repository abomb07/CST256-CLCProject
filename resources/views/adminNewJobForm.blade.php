<?php
/*
 * CLC Project version 3.0
 * Admin New Job Form version 2.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * Admin New Job Form
 */
?>
@extends('layouts.appmaster')
@section('title','New Job')

@section('content')
@if(Session::get('principal') == true and Session::get('role') == "admin")
<div class="center">
	<h1>New Job Posting</h1>

	<form action="newJobPosting" method="POST">
		{{ csrf_field() }}

		<table>
			<tr>
				<td>Job Title:</td>
				<td><input type="text" name="jobtitle" value="" /></td>
			</tr>

			<tr>
				<td>Category:</td>
				<td><input type="text" name="category" value="" /></td>
			</tr>

			<tr>
				<td>Description:</td>
				<td><input type="text" name="description" value="" /></td>
			</tr>

			<tr>
				<td>Requirements:</td>
				<td><input type="text" name="requirements" value="" /></td>
			</tr>

			<tr>
				<td>Company:</td>
				<td><input type="text" name="company" value="" /></td>
			</tr>

			<tr>
				<td>Location:</td>
				<td><input type="text" name="location" value="" /></td>
			</tr>

			<tr>
				<td>Salary:</td>
				<td><input type="text" name="salary" value="" /></td>
			</tr>

			<tr>
				<td colspan="2" align="center"><input type="submit" value="Post" /></td>
			</tr>
		</table>
	</form>

</div>
@else
<h2>User is not authorized!!!</h2>
@endif @endsection
