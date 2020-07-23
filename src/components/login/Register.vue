<template>
	<section class="section register">
		<div class="container">

			<h1 class="title">Register</h1>

			<div class="columns">
				<div class="column">
					<div class="field">
						<label class="label">First Name</label>
						<div class="control">
							<input v-model="firstName" class="input" type="text" placeholder="" required>
						</div>
					</div>
				</div>
				<div class="column">
					<div class="field">
						<label class="label">Last Name</label>
						<div class="control">
							<input v-model="lastName" class="input" type="text" placeholder="" required>
						</div>
					</div>
				</div>
			</div>

			<div class="field">
				<label class="label">Email</label>
				<div class="control">
					<input v-model="email" class="input" type="email" placeholder="" required>
				</div>
			</div>

			<div class="columns">
				<div class="column is-one-quarter">
					<div class="field">
						<label class="label">State</label>
						<div class="control">
							<div class="select">
								<select v-model="state" required>
									<option disabled selected>Select US State</option>
									<option v-for="state in states" :key="state.name">{{ state.name }}</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="column">
					<div class="field">
						<label class="label">School</label>
						<div class="control">
							<input v-model="school" class="input" type="text" placeholder="" required>
						</div>
					</div>
				</div>
			</div>

			

			

			<div class="field">
				<label class="label">Password</label>
				<div class="control">
					<input v-model="password" class="input" type="password" placeholder="" required>
				</div>
			</div>

			<div class="field">
				<label class="label">Confirm Password</label>
				<div class="control">
					<input v-model="confirmPassword" v-bind:class="{ 'is-danger': ! passwordMatch }" class="input" type="password" placeholder="" required>
				</div>
				<p v-show="! passwordMatch" class="help is-danger">Passwords must match</p>
			</div>

			<p v-show="emptyField" class="help is-danger">All fields are required</p>

			<div class="field is-grouped is-grouped-right">
				<div class="control">
					<button class="button is-primary" v-on:click="validateForm">Submit</button>
				</div>
			</div>

		</div>
	</section>
</template>

<script>
	import {BASE_URL} from '../../global.js';

	export default {

		name: 'Register',

		data () {
			return {
				states: [],
				firstName: '',
				lastName: '',
				email: '',
				state: '',
				school: '',
				password: '',
				confirmPassword: '',
				passwordMatch: true,
				emptyField: false,
				serverResponse: ''
			}
		},
		computed: {
			stateCode: function() {
				return this.states.filter(e => e.name == this.state)[0].code;
			},
			postData: function() {
				let params = {};
				params['firstName'] = this.firstName;
				params['lastName'] = this.lastName;
				params['email'] = this.email;
				params['state'] = this.stateCode;
				params['school'] = this.school;
				params['password'] = this.password;
				return params;
			}
		},
		created: function() {
			this.axios.get(`${BASE_URL}/api/states/`)
			.then(response => (this.states = response.data))
			.catch(error => console.log(error));

			// this.axios.post(`${BASE_URL}/api/comments/`, this.postData)
			// .then(response => (console.log(response.data)))
			// .catch(error => console.log(error));
		},
		watch: {
			confirmPassword: function() {
				if (this.confirmPassword.localeCompare(this.password) !== 0) {
					this.passwordMatch = false;
				} else {
					this.passwordMatch = true;
				}
			},
			serverResponse: function() {
				console.log(this.serverResponse);
				if (this.serverResponse.trim() === 'User created.') {
					this.$router.push('login');
				}
			}
		},
		methods: {
			validateForm: function() {
				if (this.firstName && this.lastName && this.email && this.state && this.school && this.passwordMatch && this.confirmPassword && this.passwordMatch) {
					this.emptyField = false;
					this.postForm();
				} else {
					this.emptyField = true;
				}
			},
			postForm: function() {
				this.axios.post(`${BASE_URL}/api/auth/register`, this.postData)
				.then(response => (this.serverResponse = response.data))
				.catch(error => console.log(error));
			}
		}
	}
</script>

<style lang="css" scoped>
@media screen and (min-width: 1024px) {
	section.register > .container {
		max-width: 700px;
	}
}
</style>