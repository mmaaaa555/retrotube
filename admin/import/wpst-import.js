jQuery(document).ready(function() {
	/** Add style to import JSON exported file */
		jQuery('label.no-image').addClass('iradio_flat-pink')
			.children('input').css({'display': 'none'})
			.next('span').css({
				'display': 'block',
				'width': '300px',
				'position': 'absolute',
				'left': '25px',
			});

    /** Import dummy videos */
    jQuery('.wpst_import_dummy_content').click(function(){
        var import_true = confirm('Are you sure to import dummy content? It will overwrite the existing data');
        if(import_true == false) return;

        jQuery('#import_dummy_content_message').html('<div class="alert alert-info temp-message"><i class="fa fa-spinner fa-3x fa-pulse"></i> ' + objectL10n.dataimport + '</div>');
        jQuery.ajax({
            type: "post",
            url: wpst_import_ajax_var.url,
            dataType   : "text",
            data: {
                'action': 'wpst_import_dummy_content',
                'nonce': wpst_import_ajax_var.nonce
            },
            success    : function(data, textStatus, jqXHR){
                jQuery('#import_dummy_content_message').html('<div class="import_message_success alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"></i></a>' + data + '</div>');
            }
        });
    });

    /** Create video submit page */
    jQuery('.wpst_create_video_submit_page').click(function(){
        jQuery('#create_video_submit_page_modal').modal('show');
    });

    jQuery('#create_video_submit_page_modal .btn-primary').click(function(){
        jQuery('#create_video_submit_page_message').html('<div class="alert alert-info temp-message"><i class="fa fa-spinner fa-3x fa-pulse"></i> ' + objectL10n.dataimport + '</div>');
        jQuery.ajax({
            type: "post",
            url: wpst_import_ajax_var.url,
            dataType   : "text",
            data: {
                'action': 'wpst_create_video_submit_page',
                'nonce': wpst_import_ajax_var.nonce
            },
            beforeSend : function(){
                jQuery('#create_video_submit_page_modal').modal('hide');
            },
            success    : function(data, textStatus, jqXHR){
                jQuery('#create_video_submit_page_message').html('<div class="import_message_success alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"></i></a><p><strong>' + objectL10n.videosubmit + '</strong> ' + objectL10n.havefun + '</p></div>');
            }
        });
    });

    /** Create profile page */
    jQuery('.wpst_create_my_profile_page').click(function(){
        jQuery('#create_my_profile_page_modal').modal('show');
    });

    jQuery('#create_my_profile_page_modal .btn-primary').click(function(){
        jQuery('#create_my_profile_page_message').html('<div class="alert alert-info temp-message"><i class="fa fa-spinner fa-3x fa-pulse"></i> ' + objectL10n.dataimport + '</div>');
        jQuery.ajax({
            type: "post",
            url: wpst_import_ajax_var.url,
            dataType   : "text",
            data: {
                'action': 'wpst_create_my_profile_page',
                'nonce': wpst_import_ajax_var.nonce
            },
            beforeSend : function(){
                jQuery('#create_my_profile_page_modal').modal('hide');
            },
            success    : function(data, textStatus, jqXHR){
                jQuery('#create_my_profile_page_message').html('<div class="import_message_success alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"></i></a><p><strong>' + objectL10n.profilepage + '</strong> ' + objectL10n.havefun + '</p></div>');
            }
        });
    });

    /** Create blog page */
    jQuery('.wpst_create_blog_page').click(function(){
        jQuery('#create_blog_page_modal').modal('show');
    });

    jQuery('#create_blog_page_modal .btn-primary').click(function(){
        jQuery('#create_blog_page_message').html('<div class="alert alert-info temp-message"><i class="fa fa-spinner fa-3x fa-pulse"></i> ' + objectL10n.dataimport + '</div>');
        jQuery.ajax({
            type: "post",
            url: wpst_import_ajax_var.url,
            dataType   : "text",
            data: {
                'action': 'wpst_create_blog_page',
                'nonce': wpst_import_ajax_var.nonce
            },
            beforeSend : function(){
                jQuery('#create_blog_page_modal').modal('hide');
            },
            success    : function(data, textStatus, jqXHR){
                jQuery('#create_blog_page_message').html('<div class="import_message_success alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"></i></a><p><strong>' + objectL10n.blogpage + '</strong> ' + objectL10n.havefun + '</p></div>');
            }
        });
    });

    /** Create categories page */
    jQuery('.wpst_create_categories_page').click(function(){
        jQuery('#create_categories_page_modal').modal('show');
    });

    jQuery('#create_categories_page_modal .btn-primary').click(function(){
        jQuery('#create_categories_page_message').html('<div class="alert alert-info temp-message"><i class="fa fa-spinner fa-3x fa-pulse"></i> ' + objectL10n.dataimport + '</div>');
        jQuery.ajax({
            type: "post",
            url: wpst_import_ajax_var.url,
            dataType   : "text",
            data: {
                'action': 'wpst_create_categories_page',
                'nonce': wpst_import_ajax_var.nonce
            },
            beforeSend : function(){
                jQuery('#create_categories_page_modal').modal('hide');
            },
            success    : function(data, textStatus, jqXHR){
                jQuery('#create_categories_page_message').html('<div class="import_message_success alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"></i></a><p><strong>' + objectL10n.catpage + '</strong> ' + objectL10n.havefun + '</p></div>');
            }
        });
    });

    /** Create tags page */
    jQuery('.wpst_create_tags_page').click(function(){
        jQuery('#create_tags_page_modal').modal('show');
    });

    jQuery('#create_tags_page_modal .btn-primary').click(function(){
        jQuery('#create_tags_page_message').html('<div class="alert alert-info temp-message"><i class="fa fa-spinner fa-3x fa-pulse"></i> ' + objectL10n.dataimport + '</div>');
        jQuery.ajax({
            type: "post",
            url: wpst_import_ajax_var.url,
            dataType   : "text",
            data: {
                'action': 'wpst_create_tags_page',
                'nonce': wpst_import_ajax_var.nonce
            },
            beforeSend : function(){
                jQuery('#create_tags_page_modal').modal('hide');
            },
            success    : function(data, textStatus, jqXHR){
                jQuery('#create_tags_page_message').html('<div class="import_message_success alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"></i></a><p><strong>' + objectL10n.tagpage + '</strong> ' + objectL10n.havefun + '</p></div>');
            }
        });
    });

    /** Create actors page */
    jQuery('.wpst_create_actors_page').click(function(){
        jQuery('#create_actors_page_modal').modal('show');
    });

    jQuery('#create_actors_page_modal .btn-primary').click(function(){
        jQuery('#create_actors_page_message').html('<div class="alert alert-info temp-message"><i class="fa fa-spinner fa-3x fa-pulse"></i> ' + objectL10n.dataimport + '</div>');
        jQuery.ajax({
            type: "post",
            url: wpst_import_ajax_var.url,
            dataType   : "text",
            data: {
                'action': 'wpst_create_actors_page',
                'nonce': wpst_import_ajax_var.nonce
            },
            beforeSend : function(){
                jQuery('#create_actors_page_modal').modal('hide');
            },
            success    : function(data, textStatus, jqXHR){
                jQuery('#create_actors_page_message').html('<div class="import_message_success alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"></i></a><p><strong>' + objectL10n.actorspage + '</strong> ' + objectL10n.havefun + '</p></div>');
            }
        });
    });

    /** Create menu */
    jQuery('.wpst_create_menu').click(function(){
        jQuery('#create_menu_modal').modal('show');
    });

    jQuery('#create_menu_modal .btn-primary').click(function(){
        jQuery('#create_menu_message').html('<div class="alert alert-info temp-message"><i class="fa fa-spinner fa-3x fa-pulse"></i> ' + objectL10n.dataimport + '</div>');
        jQuery.ajax({
            type: "post",
            url: wpst_import_ajax_var.url,
            dataType   : "text",
            data: {
                'action': 'wpst_create_menu',
                'nonce': wpst_import_ajax_var.nonce
            },
            beforeSend : function(){
                jQuery('#create_menu_modal').modal('hide');
            },
            success    : function(data, textStatus, jqXHR){
                jQuery('#create_menu_message').html('<div class="import_message_success alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"></i></a><p><strong>' + objectL10n.menu + '</strong> ' + objectL10n.havefun + '</p></div>');
            }
        });
    });

    /** Create widgets */
    jQuery('.wpst_create_widgets').click(function(){
        jQuery('#create_widgets_modal').modal('show');
    });

    jQuery('#create_widgets_modal .btn-primary').click(function(){
        jQuery('#create_widgets_message').html('<div class="alert alert-info temp-message"><i class="fa fa-spinner fa-3x fa-pulse"></i> ' + objectL10n.dataimport + '</div>');
        jQuery.ajax({
            type: "post",
            url: wpst_import_ajax_var.url,
            dataType   : "text",
            data: {
                'action': 'wpst_create_widgets',
                'nonce': wpst_import_ajax_var.nonce
            },
            beforeSend : function(){
                jQuery('#create_widgets_modal').modal('hide');
            },
            success    : function(data, textStatus, jqXHR){
                jQuery('#create_widgets_message').html('<div class="import_message_success alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times"></i></a><p><strong>' + objectL10n.widgets + '</strong> ' + objectL10n.havefun + '</p></div>');
            }
        });
    });
});
