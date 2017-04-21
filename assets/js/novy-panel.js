;(function($) {

	$(window).load(function() {

		/**
		 * Closes templates panel.
		 *
		 * @since 1.0
		 */
		 $('.novy-panel .fl-builder-panel-actions .fl-builder-panel-close').on('click', function() {
		 	$('.novy-panel').stop(true, true).animate({ right: '-350px' }, 500, function(){ $(this).hide(); });
			//$('.novy-add-template-button').stop(true, true).fadeIn();
			$('.novy-search-bar .novy-search-input').val('').trigger('keyup');
		});

		/**
		 * Show templates panel.
		 *
		 * @since 1.0
		 */
		 $('.novy-add-template-button').on('click', function() {
		 	$('.fl-builder-panel-actions .fl-builder-panel-close').trigger('click');
		 	$('.fl-builder-panel-actions .pp-panel-close').trigger('click');
		 	$('.novy-panel').stop(true, true).show().animate({ right: '0' }, 500);
		 	$('.novy-search-bar .novy-search-input').val('').trigger('keyup').focus();
		 	setTimeout(function() {
		 		$('.novy-search-bar .novy-search-input').focus();
		 	}, 500);
		 });

		 //Si clic sur un bouton fl-builder-add-content-button, alors disparation du panneau. Hasardeux car conflits avec d'autres extensions
		 /*$('.fl-builder-add-content-button').on('click', function() {
		 	$('.novy-panel .fl-builder-panel-actions .fl-builder-panel-close').trigger('click');
		 	$('.novy-search-bar > .novy-search-input').val('').trigger('keyup').focus();
		 	setTimeout(function() {
		 		$('.novy-search-bar > .novy-search-input').focus();
		 	}, 500);
		 });*/

		 /*$('body').delegate('.fl-builder-layout-settings-button', 'click', function() {
		 	$('.novy-panel .fl-builder-panel-actions .fl-builder-panel-close').trigger('click');
		 });*/
		 //Si clic sur une rangée sauvegardée à l'intérieur du panneau latéral, alors disparation du panneau
		 $('body').delegate('.fl-builder-block', 'mousedown', function() {
		 	$('.novy-panel .fl-builder-panel-actions .fl-builder-panel-close').trigger('click');
		 });

		 /**
	     * Enlever la barre de recherche de powerpack
	     */
		/*if ( $('body').hasClass('bb-powerpack-search-enabled') ) {
	    	$('.novy-panel .fl-builder-panel-actions').remove('.pp-search-bar');
		}*/

	     $('.novy-panel .novy-search-input').on('keyup', function() {
	     	if( $(this).val().length >= 3 ) {
	     		var search_text = $(this).val().toLowerCase();
	     		$('.fl-builder-blocks-section').find('.fl-builder-block-title').each(function () {
	     			if( $(this).text().trim().toLowerCase().search( search_text ) !== -1 ) {
	     				$(this).parent().addClass('novy-show-block');
	     				$(this).parents('.fl-builder-blocks-section').addClass('fl-active');
	     				$(this).parents('.fl-builder-blocks-section-content').find('.fl-builder-block:not(.novy-show-block)').addClass('novy-hide-block');
	     				$(this).parent().removeClass('novy-hide-block');
	     			} else {
	     				if( $(this).parent().hasClass('novy-show-block') ) {
	     					$(this).parent().removeClass('novy-show-block').addClass('novy-hide-block');
	     				}
	     			}
	     		});
	     	} else {
	     		if( $('.fl-builder-blocks-section.fl-active').length > 1 ) {
	     			$('.fl-builder-blocks-section').removeClass('fl-active');
	     		}
	     		$('.fl-builder-blocks-section-content').removeClass('novy-hide-block');
	            //$('.fl-builder-blocks-section-content').removeClass('novy-show-block');
	            $('.fl-builder-block').removeClass('novy-hide-block');
	            $('.fl-builder-block').removeClass('novy-show-block');
	        }
	    });

	 });

})(jQuery);
