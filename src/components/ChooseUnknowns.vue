<template>
	<section class="section">
		<div class="container">

			<h1 class="title" v-text="sessionTest"></h1>

			<progress v-if="isLoading" class="progress is-large is-info" max="100"></progress>
			<div v-if="! isLoading" class="field" v-for="material in materials" :key="material.id">
				<label class="checkbox">
					<div class="control">
						<input type="checkbox" :value="material.id" v-model="checkedMaterials">
						{{ material.name }}
					</div>
				</label>
			</div>
			<div class="field is-grouped is-grouped-right">
				<div class="control">
					<button v-bind:class="{ 'is-loading': isLoading }" class="button is-primary is-small" v-on:click="emitUpMaterials">Next</button>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
	import {BASE_URL} from '../global.js';

	export default {

		name: 'ChooseUnknowns',

		data () {
			return {
				isLoading: true,
				materials: [],
				checkedMaterials: this.chosen,
			}
		},
		props: {
			chosen: Array
		},
		created: function() {
			this.axios.get(`${BASE_URL}/api/materials/`)
			.then(response => (this.materials = response.data))
			.catch(error => console.log(error));
		},
		watch: {
			materials: function(val) {
				this.isLoading = false
			}
		},
		methods: {
			emitUpMaterials: function() {
				this.$emit('emitUpMaterials', this.checkedMaterials)
			}
		}
	}
</script>

<style lang="css" scoped>
</style>