<template>
	<div>
		<section class="section">
			<div class="container">
				<h1 class="title is-3">Create a Test</h1>
				<section class="section">
					<div class="container">
						<div class="box">
							<h2 class="title is-3" v-text="title"></h2>
							<span class="subtitle is-4" v-text="subtitle"></span>

							<choose-unknowns v-if="step === 1" v-on:emitUpMaterials="updateUnknowns" :chosen="chosenUnknowns"></choose-unknowns>

							<write-case-file v-if="step === 2" v-on:emitPrev="changeStep" v-on:emitUpCase="updateCase" :name="caseName" :story="caseStory"></write-case-file>

							<define-suspects v-if="step === 3" v-on:emitPrev="changeStep" v-on:emitUpSuspect="updateSuspect" :suspectList="suspects"></define-suspects>
						</div>
					</div>
				</section>
			</div>
		</section>
	</div>
</template>

<script>
	import ChooseUnknowns from './ChooseUnknowns';
	import WriteCaseFile from './WriteCaseFile';
	import DefineSuspects from './DefineSuspects';

	export default {

		name: 'CreateTest',

		components: {
			ChooseUnknowns,
			WriteCaseFile,
			DefineSuspects
		},

		data () {
			return {
				step: 0,
				title: '',
				subtitle: '',
				chosenUnknowns: [],
				caseName: '',
				caseStory: '',
				suspects: []
			}
		},
		created: function() {
			// this.checkAuth(
			// 	function(){
			// 		this.changeStep(1);		
			// });
			this.changeStep(1);
		},
		methods: {
			// checkAuth: function(callback){
			// 	//axios
			// 	if(sucess){
			// 		callback();
			// 	}
			// }
			updateUnknowns: function(value) {
				this.chosenUnknowns = value;
				this.changeStep(2);
			},
			updateCase: function(value) {
				this.caseName = value['name'];
				this.caseStory = value['story'];
				this.changeStep(3);
			},
			updateSuspect: function(value) {
				this.suspects = value;
			},
			changeStep: function(value) {
				this.step = value;

				if (value === 1) {
					this.title = 'Step 1';
					this.subtitle = 'Choose the Unknowns';
				} else if (value === 2) {
					this.title = 'Step 2';
					this.subtitle = 'Write the Case File';
				} else if (value === 3) {
					this.title = 'Step 3';
					this.subtitle = 'Define the Suspects';
				}
			}
		}
	}
</script>

<style lang="css" scoped>
</style>