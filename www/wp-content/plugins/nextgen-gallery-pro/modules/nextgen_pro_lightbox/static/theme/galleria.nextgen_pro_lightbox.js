(function($) {

/* global jQuery, Galleria */

Galleria.get_display_setting = function(name, def) {
    var tmp = (parent.display_settings ? parent.display_settings[name] : def);
    if (tmp == 1) tmp = true;
    if (tmp == 0) tmp = false;
    return tmp;
};

/**
 * Searches the data-id of source images to find a starting index
 *
 * @returns {number}
 */
Galleria.get_show_setting = function() {
    var retval = 0;
    parent.jQuery('.galleria-batch').first().find('.batch-image img').each(function(index, element) {
        if (top.nplModalRouted.image_id == jQuery(element).data('image-id')) {
            retval = index;
        }
    });

    return retval;
};

// NOTE: if top.nplModalRouted exists this theme will interact with it to change the parent url or determine
// which images to display. Without it this theme will function without those features.

Galleria.addTheme({
    name: 'nextgen_pro_lightbox',
    author: 'Photocrati Media',
    css: 'galleria.nextgen_pro_lightbox.css',
    defaults: {
        debug: false,
        carousel: true,
        thumbnails: true,
        show: Galleria.get_show_setting(),

        // leave this to our parent frame to handle
        trueFullscreen: false,

        // limit Galleria's upscaling of images
        maxScaleRatio: 1,

        // user configurable settings
        transition:          Galleria.get_display_setting('transition_effect', 'slide'),
        touchTransition:     Galleria.get_display_setting('touch_transition_effect', 'slide'),
        fullscreenDoubleTap: Galleria.get_display_setting('fullscreen_double_tap', 'true'),
        imagePan:            Galleria.get_display_setting('image_pan', false),
        pauseOnInteraction:  Galleria.get_display_setting('interaction_pause', true),
        imageCrop:           Galleria.get_display_setting('image_crop', true)
    },
    init: function(options) {
        Galleria.requires(1.28, 'This version of Classic theme requires Galleria 1.2.8 or later');
        Galleria.configure({debug: false});
        var self = this;
        var show_dock = true;
        var show_info = false;
        var show_comments = false;
        var comments_cache = [];

        // to prevent multiple animation issues these vars should be checked before calling for a new animation
        // and should be toggled only after the animation has completed. AIP = Animation In Progress
        var aip_dock = false;
        var aip_info = false;
        var aip_comments = false;

        // an additional library only necessary for iOS6 or lower devices
        if (top.nplModalSettings.fontawesome_url) {
            $("head").append("<link href='" + top.nplModalSettings.fontawesome_url + "' type='text/css' rel='stylesheet'/>");
        }
        if (Galleria.IPHONE || Galleria.IPAD) {
            $.getScript(top.nplModalSettings.iscroll_url);
        }

        // commonly used & repeated functions. most of these are toggle effects
        var methods = {
            comments: {
                toggle: function() {
                    if (!aip_comments) {
                        if (show_comments) {
                            this.close();
                        } else {
                            this.open();
                        }
                        aip_comments = true;
                    }
                },
                open: function() {
                    this.set_content();
                    self.$('comments-container').animate(
                        {'right': '-0%',
                         'min-width': '310px'},
                        {complete: function() {
                            show_comments = true;
                            aip_comments = false;
                            self.trigger('rescale');
                        }, queue: false }
                    );
                    self.$('comments-overlay').animate({right: '-0%'}, {queue: false});
                    top.nplModalRouted.navigate(
                        top.nplModalSettings.router_slug
                        + '/' + top.nplModalRouted.gallery_id
                        + '/' + top.nplModalRouted.image_id
                        + '/1',
                        false
                    );
                },
                close: function() {
                    // Hide the container by animating it offscreen. Use a % here to maintain responsive settings
                    var width = (100 * parseFloat(self.$('comments-container').css('width')) / parseFloat($('body').css('width'))) + '%';
                    self.$('comments-container').animate(
                        {'right': ('-' + width),
                         'min-width': 0},
                        {complete: function() {
                            show_comments = false;
                            aip_comments = false;
                            self.$('comments-container').attr('style', function(i, style) {
                                 return style.replace(/right[^;]+;?/g, '');
                            });
                            self.trigger('rescale');
                        }, queue: false}
                    );
                    self.$('comments-overlay').animate({right: ('-' + width)}, {queue: false});
                    top.nplModalRouted.navigate(
                        top.nplModalSettings.router_slug
                            + '/' + top.nplModalRouted.gallery_id
                            + '/' + top.nplModalRouted.image_id
                            + '/0',
                        false
                    );
                },
                visible: function() {
                    return show_comments;
                },
                share_enabled: function() {
                    return !methods.nplModal.is_random_source();
                },
                get_share_url: function(id) {
                    var gallery_id = top.nplModalRouted.gallery_id;
                    var base_url = top.nplModalSettings.share_url.replace('{gallery_id}', gallery_id)
                                                                 .replace('{image_id}', id);
                    var parent_link = $('<a/>').attr('href', top.location.toString())[0];
                    var base_link    = $('<a/>').attr('href', base_url)[0];

                    // shorten url by removing their common prefix
                    if (parent_link.pathname.indexOf(base_link.pathname) >= 0) {
                        parent_link.pathname = parent_link.pathname.substr(parent_link.pathname.length);
                    }

                    // this is odd but it's just how the 'share' controller expects it
                    base_link.search = parent_link.search;
                    if (base_link.search.length > 0) {
                        base_link.search += '&';
                    }
                    base_link.search += 'uri=' + parent_link.pathname;
                    return base_link.href;
                },
                // returns the Galleria image-index based on the provided image id
                get_index_from_id: function(id) {
                    var retval = null;
                    for (var i = 0; i <= (self.getDataLength() - 1); i++) {
                        if (typeof(self.getData(i).original) == 'undefined') { break; }
                        if (id == $(self.getData(i).original).data('image-id')) {
                            retval = i;
                        }
                    }
                    return retval;
                },
                // because the .length operator isn't accurate
                get_cache_size: function() {
                    return $.map(comments_cache, function(n, i) { return n; }).length
                },
                // returns the image-id field of the first preceeding image found whose comments aren't cached
                get_prev_uncached_image_id: function(id) {
                    var prev_image_id = $(self.getData(self.getPrev(this.get_index_from_id(id))).original).data('image-id');
                    if (comments_cache[prev_image_id] && this.get_cache_size() < self.getDataLength()) {
                        return this.get_prev_uncached_image_id(prev_image_id);
                    } else {
                        return prev_image_id;
                    }
                },
                // returns the image-id field of the first following image found whose comments aren't cached
                get_next_uncached_image_id: function(id) {
                    var next_image_id = $(self.getData(self.getNext(this.get_index_from_id(id))).original).data('image-id');
                    if (comments_cache[next_image_id] && this.get_cache_size() < self.getDataLength()) {
                        return this.get_next_uncached_image_id(next_image_id);
                    } else {
                        return next_image_id;
                    }
                },
                // expanded request method: adds first pre-ceding and following uncached id to the request
                expanded_request: function(id, finished) {
                    var id_array = (id instanceof Array) ? id : id.toString().split(',');
                    // a single ID was requested, so inject some extras so they can be cached in advance
                    if (id_array.length == 1) {
                        var key = id_array[0];
                        var prev = this.get_prev_uncached_image_id(key);
                        var next = this.get_next_uncached_image_id(key);
                        if (!comments_cache[prev]) { id_array.unshift(prev); }
                        if (!comments_cache[next] && prev != next && id != next) { id_array.push(next); }
                    }
                    id_array = $.unique(id_array);
                    this.request(id_array, 0, finished);
                },
                // handles the HTTP request to load comments & cache the results
                request: function(id, page, finished) {
                    $.ajax({
                        url: top.nplModalRouted.ajax_url + '?action=get_comments&type=image&page=' + page + '&id=' + id.join(','),
                        dataType: 'json',
                        success: function(data, status, jqXHR) {
                            for (var ndx in data['responses']) {
                                comments_cache[ndx] = data['responses'][ndx];
                            }
                            if (typeof finished == 'function') {
                                finished(data);
                            }
                        }
                    });
                },
                bind_form: function() {
                    $('#commentform').bind('submit', function (event) {
                        event.preventDefault();
                        var commentstatus = $('#comment-status');
                        $.ajax({
                            type: $(this).attr('method'),
                            url: $(this).attr('action'),
                            data: $(this).serialize(),
                            dataType: 'json',
                            beforeSend: function () {
                                self.$('comments-overlay').fadeIn();
                            },
                            success: function (data, status) {
                                if (data.success == true) {
                                    $('#comment').val('');
                                    $('#title').val('');
                                    var image_id = methods.galleria.get_current_image_id();
                                    methods.comments.expanded_request(image_id, function(data) {
                                        methods.comments.set_content(image_id);
                                        self.$('comments-overlay').fadeOut();
                                    });
                                } else {
                                    commentstatus.addClass('error')
                                                 .html(data);
                                    self.$('comments-overlay').fadeOut();
                                }
                            },
                            complete: function (jqXHR, status) {
                            },
                            error: function (jqXHR, status, error) {
                                commentstatus.addClass('error')
                                             .text(jqXHR.responseText);
                                self.$('comments-overlay').fadeOut();
                            }
                        });
                    });

                    // iOS doesn't fire the resized event when opening/dismissing the keyboard even though it does
                    // resize the browser dimensions and variable-widthed elements inside. This helps iScroll4.
                    $('input, textarea').bind('focus blur', function() {
                        if (Galleria.IPHONE || Galleria.IPAD) {
                            setTimeout(function() {
                                jQuery(top.window).trigger('resized');
                                jQuery(window).trigger('resized');
                                top.window.scrollTo(0,0);
                            }, 500);
                        }
                    });

                    // It is much faster to change the target attribute globally here than through WP hooks
                    self.$('comments-container').find('a').each(function() {
                        if ($(this).attr('id') == 'comment-logout') {
                            $(this).attr('href', $(this).attr('href') + '?redirect_to=' + window.location.toString());
                        } else {
                            $(this).attr('target', '_blank');
                        }
                    });

                    // 'hide comments' link
                    $('.comments-toggle').bind('click', function(event) {
                        event.preventDefault();
                        methods.comments.toggle();
                    });

                    // handles 'Reply' links
                    $('.reply-to-comment').bind('click', function(event) {
                        event.preventDefault();
                        // all that wordpress needs is the comment_parent value
                        $('#comment_parent').val($(this).data('comment-id'));
                        $('#comment-reply-status').removeClass('hidden');

                        // IE has issues setting focus on invisible elements. Be wary
                        $('#commentform').find(':input').filter(':visible:first').focus();
                        $('#comments').animate({
                            scrollTop: $('#comments-bottom').offset().top
                        }, 'slow');
                    });

                    // handles "cancel reply" link
                    $('#comment-reply-status a').bind('click', function(event) {
                        event.preventDefault();
                        $('#comment_parent').val('0');
                        $('#comment-reply-status').addClass('hidden');
                    });

                    // handles comment AJAX pagination
                    $('#comment-nav-below a').bind('click', function(event) {
                        event.preventDefault();
                        self.$('comments-overlay').fadeIn();
                        var page_id = $(this).data('page-id');
                        methods.comments.request(
                            [methods.galleria.get_current_image_id()],
                            page_id,
                            function() {
                                methods.comments.set_content(methods.galleria.get_current_image_id(), false);
                                self.$('comments-overlay').fadeOut();
                            }
                        );
                    });
                },
                // sets the display area content from previously cached results; maintains cache prefill
                set_content: function(id, load_more) {
                    id = id || $(self.getData(self.getIndex()).original).data('image-id');
                    if (load_more === undefined) { load_more = true; }
                    if (!comments_cache[id]) {
                        self.$('comments-overlay').fadeIn();
                        this.expanded_request(id, function(data) {
                            methods.comments.set_content(id, false);
                            self.$('comments-overlay').fadeOut();
                        });
                    } else {
                        self.$('comments-container').html(comments_cache[id]['rendered_view']);
                        self.$('comments-container').animate(
                            { scrollTop: 0 },
                            'slow',
                            function() {
                                if (Galleria.IPHONE || Galleria.IPAD) {
                                    var scroller = new iScroll('comments-scroll-wrapper', {
                                        hScroll: false,
                                        hScrollbar: false,
                                        hideScrollbar: false,
                                        bounce: false,
                                        onBeforeScrollStart: function(e) {
                                            var target = e.target;
                                            while (target.nodeType != 1) {
                                                target = target.parentNode;
                                            }
                                            // prevent scrolling when we want to enter text
                                            if (target.tagName != 'SELECT' && target.tagName != 'INPUT' && target.tagName != 'TEXTAREA') {
                                                e.preventDefault();
                                            }
                                        }
                                    });
                                } else {
                                    // because iOS is stupid, and iScroll4 breaks if this is set
                                    $('#comments, #respond, #commentform').css('height', '100%');
                                }
                            }
                        );
                        this.bind_form();

                        if (methods.comments.share_enabled()) {
                            // Create the links for social sharing options
                            $("<div/>", {id: 'share-buttons'}).prependTo('#comments');
                            $("<ul/>", {id: 'share-buttons-ul'}).appendTo('#share-buttons');
                            var data = self.getData(self.getIndex());
                            var base_url = encodeURIComponent(methods.comments.get_share_url(id));
                            var url = encodeURIComponent(top.location.toString());
                            var title = encodeURIComponent(data.title);
                            var summary = encodeURIComponent(data.description);
                            var image = encodeURIComponent(data.image);

                            var facebook_url = base_url;
                            facebook_url += '&p[url]=' + url;
                            facebook_url += '&p[title]=' + title;
                            facebook_url += '&p[summary]=' + summary;
                            facebook_url += '&p[images][0]=' + image;

                            var pinterest_url = base_url;
                            pinterest_url += '&url=' + url;
                            pinterest_url += '&media=' + image;
                            pinterest_url += '&description=' + summary;

                            $('<li/>').html(
                                $('<a/>', {'href': 'https://twitter.com/share?url=' + base_url,
                                    'target': '_blank',
                                    'class': 'comment-tweet-button',
                                    'title': 'Share on Twitter'})
                                    .html($('<i/>', {'class': 'icon-twitter-sign'}))
                                ).appendTo('#share-buttons-ul');
                            $('<li/>').html(
                                $('<a/>', {'href': 'https://plus.google.com/share?url=' + base_url,
                                    'target': '_blank',
                                    'class': 'comment-googlep-button',
                                    'title': 'Share on Google+'})
                                    .html($('<i/>', {'class': 'icon-google-plus-sign'}))
                                ).appendTo('#share-buttons-ul');
                            $('<li/>').html(
                                $('<a/>', {'href': 'https://www.facebook.com/sharer/sharer.php?s=100' + facebook_url,
                                    'target': '_blank',
                                    'class': 'comment-facebook-button',
                                    'title': 'Share on Facebook'})
                                    .html($('<i/>', {'class': 'icon-facebook-sign'}))
                            ).appendTo('#share-buttons-ul');
                            $('<li/>').html(
                                $('<a/>', {'href': 'http://pinterest.com/pin/create/button/?s=100' + pinterest_url,
                                    'target': '_blank',
                                    'class': 'comment-pinterest-button',
                                    'title': 'Share on Pinterest'})
                                    .html($('<i/>', {'class': 'icon-pinterest-sign'}))
                            ).appendTo('#share-buttons-ul');
                        }

                        // find and load the next uncached ID, if possible
                        if (load_more) {
                            var precache_ids = [];
                            var prev = this.get_prev_uncached_image_id(id);
                            var next = this.get_next_uncached_image_id(id);
                            if (!comments_cache[prev]) { precache_ids.push(prev); }
                            if (!comments_cache[next]) { precache_ids.push(next); }
                            if ($.unique(precache_ids).length != 0) {
                                this.expanded_request($.unique(precache_ids));
                            }
                        }
                    }
                },
                adjust_container: function() {
                    if (show_comments) {
                        self.$('stage, thumbnails-container').css({right: self.$('comments-container').width() + 'px'});
                        self.$('info').css({width: self.$('stage').width()});
                    } else {
                        self.$('stage, thumbnails-container').css({right: '0px'});
                        self.$('info').css({width: '100%'});
                    }
                    if (self._stageWidth = self.$('stage').width()) {
                        self._stageWidth = self.$('stage').width();
                        self.refreshImage();
                        self.updateCarousel();
                    }
                }
            },
            thumbnails: {
                toggle: function() {
                    if (!aip_dock) {
                        if (show_dock) {
                            this.close();
                        } else {
                            this.open();
                        }
                        aip_dock = true;
                    }
                },
                open: function() {
                    self.$('thumbnails-container, dock-toggle-container, info').animate(
                        {bottom: '+=' + self.$('thumbnails-container').height() + 'px'},
                        {complete: function() {
                            show_dock = true;
                            aip_dock = false;
                            $('.galleria-dock-toggle-container i').toggleClass('icon-angle-up icon-angle-down');
                        }}
                    );
                },
                close: function() {
                    self.$('thumbnails-container, dock-toggle-container, info').animate(
                        {bottom: '-=' + self.$('thumbnails-container').height() + 'px'},
                        {complete: function() {
                            show_dock = false;
                            aip_dock = false;
                            $('.galleria-dock-toggle-container i').toggleClass('icon-angle-up icon-angle-down');
                        }}
                    );
                },
                adjust_container: function() {
                    // this keeps the toggle button at the top of the info box & above the thumbnails container
                    if (show_info) {
                        self.$('dock-toggle-container').css({
                            bottom: ($('body').height() - self.$('info').position().top) + 'px',
                            left: (self.$('stage').width() / 2) + 'px'
                        });
                    } else {
                        self.$('dock-toggle-container').css({
                            bottom: ($('body').height() - self.$('thumbnails-container').position().top) + 'px',
                            left: (self.$('stage').width() / 2) + 'px'
                        });
                    }
                }
            },
            info: {
                toggle: function() {
                    if (!aip_info) {
                        if (!self.$('info').is(':visible')) {
                            this.open();
                        } else {
                            this.close();
                        }
                        aip_info = true;
                    }
                },
                open: function() {
                    // hide our info box before animating it into onto the screen
                    var info = self.$('info');
                    info.css({height: 'auto'});
                    var target = info.height();
                    info.css({
                        height: '0px',
                        display: 'block'
                    });
                    self.$('dock-toggle-container').animate(
                        {bottom: '+=' + target + 'px'}
                    );
                    info.animate(
                        {height: target + 'px'},
                        {complete: function() {
                            info.css({height: 'auto'});
                            show_info = true;
                            aip_info = false;
                        }}
                    );
                },
                close: function() {
                    var info = self.$('info');
                    self.$('dock-toggle-container').animate(
                        {bottom: '-=' + info.height() + 'px'}
                    );
                    info.animate(
                        {height: '0px'},
                        {complete: function() {
                            info.css({
                                display: 'none',
                                height: 'auto'
                            });
                            show_info = false;
                            aip_info = false;
                        }}
                    );
                }
            },
            icons: {
                get_color: function() {
                    var retval = '#bebebe';
                    if (parent.display_settings) {
                        retval = parent.display_settings.icon_color;
                    }
                    return retval;
                }
            },
            nplModal: {
                close: function() {
                    if (top.nplModalRouted) {
                        top.nplModalRouted.close_modal();
                    }
                },
                is_random_source: function() {
                    return ($.inArray(window.Galleria_Instance.displayed_gallery.source, ['random', 'random_images']) != -1);
                }
            },
            galleria: {
                get_current_image_id: function() {
                    return $(self.getData(self.getIndex()).original).data('image-id');
                },
                leave: function() {
                    if (top.nplModalRouted) {
                        top.nplModalRouted.close_modal();
                    }
                }
            }
        };

        ///////////////////////////////
        //// Create event bindings ////
        ///////////////////////////////
        
        // update the parent url when a new image has been chosen or the slideshow advances
        var image_event_ran_once = false;
        this.bind("image", function (event) {
            if (top.nplModalRouted && image_event_ran_once) {
                var image_id = $(this.getData(this.getIndex()).original).data('image-id');
                var gallery_id = null;
                if (window.Galleria_Instance.displayed_gallery.slug) {
                    gallery_id = window.Galleria_Instance.displayed_gallery.slug;
                } else {
                    gallery_id = window.Galleria_Instance.displayed_gallery.ID;
                }

                if (!methods.nplModal.is_random_source()) {
                    top.nplModalRouted.navigate(top.nplModalSettings.router_slug + '/' + gallery_id + '/' + image_id + '/' + (+ methods.comments.visible()), false);
                }

                if (show_comments) {
                    methods.comments.set_content();
                }
            }
            image_event_ran_once = true;
        });

        this.bind("loadfinish", function (event) {
            methods.thumbnails.adjust_container();
        });

        this.bind("rescale", function (event) {
            methods.comments.adjust_container();
            methods.thumbnails.adjust_container();
        });

        // prevent scrolling on elements without the 'scrollable' class
        this.bind('touchmove', function (event) {
            if (!$('.scrollable').has($(event.target)).length) {
                event.preventDefault();
            }
        });

        // handle updates to the current url once opened; most likely due to the back/forward button
        if (top.nplModalRouted) {
            top.nplModalRouted.on("route:gallery_and_image", function(gallery_id, image_id, comments) {
                for (var i = 0; i <= (self.getDataLength() - 1); i++) {
                    if (typeof(self.getData(i).original) == 'undefined') { break; }
                    if (image_id == $(self.getData(i).original).data('image-id')) {
                        self.show(i);
                    }
                }
                if (+ comments) {
                    methods.comments.open();
                } else {
                    methods.comments.close();
                }
            });
        }

        /////////////////////////////////
        //// Add 'loading' animation ////
        /////////////////////////////////
        
        var close_button = $('<i/>').addClass('galleria-close-button icon-remove')
            .attr('title', 'Close window')
            .css({color: methods.icons.get_color()})
            .click(function(event) {
                event.preventDefault();
                methods.galleria.leave();
            });
        $(this._dom.stage).append(close_button);
        this.append({'stage': close_button});

        ////////////////////////////////
        //// Add comments container ////
        ////////////////////////////////
        this.addElement('comments-container');
        this.addElement('comments-overlay');
        this.addElement('comments-spinner');

        // adds the spinning 'loading' animation
        var comments_spinner = $('<i/>').addClass('icon-spin icon-spinner');
        $(this._dom.stage).append(comments_spinner);
        this.append({'comments-spinner': comments_spinner});

        // display the comments sidebar if it has been requested; otherwise just initialize the comments cache
        if (top.nplModalRouted) {
            if (top.nplModalRouted.comments && top.nplModalRouted.comments == 1) {
                $(document).one(Galleria.IMAGE, function () {
                    methods.comments.toggle();
                });
            } else if (top.nplModalRouted.image_id && top.nplModalRouted.image_id != '!') {
                methods.comments.expanded_request(top.nplModalRouted.image_id);
            }
        }

        //////////////////////////////////////////
        //// Add dock buttons like play/pause ////
        //////////////////////////////////////////

        // Add playback controls
        var play_button = $('<i/>')
            .addClass('nextgen-play icon-play')
            .click(function(event) {
                event.preventDefault();
                self.playToggle();
                $(this).toggleClass('icon-play');
                $(this).toggleClass('icon-pause');
            });
        if (this._playing) {
            play_button.removeClass('icon-play').addClass('icon-pause');
        }
        $(this._dom.stage).append(play_button);

        // Add fullscreen controls
        var fullscreen_button = $('<i/>')
            .addClass('nextgen-fullscreen icon-fullscreen')
            .click(function(event) {
                event.preventDefault();
                // we assume top.nplModalRouted exists; check for it BEFORE displaying this button
                top.nplModalRouted.toggle_fullscreen();
                $(this).toggleClass('icon-fullscreen');
                $(this).toggleClass('icon-resize-small');
            });
        $(this._dom.stage).append(fullscreen_button);

        // Add share controls
        var comment_button = $('<i/>')
            .addClass('nextgen-comment icon-comment')
            .click(function(event) {
                methods.comments.toggle();
                event.preventDefault();
            });
        $(this._dom.stage).append(comment_button);

        // add info controls; handles animation of both the info & dock-toggle-container divs
        var info_button = $('<i/>')
            .addClass('nextgen-info icon-info-sign')
            .click(this.proxy(function(event) {
                event.preventDefault();
                methods.info.toggle();
            }));
        $(this._dom.stage).append(info_button);

        // Choose which buttons to display
        var display_buttons = [play_button];
        if (!Galleria.TOUCH && !Galleria.IPAD && !Galleria.IE) {
            display_buttons.push(fullscreen_button);
        }
        display_buttons.push(info_button);
        display_buttons.push(comment_button);

        // assign all of our buttons a (possibly custom) color
        for (i = 0; i <= (display_buttons.length - 1); i++) {
            display_buttons[i].css({color: methods.icons.get_color()});
        }
        self.$('counter').css({color: methods.icons.get_color()});

        this.addElement('nextgen-buttons');
        this.append({'nextgen-buttons': display_buttons});

        ///////////////////////////////////////////////////
        //// Create thumbnails-container toggle button ////
        ///////////////////////////////////////////////////
        this.addElement('dock-toggle-container');
        var dock_toggle_container = this.$('dock-toggle-container');
        var dock_toggle_button = $('<i/>').addClass('icon-angle-down')
                                          .css({color: methods.icons.get_color()});
        $(this._dom.stage).append(dock_toggle_button);
        this.append({'dock-toggle-container': dock_toggle_button});

        // event handler
        dock_toggle_container.click(this.proxy(function() {
            methods.thumbnails.toggle();
        }));

        ///////////////////////////
        //// Next / Back links ////
        ///////////////////////////
        var next_image_button = $('<i/>')
            .addClass('icon-angle-right')
            .css({color: methods.icons.get_color()});
        var prev_image_button = $('<i/>')
            .addClass('icon-angle-left')
            .css({color: methods.icons.get_color()});
        $(this._dom.stage).append(next_image_button);
        $(this._dom.stage).append(prev_image_button);
        this.append({'image-nav-left': prev_image_button});
        this.append({'image-nav-right': next_image_button});
        if (Galleria.TOUCH) {
            this.$('image-nav').css({'display': 'none'});
        }

        /////////////////////////////////////////////
        //// Handle keyboard events for Galleria ////
        /////////////////////////////////////////////
        // Unfortunately Galleria binds keyboard input events even when the active element is an input.
        var input_types = 'textarea, input';
        this.attachKeyboard({
            left: function() {
                if (!$(document.activeElement).is(input_types)) {
                    this.prev();
                }
            },
            right: function() {
                if (!$(document.activeElement).is(input_types)) {
                    this.next();
                }
            },
            down: function() {
                if (!$(document.activeElement).is(input_types)) {
                    methods.thumbnails.toggle();
                }
            },
            up: function() {
                if (!$(document.activeElement).is(input_types)) {
                    methods.info.toggle();
                }
            },
            27: function(event) {
                // escape key
                event.preventDefault();
                methods.nplModal.close();
            },
            32: function() {
                // spacebar
                if (!$(document.activeElement).is(input_types)) {
                    methods.comments.toggle();
                }
            },
            70: function() {
                // 'f' for 'f'ullscreen
                if (!$(document.activeElement).is(input_types) && top.nplModalRouted) {
                    top.nplModalRouted.toggle_fullscreen();
                }
            }
        });

        ////////////////////////////////////
        //// Add elements for rendering ////
        ////////////////////////////////////
        this.prependChild('thumbnails-container', 'nextgen-buttons');
        this.appendChild('container', 'dock-toggle-container');
        this.appendChild('container', 'comments-container');
        this.appendChild('container', 'comments-overlay');
        this.appendChild('comments-overlay', 'comments-spinner');

        // By waiting we allow the thumbnails to appear before we move them off screen
        // so users know they exist. The animations also rely on the elements actually existing..
        if (Galleria.IPHONE || Galleria.IPAD) {
            methods.thumbnails.close();
            methods.thumbnails.adjust_container();
        }

        ////////////////////////////////////////////////////////////////////////////////////////////
        //// Idle states; CSS attributes Galleria sets when there hasn't been any user activity ////
        ////////////////////////////////////////////////////////////////////////////////////////////
        if (!Galleria.TOUCH) {
            this.addIdleState(this.get('dock-toggle-button'), {opacity: 0});
            this.addIdleState(this.get('counter'),            {opacity: 0});
            this.addIdleState(this.get('image-nav-left'),     {opacity: 0});
            this.addIdleState(this.get('image-nav-right'),    {opacity: 0});
        }
    }
});

}(jQuery));
