var search = instantsearch({
  // Replace with your own values
  appId: '9USJ7O4AOH',
  apiKey: 'cc9c7697f1e099b20b3f353b186ff7b3', // search only API key, no ADMIN key
  indexName: 'getstarted_actors',
  urlSync: true,
  searchParameters: {
    hitsPerPage: 10
  }
});

search.addWidget(
  instantsearch.widgets.searchBox({
    container: '#search-input'
  })
);

search.addWidget(
  instantsearch.widgets.hits({
    container: '#hits',
    templates: {
      item: document.getElementById('hit-template').innerHTML,
      empty: "We didn't find any results for the search <em>\"{{query}}\"</em>"
    }
  })
);

search.start();
