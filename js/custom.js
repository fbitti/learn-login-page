var pageUrl = window.location;

/* $('ul.nav a').filter(function() {
  return this.href == url;
}).parent().addClass('active'); */

// from https://codepen.io/gearmobile/pen/bByZdG
$( '.navbar-nav a' ).on( 'click', function () {
	$( '.navbar-nav' ).find( 'li.active' ).removeClass( 'active' );
	$( this ).parent( 'li' ).addClass( 'active' );
});
