<template>
	<div v-if="authResponse.valid">
		<div class="modal" :class="{ 'is-active': modalOpen }">
			<div class="modal-background" v-on:click="modalOpen = false"></div>
			<div class="modal-content">
				<div class="card">
					<div class="card-content">
						<div class="shoes">
							<div class="columns">
								<div class="column" v-for="shoe in shoes">
									<figure  class="image is-3by4" v-on:click="pickShoe(shoe.id)">
										<img :src="shoe.image_path">
									</figure>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<button class="modal-close is-large" aria-label="close"  v-on:click="modalOpen = false"></button>
		</div>

		<section class="hero is-primary">
			<div class="hero-body">
				<div class="container">
					<h1 class="title is-2">
						Create a Test
					</h1>
				</div>
			</div>
		</section>
		<section class="section">
			<div class="container">
				<form>
					<h2 class="title">The Crime Scene</h2>

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
				</form>
			</div>
		</section>

		<section class="section">
			<div class="container">
				<h2 class="title">The Suspects</h2>

				<div class="field" v-show="addingSuspect">
					<div class="control">
						<label class="label">Suspect Name</label>
						<input class="input" type="text" v-model="susepectName">
					</div>
				</div>
				<div class="field" v-show="addingSuspect">
					<div class="control">
						<label class="label">Description</label>
						<textarea class="textarea" placeholder="" v-model="suspectDescription"></textarea>
					</div>
				</div>

				<div class="columns">
					<div class="column">
						<div class="field" v-show="addingSuspect">
							<div class="control">
								<button class="button is-outlined is-primary" v-on:click="modalOpen = true">Choose Shoe</button>
							</div>
						</div>
					</div>
				</div>

				<div class="field" v-show="! addingSuspect">
					<div class="control">
						<button class="button is-primary" v-on:click="addingSuspect = true">Add Suspect</button>
					</div>
				</div>

				<div class="field" v-show="addingSuspect">
					<div class="control">
						<button class="button is-primary" v-on:click="addSuspect" :disabled="suspectInfoPopulated">Add</button>
					</div>
				</div>
			</div>
		</section>
	</div>
</template>

<script>
	import {BASE_URL} from '../../global.js';

	export default {

		name: 'CreateTest',

		data () {
			return {
				authResponse: '',
				modalOpen: false,
				caseName: '',
				caseStory: '',
				susepectName: '',
				suspectDescription: '',
				suspectShoe: 0,
				addingSuspect: false,
				suspectList: [],
				shoes: []
			}
		},
		created: function() {
			this.auth();
		},
		computed: {
			suspectInfoPopulated: function() {
				return (this.susepectName === '' || this.suspectDescription === '');
			}
		},
		methods: {
			auth: function() {
				this.axios.get(`${BASE_URL}/api/auth/`)
				.then(response => {

					if (response.status == 200) {
						this.authResponse = response.data;
						this.getData();

						if (this.authResponse.valid === false) {
							this.$router.push('login');
						}
					}
				})
				.catch(error => console.log(error));
			},
			addSuspect: function() {
				this.suspectList.push({ name: this.susepectName, description: this.suspectDescription });
				this.addingSuspect = false;
			},
			getData: function() {
				this.getShoes();
			},
			getShoes: function() {
				this.axios.get(`${BASE_URL}/api/shoes/`)
				.then(response => {

					if (response.status == 200) {
						this.shoes = response.data;
					} else if (response.status = 403) {
						console.log(response.data);
					}
				})
				.catch(error => console.log(error));
			},
			pickShoe: function(shoe_id) {
				this.suspectShoe = shoe_id;
				this.modalOpen = false;
			}
		}
	}
</script>

<style lang="css" scoped>
.shoes figure {
	cursor: pointer;
	filter: grayscale(100%);
}
.shoes figure:hover {
	cursor: pointer;
	filter: grayscale(0);
}
</style>