<template>
	<section class="section">
		<div class="container">
			<div class="field">
				<div class="control">
					<label class="label">Case Name</label>
					<input class="input" type="text" v-model="caseName">
				</div>
			</div>
			<div class="field">
				<div class="control">
					<label class="label">Story</label>
					<textarea class="textarea" placeholder="Describe what happened" v-model="caseStory"></textarea>
				</div>
			</div>
			<div class="field is-grouped next-buttons">
				<div class="control">
					<button class="button is-primary is-small" v-on:click="emitPrev">Prev</button>
				</div>
				<div class="control">
					<button class="button is-primary is-small" v-on:click="emitUpCase">Next</button>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
	export default {

		name: 'WriteCaseFile',

		data () {
			return {
				caseName: this.name,
				caseStory: this.story
			}
		},
		props: {
			name: String,
			story: String
		},
		methods: {
			emitPrev: function() {
				this.$emit('emitPrev', 1);
			},
			emitUpCase: function() {
				this.$emit('emitUpCase', { 'name': this.caseName, 'story' : this.caseStory });
			}
		}
	}
</script>

<style lang="css" scoped>
</style>