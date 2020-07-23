<template>
	<nav class="navbar" role="navigation" aria-label="main navigation">
		<div class="navbar-brand">
			<!-- <a class="navbar-item" href="https://bulma.io">
				<img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
			</a> -->
			<router-link to="/" class="navbar-item">
				<img src="../images/ScienceOlympiadLogo.png">
			</router-link>

			<a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
			</a>
		</div>

		<div id="navbarBasicExample" class="navbar-menu">
			<div class="navbar-start">
				<a class="navbar-item">
					Home
				</a>

				<a class="navbar-item">
					Documentation
				</a>

				<div class="navbar-item has-dropdown is-hoverable">
					<a class="navbar-link">
						More
					</a>

					<div class="navbar-dropdown">
						<a class="navbar-item">
							About
						</a>
						<a class="navbar-item">
							Jobs
						</a>
						<a class="navbar-item">
							Contact
						</a>
						<hr class="navbar-divider">
						<a class="navbar-item">
							Report an issue
						</a>
					</div>
				</div>
			</div>

			<div class="navbar-end">
				<div v-show="! valid" class="navbar-item">
					<div class="buttons">
						<router-link to="/register" class="button is-primary"><strong>Register</strong></router-link>
						<router-link to="/login" class="button is-light">
							Log in
						</router-link>
					</div>
				</div>
				<div v-show="valid" class="navbar-item">
					Hello, {{ displayName }}
				</div>
			</div>
		</div>
	</nav>
</template>

<script>
	import {BASE_URL} from '../global.js';
	import {EventBus} from '../app.js';

	export default {

		name: 'Navbar',

		data () {
			return {
				authResponse: {}
			}
		},
		computed: {
			valid: function() {
				return this.authResponse.valid;
			},
			displayName: function() {
				return this.authResponse.first_name;
			}
		},
		created: function() {
			this.auth();
			EventBus.$on('loggedIn', this.auth);
		},
		methods: {
			auth: function() {
				this.axios.get(`${BASE_URL}/api/auth/`)
				.then(response => (this.authResponse = response.data))
				.catch(error => console.log(error));
			}
		}
	}
</script>

<style lang="css" scoped>
</style>