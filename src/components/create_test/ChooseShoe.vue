<template>
	<div class="shoes">
		<div class="columns">
			<div class="column" v-for="shoe in shoes">
				<figure  class="image is-3by4" v-on:click="pickShoe(shoe.id)">
					<img :src="shoe.image_path">
				</figure>
			</div>
		</div>
		
	</div>
</template>

<script>
	export default {

		name: 'ChooseShoe',

		data () {
			return {

			}
		}
	}
</script>

<style lang="css" scoped>
</style>