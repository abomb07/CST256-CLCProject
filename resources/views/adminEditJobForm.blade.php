<?php
/*
 * CLC Project version 3.0
 * Admin Edit Job Form version 2.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * Admin Edit Job Form
 */
?>
@extends('layouts.appmaster')
@section('title','Edit Job')

@section('content')
@if(Session::get('principal') == true and Session::get('role') == "admin")
<div class="center">
	<h1>Edit Job</h1>

	<form action="editJobPosting" method="POST">
		{{ csrf_field() }}
		
		<input type="hidden" id="id" value="{{ $job->getId() }}" name="id">

		<table>
			<tr>
				<td>Job Title:</td>
				<td><input type="text" name="jobtitle" value="{{$job->getJobtitle()}}" /></td>
			</tr>

			<tr>
				<td>Category:</td>
				<td><input type="text" name="category" value="{{$job->getCategory()}}" /></td>
			</tr>

			<tr>
				<td>Description:</td>
				<td><input type="text" name="description" value="{{$job->getDescription()}}" /></td>
			</tr>

			<tr>
				<td>Requirements:</td>
				<td><input type="text" name="requirements" value="{{$job->getRequirements()}}" /></td>
			</tr>

			<tr>
				<td>Company:</td>
				<td><input type="text" name="company" value="{{$job->getCompany()}}" /></td>
			</tr>

			<tr>
				<td>Location:</td>
				<td><input type="text" name="location" value="{{$job->getLocation()}}" /></td>
			</tr>

			<tr>
				<td>Salary:</td>
				<td><input type="text" name="salary" value="{{$job->getSalary()}}" /></td>
			</tr>

			<tr>
				<td colspan="2" align="center">
				<input type="submit" value="Update" /></td>
			</tr>
		</table>
	</form>

</div>
@else
<h2>User is not authorized!!!</h2>
@endif 
@endsection
