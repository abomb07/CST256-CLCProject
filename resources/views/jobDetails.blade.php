<?php
/*
 * CLC Project version 6.0
 * User Profile version 6.0
 * Adam Bender and Jim Nguyen
 * April 5, 2020
 * Job Details Page
 */
?>

@extends('layouts.appmaster')
@section('title','Job Details Page')

@section('content')
@if(Session::get('principal') == true)

<h2>Job Details</h2>
<table>
	<tr>
		<td>Job Title:</td>
		<td>{{$job->getJobtitle()}}</td>
	</tr>

	<tr>
		<td>Category:</td>
		<td>{{$job->getCategory()}}</td>
	</tr>

	<tr>
		<td>Description:</td>
		<td>{{$job->getDescription()}}</td>
	</tr>

	<tr>
		<td>Requirements:</td>
		<td>{{$job->getRequirements()}}</td>
	</tr>

	<tr>
		<td>Company:</td>
		<td>{{$job->getCompany()}}</td>
	</tr>

	<tr>
		<td>Location:</td>
		<td>{{$job->getLocation()}}</td>
	</tr>

	<tr>
		<td>Salary:</td>
		<td>{{$job->getSalary()}}</td>
	</tr>
</table>

<form action='jobApply' method='POST'>
	{{ csrf_field() }} 
	<input type='hidden' name='jobtitle' value="{{ $job->getJobtitle()}}">
	<input type='hidden' name='jobcompany' value="{{ $job->getCompany()}}">
	<input type="submit" value="Apply" />
</form>

@else
<h2>Must be logged in to view job!!!</h2>
@endif @endsection
