<template>
	<div>
		<input 
			v-model="query"
			type="text" 
			class="SearchInput" 
			:placeholder="placeholder">
	</div>
</template>

<script>
export default {
	name: 'Typeahead',
	props: {
		source: {
			type: [String, Array],
			required: true
		},
		filterKey: {
			type: String,
			required: true
		},
		startAt: {
			type: Number,
			default: 3
		},
		placeholder: {
			type: String,
			default: ''
		}
	},
	data() {
		return {
			items: [],
			query: ''
		}
	},
	methods: {
		fetchItems() {
			if ( typeof this.source === 'string' ) {
				fetch(this.source)
					.then(stream => stream.json())
					.then(data => this.items = data)
					.catch(error => console.error(error))
			} else {
				this.items = this.source
			}
		}
	},
	mounted() {
		this.fetchItems()
	}
}
</script>

<style>
.SearchInput {
	width: 100%;
	padding: 1.5em 1em;
	font-size: 1em;
	outline: 0;
	border: 5px solid #41B883;
}
.Results {
	margin: 0;
	padding: 0;
	text-align: left;
	position: relative;
}
.Results li {
	background: rgba(53, 73, 94, 0.3);
	margin: 0;
	padding: 1em;
	list-style: none;
	width: 100%;
	border-bottom: 1px solid #394E62;
	transition: ease-in-out 0.5s;
}
.fade-enter-active, .fade-leave-active {
	transition: opacity 0.3s;
}
.fade-enter, .fade-leave-to {
	opacity: 0;
}
</style>