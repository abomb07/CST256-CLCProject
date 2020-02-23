<?php
/* CLC Project version 3.0
 * User Portfolio version 3.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * User Portfolio Page
 */
?>

@extends('layouts.appmaster')
@section('title','User Portfolio Page')

@section('content')
@if(Session::get('principal') == true)

<h2>JOB HISTORY</h2>
<a href="userPortfolioNewJobHistory">Add New Job History</a>
<table id="jobhistory" class="table table-hover">
	<tr>
		<tH>EDIT</tH>
		<tH>DELETE</tH>
		<tH>TITLE</tH>
		<tH>COMPANY</tH>
		<tH>START DATE</tH>
		<tH>END DATE</tH>
	</tr>
	
@if($jobhistorys)
	@foreach($jobhistorys as $jobhistory)

	<tr>
		<td>
			<form action='editJobHistory' method='POST'>
				{{ csrf_field() }} 
				<input type='hidden' name='id' value="{{ $jobhistory['ID'] }}"> 
				<input type='submit' value='Edit'>
			</form>
		</td>
		<td>
			<form action='deleteJobHistory' method='POST'>
				{{ csrf_field() }} 
				<input type='hidden' name='id' value="{{ $jobhistory['ID'] }}"> 
				<input type='submit' value='Delete'>
			</form>
		</td> 

		<td>{{$jobhistory['TITLE']}}</td>
		<td>{{$jobhistory['COMPANY']}}</td>
		<td>{{$jobhistory['START_DATE']}}</td>
		<td>{{$jobhistory['END_DATE']}}</td>

	</tr>

	@endforeach
@endif

</table>
<br />

<h2>SKILLS</h2>
<a href="userPortfolioNewSkill">Add New Skill</a>
<table id="skills" class="table table-hover">
	<tr>
		<tH>EDIT</tH>
		<tH>DELETE</tH>
		<tH>SKILL</tH>
	</tr>

@if($skills)
	@foreach($skills as $skill)

	<tr>
		<td>
			<form action='editSkill' method='POST'>
				{{ csrf_field() }} 
				<input type='hidden' name='id' value="{{ $skill['ID'] }}"> 
				<input type='submit' value='Edit'>
			</form>
		</td>
		<td>
			<form action='deleteSkill' method='POST'>
				{{ csrf_field() }} 
				<input type='hidden' name='id' value="{{ $skill['ID'] }}"> 
				<input type='submit' value='Delete'>
			</form>
		</td> 

		<td>{{$skill['SKILL']}}</td>

	</tr>

	@endforeach
@endif
</table>
<br />

<h2>EDUCATION</h2>
<a href="userPortfolioNewEducation">Add New Education</a>
<table id="education" class="table table-hover">
	<tr>
		<tH>EDIT</tH>
		<tH>DELETE</tH>
		<tH>SCHOOL</tH>
		<tH>DEGREE</tH>
		<tH>FIELD</tH>
		<tH>GRADUATION YEAR</tH>
	</tr>

@if($educations)
	@foreach($educations as $education)

	<tr>
		<td>
			<form action='editEducation' method='POST'>
				{{ csrf_field() }} 
				<input type='hidden' name='id' value="{{ $education['ID'] }}"> 
				<input type='submit' value='Edit'>
			</form>
		</td>
		<td>
			<form action='deleteEducation' method='POST'>
				{{ csrf_field() }} 
				<input type='hidden' name='id' value="{{ $education['ID'] }}"> 
				<input type='submit' value='Delete'>
			</form>
		</td> 

		<td>{{$education['SCHOOL']}}</td>
		<td>{{$education['DEGREE']}}</td>
		<td>{{$education['FIELD']}}</td>
		<td>{{$education['GRADUATION_YEAR']}}</td>

	</tr>

	@endforeach
@endif
</table>

@else
<h2>Must be logged in to view portfolio!!!</h2>
@endif 
@endsection