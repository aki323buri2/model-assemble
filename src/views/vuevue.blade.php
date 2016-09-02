@extends('layouts/master')
@section('title', 'vuevue')
<?php
$links = array_merge((array)@$links, [
	'/vendor/vue/dist/vue.js',
]);
?>
@section('main')

<div id="app">
	<input type="text" v-model="user.name">
	<input type="text" v-model="user.email">
	<button v-on:click="addUser">add</button>

	<ul class="errors">
		<li v-show="!validation.name">name cannot be empty!</li>
		<li v-show="!validation.email">Please provide a valid email address!</li>
	</ul>

	<ul>
		<li v-for="user in users">
			@{{ user.name }}
			-
			@{{ user.email }}
			<button v-on:click="removeUser(user)">X</button>
		</li>
	</ul>
</div>

@endsection
@push('scripts-after')
<script>
$(function ()
{
	var emailRE = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	var app = new Vue({
		el: '#app'
		, data: {
			user: {
				  name: 'aaa'
				, email: 'aaa@bbb.ccc'
			}
			, users: []
			, counter: 0
		}
		, methods: {
			addUser: function ()
			{
				if (this.isValid)
				{
					this.users.push($.extend(true, {}, this.user));
					this.user.name += ++this.counter;
				}
			}
			, removeUser: function (user)
			{
				this.users.$remove(user);
			}
		}
		, computed: {
			validation: function ()
			{
				return {
					name: !!this.user.name.trim()
					, email: emailRE.test(this.user.email)
				};
			}
			, isValid: function ()
			{
				var validation = this.validation;
				return Object.keys(validation).every(function (key)
				{
					return validation[key];
				});
			}
		}
	});
});
</script>
@endpush