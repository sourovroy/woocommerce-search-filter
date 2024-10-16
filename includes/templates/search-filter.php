<div class="ws-filter-form" x-data>
	<input type="text">
	<button x-on:click="alert('Hello World!')">Search</button>
</div>

<div class="ws-filter-items" x-data>
	<template x-for="item in $store.wsFilter.data">
		<div class="ws-filter-item">
			<h3 x-html="item.name"></h3>
		</div>
	</template>
</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.store('wsFilter', {
			init() {
				this.getItems();
			},
            data: [],
            getItems() {
                let url = WS_Filter.ajax_url + "?action=ws_filter_get_search_items";

				fetch( url ).then((response) => response.json()).then((response) => {
					this.data = response.data;
				});
            }
        });
	});
</script>
