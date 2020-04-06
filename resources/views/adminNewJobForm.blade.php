<?php
/*
 * CLC Project version 6.0
 * Admin New Job Form version 6.0
 * Adam Bender and Jim Nguyen
 * April 5, 2020
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
				<td><input type="text" name="jobtitle" value="" />{{$errors->first('jobtitle')}}</td>
			</tr>

			<tr>
				<td>Category:</td>
				<td><input type="text" name="category" value="" />{{$errors->first('category')}}</td>
			</tr>

			<tr>
				<td>Description:</td>
				<td><input type="text" name="description" value="" />{{$errors->first('description')}}</td>
			</tr>

			<tr>
				<td>Requirements:</td>
				<td><input type="text" name="requirements" value="" />{{$errors->first('requirements')}}</td>
			</tr>

			<tr>
				<td>Company:</td>
				<td><input type="text" name="company" value="" />{{$errors->first('company')}}</td>
			</tr>

			<tr>
				<td>Location:</td>
				<td><input type="text" name="location" value="" />{{$errors->first('location')}}</td>
			</tr>

			<tr>
				<td>Salary:</td>
				<td><input type="text" name="salary" value="" />{{$errors->first('salary')}}</td>
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
