<template>
	<section class="section">
		<div class="container">

			<h2 class="title">Qualitative Analysis</h2>
			<h3 class="subtitle pb-5">Choose the Unknowns</h3>

			<progress v-if="isLoading" class="progress is-large is-info" max="100"></progress>
			<div v-if="! isLoading" class="field" v-for="material in materials" :key="material.id">
				<label class="checkbox">
					<div class="control">
						<input type="checkbox" :value="material.id" v-model="checkedMaterials">
						{{ material.name }}
					</div>
				</label>
			</div>


			<!-- <button class="button is-primary mt-5" v-on:click="emitUpMaterials">Save</button> -->

		</div>
	</section>
</template>

<script>
	import {BASE_URL} from '../../global.js';

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
			this.axios.get(`${BASE_URL}/api/unknowns/qualitative/`)
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