<template>
	<section class="section">
		<div class="container">
			<h1 class="title">Welcome Home</h1>
			<event-supervisor-view v-if="valid && appPermissions >= 1"></event-supervisor-view>
		</div>
	</section>
	
</template>

<script>
	import {BASE_URL} from '../global.js';
	import EventSupervisorView from './EventSupervisorView';

	export default {

		name: 'Home',

		components: {
			EventSupervisorView
		},
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
			},
			appPermissions: function() {
				return this.authResponse.app_permissions;
			}
		},
		created: function() {
			this.auth();
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