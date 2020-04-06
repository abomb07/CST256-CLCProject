<?php
/*
 * CLC Project version 6.0
 * Admin job page version 6.0
 * Adam Bender and Jim Nguyen
 * April 5, 2020
 * Jobs Search Result Page
 */
?>
@extends('layouts.appmaster')
@section('title','Search Result Page')

@section('content')
@if(Session::get('principal'))

<table id="table_id" class="table table-hover display">
	<thead>
	<tr>
		<tH>JOB TITLE</tH>
		<tH>DESCRIPTION</tH>
		<tH>COMPANY</tH>
		<tH>LOCATION</tH>
		<tH>SALARY</tH>
		<tH></tH>
	</tr>
	</thead>

	<tbody>
@if($jobs)
	@foreach($jobs as $job)
	
	<tr>
		<td>{{$job->getJobtitle()}}</td>
		<td>{{$job->getDescription()}}</td>
		<td>{{$job->getCompany()}}</td>
		<td>{{$job->getLocation()}}</td>
		<td>{{$job->getSalary()}}</td>
		<td>
			<form action='jobDetails' method='POST'>
				{{ csrf_field() }} 
				<input type='hidden' name='id' value="{{ $job->getId() }}"> 
				<input type='submit' value='Details'>
			</form>
		</td>
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
<h2>Must be logged in!!!</h2>
@endif 
@endsection
