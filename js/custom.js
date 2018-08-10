var pageUrl = window.location;

$('ul.navbar-nav.mr-auto a').filter(function() {
  return this.href == pageUrl;

  console.log(this.href, this.href == pageUrl);

}).parent().addClass('active');

// from https://codepen.io/gearmobile/pen/bByZdG
/* $( 'ul.navbar-nav.mr-auto a' ).on( 'click', function () {
	$( 'ul.navbar-nav' ).find( 'li.active' ).removeClass( 'active' );
	$( this ).parent( 'li' ).addClass( 'active' );
}); */
