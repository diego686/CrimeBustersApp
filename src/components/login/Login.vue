<template>
	<section class="section login">
		<div class="container">

			<h1 class="title">Log In</h1>

			<div class="field">
				<label class="label">Email</label>
				<div class="control">
					<input v-model="email" class="input" type="email" placeholder="" required>
				</div>
			</div>

			<div class="field">
				<label class="label">Password</label>
				<div class="control">
					<input v-model="password" class="input" type="password" placeholder="" required>
				</div>
			</div>

			<p v-text="errorMessage" class="help is-danger"></p>

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
	import {EventBus} from '../../app.js';

	export default {

		name: 'Login',

		data () {
			return {
				email: '',
				password: '',
				serverResponse: '',
				errorMessage: ''
			}
		},
		computed: {
			postData: function() {
				let params = {};
				params['email'] = this.email;
				params['password'] = this.password;
				return params;
			}
		},
		methods: {
			validateForm: function() {
				if (this.email && this.password) {
					this.login();
				} else {
					this.errorMessage = 'All fields are required';
				}
			},
			login: function() {
				this.axios.post(`${BASE_URL}/api/auth/login`, this.postData)
				.then(response => (this.serverResponse = response.data))
				.catch(error => console.log(error));
			}
		},
		watch: {
			postData: function() {
				this.errorMessage = '';
			},
			serverResponse: function() {
				if (this.serverResponse.trim() === 'success') {
					EventBus.$emit('loggedIn');
					this.$router.push('/');
				} else {
					this.errorMessage = 'The email or password entered is incorrect';
				}
			}
		}
	}
</script>

<style lang="css" scoped>
@media screen and (min-width: 1024px) {
	section.login > .container {
		max-width: 700px;
	}
}
</style>