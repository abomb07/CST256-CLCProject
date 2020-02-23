<?php
/*
 * CLC Project version 3.0
 * Admin job page version 3.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * Admin Jobs Page
 */
?>
@extends('layouts.appmaster')
@section('title','Admin Job Page')

@section('content')
@if(Session::get('principal') == true and Session::get('role') == "admin")

<a href="adminNewJobForm">Add New Job Posting</a>

<table id="jobs" class="table table-hover">
	<tr>
		<tH></tH>
		<tH></tH>
		<tH>ID</tH>
		<tH>JOB TITLE</tH>
		<tH>CATEGORY</tH>
		<tH>DESCRIPTION</tH>
		<tH>REQUIREMENTS</tH>
		<tH>COMPANY</tH>
		<tH>LOCATION</tH>
		<tH>SALARY</tH>
	</tr>

@if($jobs)
	@foreach($jobs as $job)

	<tr>
		<td>
			<form action='adminJobEdit' method='POST'>
				{{ csrf_field() }} 
				<input type='hidden' name='id' value="{{ $job['ID'] }}"> 
				<input type='submit' value='Edit'>
			</form>
		</td>
		<td>
			<form action='adminConfirmJobDelete' method='POST'>
				{{ csrf_field() }} 
				<input type='hidden' name='id' value="{{ $job['ID'] }}"> 
				<input type='submit' value='Delete'>
			</form>
		</td> 

		<td>{{$job['ID']}}</td>
		<td>{{$job['JOB_TITLE']}}</td>
		<td>{{$job['CATEGORY']}}</td>
		<td>{{$job['DESCRIPTION']}}</td>
		<td>{{$job['REQUIREMENTS']}}</td>
		<td>{{$job['COMPANY']}}</td>
		<td>{{$job['LOCATION']}}</td>
		<td>{{$job['SALARY']}}</td>

	</tr>

	@endforeach
@endif
</table>


@else
<h2>User is not authorized!!!</h2>
@endif 
@endsection
