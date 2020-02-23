<?php
/*
 * CLC Project version 3.0
 * Edit Job History Form version 2.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * Edit Job History Form
 */
?>
@extends('layouts.appmaster')
@section('title','Edit Job History')

@section('content')
@if(Session::get('principal'))
<div class="center">
	<h1>Edit Job History</h1>

	<form action="updateJobHistory" method="POST">
		{{ csrf_field() }}

		<input type="hidden" value="{{ $jobhistory->getId() }}" name="id">

		<table>
			<tr>
				<td>Job Title:</td>
				<td><input type="text" name="title" value="{{ $jobhistory->getTitle() }}" /></td>
			</tr>

			<tr>
				<td>Company:</td>
				<td><input type="text" name="company" value="{{ $jobhistory->getCompany() }}" /></td>
			</tr>

			<tr>
				<td>Start Date:</td>
				<td><input type="text" name="startdate" value="{{ $jobhistory->getStartdate() }}" /></td>
			</tr>

			<tr>
				<td>End Date:</td>
				<td><input type="text" name="enddate" value="{{ $jobhistory->getEnddate() }}" /></td>
			</tr>

			<tr>
				<td colspan="2" align="center"><input type="submit" value="Update" /></td>
			</tr>
		</table>
		
		<input type='hidden' name='user_id' value="{{Session::get('id')}}"> 
	</form>

</div>
@else
<h2>Must be logged in to view portfolio!!!</h2>
@endif 
@endsection
