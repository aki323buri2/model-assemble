@extends('layouts/master')
@section('title', 'vuevue')
<?php
$links = array_merge((array)@$links, [
	'/vendor/vue/dist/vue.js',
]);
?>
@section('main')

<div id="app">
	<ul>
		<li class="user" v-for="user in users" transition>
			<span>@{{ user.name }} - @{{ user.email }}</span>
			<button v-on:click="removeUser(user)">X</button>
		</li>
	</ul>
	<form id="form" v-on:submit.prevent="addUser">
		<input v-model="newUser.name">
		<input v-model="newUser.email">
		<input type="submit" value="Add User">
	</form>
	<ul class="errors">
		<li v-show="!validation.name">Name cannot be empty.</li>
		<li v-show="!validation.email">Please Provide a valid email address.</li>
	</ul>
</div>

@endsection
@push('styles')
<style>
.user
{
	transition: all .25s ease;
}
.user:last-child
{
	border-bottom: 1px solid #eee;
}
.v-enter, .v-leave
{
	height: 0;
	border: 0;
}
.errors
{
	color: #f00;
}
</style>
@endpush
@push('scripts-after')
<script>
$(function ()
{
	var app = new Vue({
		// element to mount to
		el: '#app'
		// initial data
		, data: {
			users: []
			, newUser: {
				  name: ''
				, email: ''
			}
		}
	});

});
</script>
@endpush