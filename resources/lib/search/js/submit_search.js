$(document).ready(() => {
  SMSemec.submitSearch();
});

SMSemec.submitSearch = function() {
  const el = 'input.enter-to-submit-search';
  const btn = '.submit-search';
  const base_url = $(el).data('base-url');

  const requestSearch = function () {
    var term = $(el).val();
    var url = base_url;

    if (term && term.trim().length) {
      url += '/search/' + encodeURI(term);
    }

    return window.location.assign(url);
  }

  $(btn).click(function() {
    return requestSearch();
  });

  $(el).keypress(function(e) {
    const keycode = e.keyCode || e.which;
    if (keycode === 13) {
      return requestSearch();
    }
  });
};
