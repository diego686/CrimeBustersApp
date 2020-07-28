<template>
	<div v-if="authResponse.valid">
		<div class="modal" :class="{ 'is-active': modalOpen }">
			<div class="modal-background" v-on:click="closeModal"></div>
			<div class="modal-content">
				<div class="card">
					<div class="card-content">

						<div class="shoes" v-if="choosingShoe">
							<div class="columns is-multiline">
								<div class="column is-one-third" v-for="shoe in availableShoes">
									<figure  class="image is-3by4" v-on:click="pickShoe(shoe.id)">
										<img :src="shoe.image_path">
									</figure>
								</div>
							</div>
						</div>

						<div class="dna" v-if="choosingDNA">
							<div class="columns is-multiline">
								<div class="column is-one-quarter" v-for="dna in availableDNA">
									<figure  class="image is-4by3" v-on:click="pickDNA(dna.id)">
										<img :src="dna.image_path">
									</figure>
								</div>
							</div>
						</div>

						<div class="dna" v-if="choosingFingerprint">
							<div class="columns is-multiline">
								<div class="column is-one-quarter" v-for="fingerprint in availableFingerprints">
									<figure  class="image is-4by5" v-on:click="pickFingerprint(fingerprint.id)">
										<img :src="fingerprint.image_path">
									</figure>
								</div>
							</div>
						</div>

						<div class="evidence" v-if="choosingEvidence">
							<div class="columns is-multiline">
								<div class="column is-one-quarter">
									
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

				<div v-show="suspectList.length > 0" class="table-container">
					<table class="table is-striped">
						<tr>
							<th>Name</th>
							<th>Description</th>
							<th>Shoe</th>
							<th>DNA</th>
							<th>Fingerprint</th>
						</tr>
						<tr v-for="suspect in suspectList">
							<td v-text="suspect.name"></td>
							<td v-text="suspect.description"></td>
							<td>
								<figure class="image is-3by4">
									<img :src="shoeImagePath(suspect.shoe)">
								</figure>
							</td>
							<td>
								<figure class="image is-4by3">
									<img :src="dnaImagePath(suspect.dna)">
								</figure>
							</td>
							<td>
								<figure class="image is-4by4">
									<img :src="fingerprintImagePath(suspect.fingerprint)">
								</figure>
							</td>
						</tr>
					</table>
				</div>
				


				<div class="field" v-show="addingSuspect">
					<div class="control">
						<label class="label">Suspect Name</label>
						<input class="input" type="text" v-model="suspectName">
					</div>
				</div>
				<div class="field" v-show="addingSuspect">
					<div class="control">
						<label class="label">Description</label>
						<textarea class="textarea" placeholder="" v-model="suspectDescription"></textarea>
					</div>
				</div>

				<div class="columns mt-3">

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
									<img :src="fingerprintImagePath(suspectFingerprint)">
								</figure>
							</div>
						</div>
					</div>

				</div>

				<!-- <div class="field" v-show="! addingSuspect">
					<div class="control">
						<button class="button is-primary" v-on:click="addingSuspect = true">Add Suspect</button>
					</div>
				</div> -->


				<div class="field" v-show="addingSuspect">
					<div class="control">
						<button class="button is-primary" v-on:click="addSuspect" title="All fields are required" :disabled="suspectEmptyFields">Add Suspect</button>
					</div>
				</div>

			</div>
		</section>

		<section class="section">
			<div class="container">
				<h2 class="title">The Unknowns</h2>
				<h3 class="subtitle">Qualitative Analysis</h3>

				<div class="columns is-multiline">
					<div class="column is-one-quarter" v-for="unknown in unknowns">
						<div class="field">
							<div class="control">
								<label class="checkbox">
									<input type="checkbox" :value="unknown.id" v-model="checkedUnknowns">
									{{ unknown.name }}
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="section">
			<div class="container">
				<h2 class="title">The Evidence</h2>

				<div class="field">
					<div class="control">
						<button class="button is-primary" v-on:click="openEvidence">Add Evidence</button>
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
				suspectName: '',
				suspectDescription: '',
				suspectShoe: 0,
				suspectDNA: 0,
				suspectFingerprint: 0,
				addingSuspect: true,
				suspectList: [],
				shoes: [],
				choosingShoe: false,
				dnas: [],
				choosingDNA: false,
				fingerprints: [],
				choosingFingerprint: false,
				unknowns: [],
				checkedUnknowns: [],
				evidence: [],
				choosingEvidence: false
			}
		},
		created: function() {
			this.auth();
		},
		computed: {
			suspectEmptyFields: function() {
				return (this.suspectName === '' || this.suspectDescription === '' || this.suspectShoe === 0 || this.suspectDNA === 0 || this.suspectFingerprint === 0);
			},
			availableShoes: function() {
				let chosenShoes = [];

				chosenShoes = this.suspectList.map(filterShoes);

				function filterShoes(value, index, array) {
					return value.shoe;
				}

				let result = this.shoes.filter(function(el) {
					return !chosenShoes.includes(el.id);
				});

				return result;
			},
			availableDNA: function() {
				let chosenDNA = [];

				chosenDNA = this.suspectList.map(filterDNA);

				function filterDNA(value, index, array) {
					return value.dna;
				}

				let result = this.dnas.filter(function(el) {
					return !chosenDNA.includes(el.id);
				});

				return result;
			},
			availableFingerprints: function() {
				let chosenFingerprints = [];

				chosenFingerprints = this.suspectList.map(filterFingerprints);

				function filterFingerprints(value, index, array) {
					return value.fingerprint;
				}

				let result = this.fingerprints.filter(function(el) {
					return !chosenFingerprints.includes(el.id);
				});

				return result;
			},
			chosenShoes: function() {
				let chosenShoes = this.suspectList.map(filterShoes);

				function filterShoes(value, index, array) {
					return value.shoe;
				}

				return chosenShoes;
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
				this.suspectList.push({ name: this.suspectName, description: this.suspectDescription, shoe: this.suspectShoe, dna: this.suspectDNA, fingerprint: this.suspectFingerprint });
				// this.addingSuspect = false;
				this.suspectName = '';
				this.suspectDescription = '';
				this.suspectShoe = 0;
				this.suspectDNA = 0;
				this.suspectFingerprint = 0;
			},
			getData: function() {
				this.getShoes();
				this.getDNA();
				this.getFingerprints();
				this.getUnknowns();
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
			getUnknowns: function() {
				this.axios.get(`${BASE_URL}/api/unknowns/qualitative/`)
				.then(response => {

					if (response.status == 200) {
						this.unknowns = response.data;
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
			openEvidence: function() {
				this.modalOpen = true;
				this.choosingEvidence = true;
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
			fingerprintImagePath: function(fingerprint_id) {
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
table figure:hover {
	cursor: default;
}
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