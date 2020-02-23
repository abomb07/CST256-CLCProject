<?php
/*
 * CLC Project version 3.0
 * New Job History Form version 2.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * New Job History Form
 */
?>
@extends('layouts.appmaster')
@section('title','New Job History')

@section('content')
@if(Session::get('principal'))
<div class="center">
	<h1>New Job History</h1>

	<form action="addJobHistory" method="POST">
		{{ csrf_field() }}

		<table>
			<tr>
				<td>Job Title:</td>
				<td><input type="text" name="title" value="" /></td>
			</tr>

			<tr>
				<td>Company:</td>
				<td><input type="text" name="company" value="" /></td>
			</tr>

			<tr>
				<td>Start Date:</td>
				<td><input type="date" name="startdate" value="" /></td>
			</tr>

			<tr>
				<td>End Date:</td>
				<td><input type="date" name="enddate" value="" /></td>
			</tr>

			<tr>
				<td colspan="2" align="center"><input type="submit" value="Add" /></td>
			</tr>
		</table>
		
		<input type='hidden' name='user_id' value="{{Session::get('id')}}"> 
	</form>

</div>
@else
<h2>Must be logged in to view portfolio!!!</h2>
@endif 
@endsection