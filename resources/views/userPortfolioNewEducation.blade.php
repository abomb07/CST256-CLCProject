<?php
/*
 * CLC Project version 4.0
 * New Education Form version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * New Education Form
 */
?>
@extends('layouts.appmaster')
@section('title','New Education')

@section('content')
@if(Session::get('principal'))
<div class="center">
	<h1>New Education</h1>

	<form action="addEducation" method="POST">
		{{ csrf_field() }}

		<table>
			<tr>
				<td>School:</td>
				<td><input type="text" name="school" value="" />{{$errors->first('school')}}</td>
			</tr>

			<tr>
				<td>Degree:</td>
				<td><input type="text" name="degree" value="" />{{$errors->first('degree')}}</td>
			</tr>

			<tr>
				<td>Field:</td>
				<td><input type="text" name="field" value="" />{{$errors->first('field')}}</td>
			</tr>

			<tr>
				<td>Graduation Year:</td>
				<td><input type="text" name="graduationyear" value="" />{{$errors->first('graduationyear')}}</td>
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
