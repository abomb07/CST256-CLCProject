<?php
/*
 * CLC Project version 4.0
 * New Skill Form version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * New Skill Form
 */
?>
@extends('layouts.appmaster')
@section('title','New Skill')

@section('content')
@if(Session::get('principal'))
<div class="center">
	<h1>New Skill</h1>

	<form action="addSkill" method="POST">
		{{ csrf_field() }}

		<table>
			<tr>
				<td>Skill:</td>
				<td><input type="text" name="skill" value="" />{{$errors->first('skill')}}</td>
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
