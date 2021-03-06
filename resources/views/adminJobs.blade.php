<?php
/*
 * CLC Project version 5.0
 * Admin job page version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
 * Admin Jobs Page
 */
?>
@extends('layouts.appmaster')
@section('title','Admin Job Page')

@section('content')
@if(Session::get('principal') == true and Session::get('role') == "admin")

<a href="adminNewJobForm">Add New Job Posting</a>

<table id="table_id" class="table table-hover">
	<thead>
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
	</thead>

	<tbody>
@if($jobs)
	@foreach($jobs as $job)

	<tr>
		<td>
			<form action='adminJobEdit' method='POST'>
				{{ csrf_field() }} 
				<input type='hidden' name='id' value="{{ $job->getId() }}"> 
				<input type='submit' value='Edit'>
			</form>
		</td>
		<td>
			<form action='adminConfirmJobDelete' method='POST'>
				{{ csrf_field() }} 
				<input type='hidden' name='id' value="{{ $job->getId() }}"> 
				<input type='submit' value='Delete'>
			</form>
		</td> 

		<td>{{$job->getId()}}</td>
		<td>{{$job->getJobtitle()}}</td>
		<td>{{$job->getCategory()}}</td>
		<td>{{$job->getDescription()}}</td>
		<td>{{$job->getRequirements()}}</td>
		<td>{{$job->getCompany()}}</td>
		<td>{{$job->getLocation()}}</td>
		<td>{{$job->getSalary()}}</td>

	</tr>

	@endforeach
@endif
	</tbody>
</table>
<script>
$(document).ready( function () {
    $('#table_id').DataTable();
} );
</script>

@else
<h2>User is not authorized!!!</h2>
@endif 
@endsection
