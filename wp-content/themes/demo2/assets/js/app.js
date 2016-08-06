
window.addEventListener('load', function() {
    new FastClick(document.body);
}, false);

$(function() {

    $('#fm').FatMenu({
        pushOnShow        : false,
        overlay           : true,
        mobileBreakpoint  : 1199,
        BackButtonContent : '<i class="fa fa-angle-left"></i> Retour',
		// navColor         : ['#7F57A9', '#1d875f', '#36A1BA', '#E53535', '#7F57A9', '#1d875f', '#36A1BA'],
	});

    $('#section-contactus-networks-youtube, #section-contactus-networks-facebook').hover(function() {
        if ($(this).attr('id') == 'section-contactus-networks-youtube') {
            $('#section-contactus-networks-facebook').stop().animate({'opacity': '.5'}, 250);
        } else {
            $('#section-contactus-networks-youtube').stop().animate({'opacity': '.5'}, 250);
        }
    }, function() {
        if ($(this).attr('id') == 'section-contactus-networks-youtube') {
            $('#section-contactus-networks-facebook').stop().animate({'opacity': '1'}, 250);
        } else {
            $('#section-contactus-networks-youtube').stop().animate({'opacity': '1'}, 250);
        }
    });

    if ($(window).width() > 1199) {
        $('.article').find('.social-toolbar').affix({
            offset: {
                top: 256,
                bottom: function () {
                    return (this.bottom = $('.layout-footer').outerHeight(true) + 60);
                }
            }
        });
    }

	$(window).load(function() {
        var $layoutNav = $('#layout-navigation'),
            navPos = $layoutNav.offset();

		$layoutNav.affix({
			offset: {
				top: navPos.top,
			}
		});
        // $(window).resize(function(event) {
        //     navPos = $layoutNav.offset();
        //     console.log(navPos);
        //     $layoutNav.data('bs.affix').options.offset = navPos.top;
        // });
	});

    $('.sharer').click(function(e){
        e.preventDefault();
        v_this = $(this);

        var leftPosition, topPosition;
        leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
        topPosition = (window.screen.height / 2) - ((height / 2) + 50);
        var width = 520;
        var height = 350;
        var windowFeatures = 'status=no,height=' + height + ',width=' + width + ',resizable=yes,left=' + leftPosition + ',top=' + topPosition + ',screenX=' + leftPosition + ',screenY=' + topPosition + ',toolbar=no,menubar=no,scrollbars=no,location=no,directories=no';
        var t = document.title;

        if( v_this.data('share-network') == 'facebook'){
            window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(v_this.data('share-link'))+'&t='+encodeURIComponent(t),'sharer', windowFeatures);
        }
        if( v_this.data('share-network') == 'google'){
            window.open('https://plus.google.com/share?url=='+encodeURIComponent(v_this.data('share-link')),'sharer', windowFeatures);
        }
        if( v_this.data('share-network') == 'twitter'){
            window.open('http://twitter.com/home?status='+encodeURIComponent(v_this.data('share-title'))+' '+encodeURIComponent(v_this.data('share-link')),'sharer', windowFeatures);
        }
        // if( v_this.data('share-network') == 'twitter-2'){
        //     window.open('http://twitter.com/home?status='+encodeURIComponent('Participez aux Etats Généraux du Parti Socialiste #egps ')+encodeURIComponent(v_this.data('share-link')),'sharer', windowFeatures);
        //     if( v_this.data('share-ref-stats') !== '')
        //         updateTwitterCount(v_this.data('share-ref-stats'));
        // }

        return false;
    });

});