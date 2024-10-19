<section class="ws-filter">
	<aside class="ws-categories">
		<ul x-data>
			<template x-for="catItem in $store.wsFilter.categories">
				<li><a href="#" x-text="catItem.name" @click="(e) => $store.wsFilter.onCategorySearch(e, catItem.id)"></a></li>
			</template>
		</ul>
	</aside>
	<div class="ws-form-and-items">
		<template x-data x-if="$store.wsFilter.loading" x-transition>
			<div class="ws-loader">
				<div class="ws-spin-loader"></div>
			</div>
		</template>

		<div class="ws-filter-form" x-data>
			<input type="text" @keyup="(e) => $store.wsFilter.onSearchInput(e)" x-model="$store.wsFilter.searchInput">
			<button x-on:click="alert('Hello World!')">Search</button>
		</div>

		<div class="ws-filter-items" x-data>
			<template x-for="item in $store.wsFilter.data">
				<div class="ws-filter-item">
					<a x-html="item.image" x-bind:href="item.permalink"></a>
					<h3>
						<a x-bind:href="item.permalink" x-html="item.name"></a>
					</h3>
				</div>
			</template>
		</div>
	</div>
</section>



<script>
	document.addEventListener('alpine:init', () => {
		Alpine.store('wsFilter', {
            data: [],
            categories: [],
			searchInput: "",
			searchTimer: null,
			searchCatItemId: "",
			loading: false,
			init() {
				this.getCategories();
				this.getItems();
			},
            getItems() {
				this.loading = true;
                let url = WS_Filter.ajax_url + "?action=ws_filter_get_search_items";
				url += '&search=' + this.searchInput;
				url += '&cat_id=' + this.searchCatItemId;

				fetch( url ).then((response) => response.json()).then((response) => {
					this.data = response.data;
					this.loading = false;
				});
            },
			getCategories() {
				let url = WS_Filter.ajax_url + "?action=ws_filter_get_categories";

				fetch( url ).then((response) => response.json()).then((response) => {
					this.categories = response;
				});
			},
			onSearchInput(event) {
				clearTimeout(this.searchTimer);

				// Check the character length is more than or equal to 3.
				let text = String( event.target.value );

				if ( text.length < 3 ) {
					return;
				}

				this.searchTimer = setTimeout(() => {
					this.getItems();
				}, 1000);
			},
			onCategorySearch(event, catItemId) {
				event.preventDefault();

				this.searchCatItemId = catItemId;
				this.getItems();
			}
        });
	});
</script>
