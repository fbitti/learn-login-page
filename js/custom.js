var pageUrl = window.location.href;

$('ul.nav-item a').filter(function() {
  return this.href == pageUrl;
}).parent().addClass('active');

/* // from https://codepen.io/gearmobile/pen/bByZdG
$( '.navbar-nav a' ).on( 'click', function () {
	$( '.navbar-nav' ).find( 'li.active' ).removeClass( 'active' );
	$( this ).parent( 'li' ).addClass( 'active' );
}); */
