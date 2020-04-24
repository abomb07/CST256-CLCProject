<?php
/*
 * CLC Project version 5.0
 * Edit Job History Form version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
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
				<td><input type="text" name="title" value="{{ $jobhistory->getTitle() }}" />{{$errors->first('title')}}</td>
			</tr>

			<tr>
				<td>Company:</td>
				<td><input type="text" name="company" value="{{ $jobhistory->getCompany() }}" />{{$errors->first('company')}}</td>
			</tr>

			<tr>
				<td>Start Date:</td>
				<td><input type="date" name="startdate" value="{{ $jobhistory->getStartdate() }}" />{{$errors->first('startdate')}}</td>
			</tr>

			<tr>
				<td>End Date:</td>
				<td><input type="date" name="enddate" value="{{ $jobhistory->getEnddate() }}" />{{$errors->first('enddate')}}</td>
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
