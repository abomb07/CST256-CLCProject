<?php
/* CLC Project version 4.0
 * Home Page version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
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
	</tbody>
</table>

<script>
$(document).ready( function () {
    $('#table_id').DataTable();
} );
</script>

@endsection