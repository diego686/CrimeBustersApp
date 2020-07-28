<template>
	<div>
		<section class="section">
			<div class="container">
				<h1 class="title is-3">Create a Test</h1>
				<section class="section">
					<div class="container">
						<div class="box">
<!-- 							<h2 class="title is-3" v-text="title"></h2>
							<span class="subtitle is-4" v-text="subtitle"></span> -->
							<write-case-file v-on:emitUpCase="updateCase" :name="caseName" :story="caseStory"></write-case-file>

							<define-suspects v-on:emitUpSuspect="updateSuspect" :suspectList="suspects"></define-suspects>

							<choose-unknowns v-on:emitUpMaterials="updateUnknowns" :chosen="chosenUnknowns"></choose-unknowns>

							
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
				chosenUnknowns: [],
				caseName: '',
				caseStory: '',
				suspects: []
			}
		},
		created: function() {

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
			},
			updateCase: function(value) {
				this.caseName = value['name'];
				this.caseStory = value['story'];
			},
			updateSuspect: function(value) {
				this.suspects = value;
			}
		}
	}
</script>

<style lang="css" scoped>
</style>