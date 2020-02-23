<?php
/*
 * CLC Project version 3.0
 * Edit Skill Form version 3.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * Edit Skill Form
 */
?>
@extends('layouts.appmaster')
@section('title','Edit Skill')

@section('content')
@if(Session::get('principal'))
<div class="center">
	<h1>Edit Skill</h1>

	<form action="updateSkill" method="POST">
		{{ csrf_field() }}

		<input type="hidden" value="{{ $skill->getId() }}" name="id">

		<table>
			<tr>
				<td>Skill:</td>
				<td><input type="text" name="skill" value="{{ $skill->getSkill() }}" />{{$errors->first('skill')}}</td>
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
