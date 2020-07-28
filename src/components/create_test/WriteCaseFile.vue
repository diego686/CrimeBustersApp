<template>
	<section class="section">
		<div class="container">
			<h2 class="title">Crime Scene</h2>

			<div class="field">
				<div class="control">
					<label class="label">Case Name</label>
					<input class="input is-large has-text-weight-bold" type="text" v-model="caseName">
				</div>
			</div>
			<div class="field">
				<div class="control">
					<label class="label">Story</label>
					<textarea class="textarea" placeholder="Describe what happened" v-model="caseStory"></textarea>
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