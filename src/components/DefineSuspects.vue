<template>
	<section class="section">
		<div class="container">
			<div class="field">
				<label class="label">Suspect Name</label>
				<div class="control">
					<input class="input" type="text" placeholder="" v-model="suspectName">
				</div>
			</div>
			<div class="field">
				<div class="control">
					<label class="label">Description</label>
					<textarea class="textarea" placeholder="" v-model="suspectDescription"></textarea>
				</div>
			</div>

			<div class="field is-expanded">
				<label v-if="suspects.length > 0" class="label">List of Suspects</label>
				<table class="table is-bordered is-striped is-hoverable">
					<tr v-for="suspect in suspects" :key="suspect.name">
						<td>{{ suspect.name }}</td>
						<td>{{ suspect.description }}</td>
					</tr>
				</table>
			</div>

			<div class="field is-grouped is-grouped-right">
				<div class="control">
					<button class="button is-info" v-on:click="addSuspect">Add New</button>
				</div>
			</div>
			
			<div class="field is-grouped next-buttons">
				<div class="control">
					<button class="button is-primary is-small" v-on:click="emitPrev">Prev</button>
				</div>
				<div class="control">
					<button class="button is-primary is-small">Next</button>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
	export default {

		name: 'DefineSuspects',

		data () {
			return {
				suspectName: '',
				suspectDescription: '',
				suspects: this.suspectList
			}
		},
		props: {
			suspectList: Array
		},
		methods: {
			addSuspect: function() {
				this.suspects.push({
					'name': this.suspectName,
					'description': this.suspectDescription
				});
			},
			emitPrev: function() {
				this.$emit('emitPrev', 2);
			},
			emitUpSuspect: function() {
				this.$emit('emitUpSuspect', this.suspects);
			}
		}
	}
</script>

<style lang="css" scoped>
</style>