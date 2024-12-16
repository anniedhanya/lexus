/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referencing this file must be placed before the ending body tag. */

/* Use conditional comments in order to target IE 7 and older:
	<!--[if lt IE 8]><!-->
	<script src="ie7/ie7.js"></script>
	<!--<![endif]-->
*/

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'font-icon-menu\'">' + entity + '</span>' + html;
	}
	var icons = {
		'icon-rfid': '&#xe90a;',
		'icon-wallet': '&#xe90b;',
		'icon-icons-1-01-01': '&#xe901;',
		'icon-icons-1-01-02': '&#xe902;',
		'icon-icons-1-01-03': '&#xe903;',
		'icon-icons-1-01-04': '&#xe904;',
		'icon-icons-1-01-05': '&#xe905;',
		'icon-icons-1-01-06': '&#xe906;',
		'icon-icons-1-01-07': '&#xe907;',
		'icon-icons-1-01-08': '&#xe908;',
		'icon-icons-1-01-09': '&#xe909;',
		'icon-icons-1-01-10': '&#xe900;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
