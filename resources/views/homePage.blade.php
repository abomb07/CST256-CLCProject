<?php
/* CLC Project version 6.0
 * Home Page version 6.0
 * Adam Bender and Jim Nguyen
 * April 5, 2020
 * Home Page Form
 */
?>
@extends('layouts.appmaster')
@section('title','Home Page')

@section('content')
<h2>Featured Jobs</h2>
<a href="jobSearch">Search For Jobs Here</a>

<table id="table_id" class="table table-hover display">
	<thead>
	<tr>
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

@endsection