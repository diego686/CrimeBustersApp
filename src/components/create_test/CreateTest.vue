<template>
	<div v-if="authResponse.valid">
		<div class="modal" :class="{ 'is-active': modalOpen }">
			<div class="modal-background" v-on:click="closeModal"></div>
			<div class="modal-content">
				<div class="card">
					<div class="card-content">

						<div class="shoes" v-if="choosingShoe">
							<div class="columns is-multiline">
								<div class="column is-one-third" v-for="shoe in shoes">
									<figure  class="image is-3by4" v-on:click="pickShoe(shoe.id)">
										<img :src="shoe.image_path">
									</figure>
								</div>
							</div>
						</div>

						<div class="dna" v-if="choosingDNA">
							<div class="columns is-multiline">
								<div class="column is-one-quarter" v-for="dna in dnas">
									<figure  class="image is-4by3" v-on:click="pickDNA(dna.id)">
										<img :src="dna.image_path">
									</figure>
								</div>
							</div>
						</div>

						<div class="dna" v-if="choosingFingerprint">
							<div class="columns is-multiline">
								<div class="column is-one-quarter" v-for="fingerprint in fingerprints">
									<figure  class="image is-4by5" v-on:click="pickFingerprint(fingerprint.id)">
										<img :src="fingerprint.image_path">
									</figure>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<button class="modal-close is-large" aria-label="close"  v-on:click="closeModal"></button>
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
								<button v-if="suspectShoe === 0" class="button is-outlined is-primary" v-on:click="openShoe">Choose Shoe</button>
								<figure v-if="suspectShoe !== 0" class="image is-3by4" v-on:click="openShoe">
									<img :src="shoeImagePath(suspectShoe)">
								</figure>
							</div>
						</div>
					</div>

					<div class="column">
						<div class="field" v-show="addingSuspect">
							<div class="control">
								<button v-if="suspectDNA === 0" class="button is-outlined is-primary" v-on:click="openDNA">Choose DNA</button>
								<figure v-if="suspectDNA !== 0" class="image is-4by3" v-on:click="openDNA">
									<img :src="dnaImagePath(suspectDNA)">
								</figure>
							</div>
						</div>
					</div>

					<div class="column">
						<div class="field" v-show="addingSuspect">
							<div class="control">
								<button v-if="suspectFingerprint === 0" class="button is-outlined is-primary" v-on:click="openFingerprint">Choose Fingerprint</button>
								<figure v-if="suspectFingerprint !== 0" class="image is-4by5" v-on:click="openFingerprint">
									<img :src="fingperintImagePath(suspectFingerprint)">
								</figure>
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
				suspectDNA: 0,
				suspectFingerprint: 0,
				addingSuspect: false,
				suspectList: [],
				shoes: [],
				choosingShoe: false,
				dnas: [],
				choosingDNA: false,
				fingerprints: [],
				choosingFingerprint: false
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
				this.getDNA();
				this.getFingerprints();
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
			getDNA: function() {
				this.axios.get(`${BASE_URL}/api/dna/`)
				.then(response => {

					if (response.status == 200) {
						this.dnas = response.data;
					} else if (response.status = 403) {
						console.log(response.data);
					}
				})
				.catch(error => console.log(error));
			},
			getFingerprints: function() {
				this.axios.get(`${BASE_URL}/api/fingerprints/`)
				.then(response => {

					if (response.status == 200) {
						this.fingerprints = response.data;
					} else if (response.status = 403) {
						console.log(response.data);
					}
				})
				.catch(error => console.log(error));
			},
			pickShoe: function(shoe_id) {
				this.suspectShoe = shoe_id;
				this.closeModal();
			},
			pickDNA: function(dna_id) {
				this.suspectDNA = dna_id;
				this.closeModal();
			},
			pickFingerprint: function(fingerprint_id) {
				this.suspectFingerprint = fingerprint_id;
				this.closeModal();
			},
			closeModal: function() {
				this.modalOpen = false;
				this.choosingShoe = false;
				this.choosingDNA = false;
				this.choosingFingerprint = false;
			},
			openShoe: function() {
				this.modalOpen = true;
				this.choosingShoe = true;
			},
			openDNA: function() {
				this.modalOpen = true;
				this.choosingDNA = true;
			},
			openFingerprint: function() {
				this.modalOpen = true;
				this.choosingFingerprint = true;
			},
			shoeImagePath: function(shoe_id) {
				let result = this.shoes.filter(function(el) {
					return el.id === shoe_id;
				});

				if (result.length > 0) {
					return result[0].image_path;
				}

				return result;
			},
			dnaImagePath: function(dna_id) {
				let result = this.dnas.filter(function(el) {
					return el.id === dna_id;
				});

				if (result.length > 0) {
					return result[0].image_path;
				}

				return result;
			},
			fingperintImagePath: function(fingerprint_id) {
				let result = this.fingerprints.filter(function(el) {
					return el.id === fingerprint_id;
				});

				if (result.length > 0) {
					return result[0].image_path;
				}

				return result;
			}
		}
	}
</script>

<style lang="css" scoped>
figure:hover {
	cursor: pointer;
}
.modal figure {
	filter: grayscale(100%);
}
.modal figure:hover {	
	filter: grayscale(0);
}
</style>