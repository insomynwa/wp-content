;(function($){

    var Woofreendor_Editor = {

        /**
         * Constructor function
         */
        init: function() {
            $( '.dokan-product-edit' ).on( 'click', 'a.add-new-product-batch', this.createNewBatch );
            $( 'body' ).on( 'click', 'a.woofreendor_update_batch', this.addBatchPopup );
            $( 'body' ).on( 'click', '.batch-container-footer input[type="submit"]', this.updateBatch );
            $( 'body' ).on( 'click', 'a.woofreendor_delete_batch', this.deleteBatchPopup );
            $( 'body' ).on( 'click', '.batch-container-delete-footer input[type="submit"]', this.deleteBatch );

            $( 'body' ).on( 'click', 'a#woofreendor-add-new-outlet-btn', this.actionOutletPopup );
            $( 'body' ).on( 'click', 'a.woofreendor_update_outlet', this.actionOutletPopup );
            $( 'body' ).on( 'click', '#woofreendor-popup-outlet-footer-add input[type="submit"]', this.actionSubmitOutlet );
            $( 'body' ).on( 'click', 'a.woofreendor_delete_outlet', this.deleteOutletPopup );
            $( 'body' ).on( 'click', '#woofreendor-popup-outlet-footer-delete input[type="submit"]', this.deleteOutlet );
        },

        actionOutletPopup: function(e){
            e.preventDefault();
            var data_outlet;
            var btn_act = $(this).attr('data-outlet_action');
            if(btn_act=='update_outlet'){
                var outlet = $(this).attr('data-outlet_id');
                data_outlet = {
                    id          : outlet,
                    username    : $( "input[name='outlet_username_" + outlet + "']").val(),
                    email       : $( "input[name='outlet_email_" + outlet + "']").val(),
                    displayname : $( "input[name='outlet_displayname_" + outlet + "']").val()
                };
            }else if(btn_act=='create_new'){
                data_outlet = false;
            }
            //console.log(data_outlet);
            Woofreendor_Editor.openOutletPopup(data_outlet);
        },

        actionSubmitOutlet: function(e){
            e.preventDefault();
            var act = $( "input[name='outlet_action']").val();
            
            var self = $(this),
                form = self.closest('form#woofreendor-add-update-popup-outlet-form');

            var elem_error = form.find( 'span.woofreendor-popup-error' ),
                elem_spinner = form.find( 'span.woofreendor-popup-spinner' ),
                elem_button = form.find( '#woofreendor-popup-outlet-footer-add input[type="submit"]' ),
                elem_in_name = form.find( 'input[name="outlet_name"]' ),
                elem_in_username = form.find( 'input[name="outlet_username"]' );

            if ( elem_in_name.val() == '' || (elem_in_name.val()).trim() == '') {
                elem_in_name.val('');
                elem_error.html( woofreendor.outlet_name_required );
                elem_in_name.focus();
                return;
            }
            if ( (elem_in_name.val()).trim().length < 6 ) {
                elem_error.html( woofreendor.outlet_name_min_error );
                elem_in_name.focus();
                return;
            }
            if ( elem_in_username.val() == '' || (elem_in_username.val()).trim() == '') {
                elem_in_username.val('');
                elem_error.html( woofreendor.outlet_username_required );
                elem_in_name.focus();
                return;
            }
            if ( (elem_in_username.val()).trim().length < 6 ) {
                elem_error.html( woofreendor.outlet_username_min_error );
                elem_in_name.focus();
                return;
            }
              
            elem_error.html('');
            elem_spinner.css( 'display', 'inline-block' );
            elem_button.attr('disabled',true);
          
            var data_outlet = {
                data: form.serialize(),
                error_area: elem_error,
                spinner_area: elem_spinner,
                button: elem_button
            };

            if(act=='create'){
                Woofreendor_Editor.createNewOutlet(data_outlet);
            }else if(act=='update'){
                Woofreendor_Editor.updateOutlet(data_outlet);
            }
        },

        addBatchPopup: function (e) {
            e.preventDefault();
            var batch = $(this).attr('data-batch_id');
            var data_batch = {
                id          : batch,
                start       : $( "input[name='batch_startdate_" + batch + "']").val(),
                end         : $( "input[name='batch_enddate_" + batch + "']").val(),
                stock       : $( "input[name='batch_stock_" + batch + "']").val(),
                price       : $( "input[name='batch_price_" + batch + "']").val(),
                product     : $(this).attr('data-product_id')
            };
            
            Woofreendor_Editor.openBatchPopup(data_batch);
        },

        deleteBatchPopup: function (e) {
            e.preventDefault();
            var data_batch = {
                id          : $(this).attr('data-batch_id'),
                product     : $(this).attr('data-product_id')
            };
            
            Woofreendor_Editor.openDeleteBatchPopup(data_batch);
        },

        deleteOutletPopup: function (e) {
            e.preventDefault();
            var outlet = $(this).attr('data-outlet_id');
            var data_outlet = {
                id          : outlet,
                displayname : $( "input[name='outlet_displayname_" + outlet + "']").val()
            };
            
            Woofreendor_Editor.openDeleteOutletPopup(data_outlet);
        },

        openOutletPopup: function(data_outlet) {
            var productTemplate = wp.template( 'woofreendor-add-update-outlet' );
            $.magnificPopup.open({
                fixedContentPos: true,
                items: {
                    src: productTemplate().trim(),
                    type: 'inline'
                },
                callbacks: {
                    open: function() {
                        if(data_outlet){
                            $( "h2.woofreendor_outlet_popup_title").html( 'Update - ' + data_outlet.displayname);
                            $( "input[name='outlet_name']" ).val( data_outlet.displayname );
                            $( "input[name='outlet_username']" ).val( data_outlet.username ).attr('readonly','readonly');
                            $( "input[name='outlet_email']" ).val( data_outlet.email );
                            $( "input[name='outlet_id']" ).val( data_outlet.id );
                            $( "a#woofreendor-outlet-popup-btn" ).attr( 'data-btn_id','update_outlet' );
                            $( "input[name='outlet_action']").val('update');
                        }else{
                            $( "input[name='outlet_action']").val('create');
                        }
                    },
                    close: function() {
                    }
                }
            });
        },

        openBatchPopup: function(data_batch) {
            var productTemplate = wp.template( 'update-batch-popup' );
            $.magnificPopup.open({
                fixedContentPos: true,
                items: {
                    src: productTemplate().trim(),
                    type: 'inline'
                },
                callbacks: {
                    open: function() {//console.log(data_batch);
                        $( "h3.batch_id_title").html( '#' + data_batch.id);
                        $( "input[name='batch_start']" ).val( data_batch.start );
                        $( "input[name='batch_end']" ).val( data_batch.end );
                        $( "input[name='batch_stock']" ).val( data_batch.stock );
                        $( "input[name='batch_price']" ).val( data_batch.price );
                        $( "input[name='batch_id']" ).val(data_batch.id);
                        $( "input[name='product_id']" ).val(data_batch.product);
                        $('.woofreendor_batch_start, .woofreendor_batch_end').on('focus', function() {
                            $(this).css('z-index', '99999');
                        });
                        $( ".woofreendor_date_fields input" ).datepicker({
                            defaultDate: "",
                            dateFormat: "yy-mm-dd",
                            numberOfMonths: 1
                        });
                    },
                    close: function() {

                    }
                }
            });
        },

        openDeleteBatchPopup: function(data_batch) {
            var productTemplate = wp.template( 'delete-batch-popup' );
            $.magnificPopup.open({
                fixedContentPos: true,
                items: {
                    src: productTemplate().trim(),
                    type: 'inline'
                },
                callbacks: {
                    open: function() {//console.log(data_batch);
                        $( "h3.batch_id_title").html( 'Anda ingin menghapus Batch #' + data_batch.id + ' ?');
                        $( "input[name='batch_id']" ).val(data_batch.id);
                        $( "input[name='product_id']" ).val(data_batch.product);
                    },
                    close: function() {

                    }
                }
            });
        },

        openDeleteOutletPopup: function(data_outlet) {
            var productTemplate = wp.template( 'delete-outlet-popup' );
            $.magnificPopup.open({
                fixedContentPos: true,
                items: {
                    src: productTemplate().trim(),
                    type: 'inline'
                },
                callbacks: {
                    open: function() {//console.log(data_batch);
                        $( "h3.outlet_title").html( 'Anda ingin menghapus Outlet ' + data_outlet.displayname + ' ?');
                        $( "input[name='outlet_id']" ).val( data_outlet.id );
                    },
                    close: function() {

                    }
                }
            });
        },

        createNewBatch: function(e) {
            e.preventDefault();
            var self = $(this),
                elem_parent = self.parent();

            elem_parent.find( 'span.woofreendor-show-add-batch-error' ).html('');
            elem_parent.find( 'span.woofreendor-add-new-batch-spinner' ).css( 'display', 'inline-block' );

            var data = {
                action:   'woofreendor_create_new_batch',
                product: $(this).attr('data-product_id'),
                security : woofreendor.add_batch_nonce
            };
            console.log(data);

            $.post( woofreendor.ajaxurl, data, function( resp ) {
                
                if ( resp.success ) {
                    Woofreendor_Editor.reloadBatchRow(data.product);
                } else {
                    elem_parent.find( 'span.woofreendor-add-new-batch-spinner' ).css( 'display', 'none' );
                    elem_parent.find( 'span.woofreendor-show-add-batch-error' ).html(resp.data);
                }
                
            });
        },

        createNewOutlet: function(paramData) {
            var data = {
                action:   'woofreendor_create_new_outlet',
                postdata: paramData.data,
                security : woofreendor.add_outlet_nonce
            };

            $.post( woofreendor.ajaxurl, data, function( resp ) {
                
                if ( resp.success ) {
                    $.magnificPopup.close();
                    location.reload();
                } else {
                    $.magnificPopup.close();
                }
                
            });
        },

        updateBatch: function(e){
            e.preventDefault();

            var self = $(this),
                form = self.closest('form#woofreendor-update-batch-form'),
                btn_id = self.attr('data-btn_id');

            form.find( 'span.woofreendor-show-add-batch-error' ).html('');
            form.find( 'span.woofreendor-update-batch-spinner' ).css( 'display', 'inline-block' );
            form.find( '.batch-container-footer input[type="submit"]' ).attr('disabled',true);
            var product_id = form.find( 'input[name="product_id"]' ).val();

            var data = {
                action:   'woofreendor_update_batch',
                postdata: form.serialize(),
                security : woofreendor.update_batch_nonce
            };

            $.post( woofreendor.ajaxurl, data, function( resp ) {
                if ( resp.success ) {
                    $.magnificPopup.close();
                    Woofreendor_Editor.reloadBatchRow(product_id);
                } else {
                    $( '.woofreendor-show-add-batch-error' ).html( resp.data );
                    form.find( 'span.woofreendor-update-batch-spinner' ).css( 'display', 'none' );
                    form.find( '.batch-container-footer input[type="submit"]' ).attr('disabled',false);
                }
            });
        },

        updateOutlet: function(paramData){
            
            var data = {
                action:   'woofreendor_update_outlet',
                postdata: paramData.data,
                security : woofreendor.update_outlet_nonce
            };
            
            $.post( woofreendor.ajaxurl, data, function( resp ) {
                if ( resp.success ) {
                    $.magnificPopup.close();
                    location.reload();
                } else {
                    $.magnificPopup.close();
                }
            });
        },

        deleteBatch: function(e){
            e.preventDefault();

            var self = $(this),
                form = self.closest('form#woofreendor-delete-batch-form'),
                btn_id = self.attr('data-btn_id');

            form.find( 'span.woofreendor-show-add-batch-error' ).html('');
            form.find( 'span.woofreendor-delete-batch-spinner' ).css( 'display', 'inline-block' );
            form.find( '.batch-container-delete-footer input[type="submit"]' ).attr('disabled',true);
            var product_id = form.find( 'input[name="product_id"]' ).val();

            var data = {
                action:   'woofreendor_delete_batch',
                postdata: form.serialize(),
                security : woofreendor.delete_batch_nonce
            };

            $.post( woofreendor.ajaxurl, data, function( resp ) {
                if ( resp.success ) {
                    $.magnificPopup.close();
                    Woofreendor_Editor.reloadBatchRow(product_id);
                } else {
                    $( '.woofreendor-show-add-batch-error' ).html( resp.data );
                    form.find( 'span.woofreendor-delete-batch-spinner' ).css( 'display', 'none' );
                    form.find( '.batch-container-delete-footer input[type="submit"]' ).attr('disabled',false);
                }
            });
        },

        deleteOutlet: function(e){
            e.preventDefault();

            var self = $(this),
                form = self.closest('form#woofreendor-popup-delete-outlet-form');

            form.find( 'span.woofreendor-show-add-outlet-error' ).html('');
            form.find( 'span.woofreendor-popup-spinner' ).css( 'display', 'inline-block' );
            form.find( '#woofreendor-popup-outlet-footer-delete input[type="submit"]' ).attr('disabled',true);

            var data = {
                action:   'woofreendor_delete_outlet',
                postdata: form.serialize(),
                security : woofreendor.delete_outlet_nonce
            };

            $.post( woofreendor.ajaxurl, data, function( resp ) {
                if ( resp.success ) {
                    $.magnificPopup.close();
                    location.reload();
                } else {
                    $( '.woofreendor-show-add-outlet-error' ).html( resp.data );
                    form.find( 'span.woofreendor-popup-spinner' ).css( 'display', 'none' );
                    form.find( '#woofreendor-popup-outlet-footer-delete input[type="submit"]' ).attr('disabled',false);
                }
            });
        },

        reloadBatchRow: function(product_id) {
            $("table#tab_logic > tbody").html('');
            var data = {
                action:   'woofreendor_reload_batch',
                product: product_id,
                security: woofreendor.reload_batch_nonce
            };
            
            $.get( woofreendor.ajaxurl, data, function( resp ) {
                if ( resp.success ) {
                    $("table#tab_logic > tbody").html(resp.data);
                } else {
                    $("table#tab_logic > tbody").html(woofreendor.reload_batch_error);
                }
                $( 'span.woofreendor-add-new-batch-spinner' ).css( 'display', 'none' );
            });    
        }/* ,

        isValid: function( input_type, input_value){
            var validation = {
                status: false,
                error: ''
            };
            switch( input_type){
                case 'outlet_name':
                    if( input_value == "" ) validation.error = woofreendor.outlet_name_required;
                    else if( input_value < 6 ) validation.error = woofreendor.outlet_name_min_error;
                    else validation.error = '';
                    break;
            }
            return validation;
        } */
    };

    // On DOM ready
    $(function() {
        Woofreendor_Editor.init();
    });

})(jQuery);

(function($){
    // $.validator.setDefaults({ ignore: ":hidden" });
    
    var validatorError = function(error, element) {
        var form_group = $(element).closest('.form-group');
        form_group.addClass('has-error').append(error);
    };

    var validatorSuccess = function(label, element) {
        $(element).closest('.form-group').removeClass('has-error');
    };

    var api = wp.customize;

    var Woofreendor_Settings = {
        init: function() {
            var self = this;

            //image upload
            $('a.woofreendor-upload-banner').on('click', this.imageUpload);
            /* $('a.dokan-remove-banner-image').on('click', this.removeBanner); */

            $('a.woofreendor-upload-photo').on('click', this.gragatarImageUpload);
            /* $('a.dokan-gravatar-drag').on('click', this.simpleImageUpload);
            $('a.dokan-remove-gravatar-image').on('click', this.removeGravatar); */

            this.validateForm(self);

            return false;
        },

        /* calculateImageSelectOptions: function(attachment, controller) {
            var xInit = parseInt(dokan.store_banner_dimension.width, 10),
                yInit = parseInt(dokan.store_banner_dimension.height, 10),
                flexWidth = !! parseInt(dokan.store_banner_dimension['flex-width'], 10),
                flexHeight = !! parseInt(dokan.store_banner_dimension['flex-height'], 10),
                ratio, xImg, yImg, realHeight, realWidth,
                imgSelectOptions;

            realWidth = attachment.get('width');
            realHeight = attachment.get('height');

            this.headerImage = new api.HeaderTool.ImageModel();
            this.headerImage.set({
                themeWidth: xInit,
                themeHeight: yInit,
                themeFlexWidth: flexWidth,
                themeFlexHeight: flexHeight,
                imageWidth: realWidth,
                imageHeight: realHeight
            });

            controller.set( 'canSkipCrop', ! this.headerImage.shouldBeCropped() );

            ratio = xInit / yInit;
            xImg = realWidth;
            yImg = realHeight;

            if ( xImg / yImg > ratio ) {
                yInit = yImg;
                xInit = yInit * ratio;
            } else {
                xInit = xImg;
                yInit = xInit / ratio;
            }

            imgSelectOptions = {
                handles: true,
                keys: true,
                instance: true,
                persistent: true,
                imageWidth: realWidth,
                imageHeight: realHeight,
                x1: 0,
                y1: 0,
                x2: xInit,
                y2: yInit
            };

            if (flexHeight === false && flexWidth === false) {
                imgSelectOptions.aspectRatio = xInit + ':' + yInit;
            }
            if (flexHeight === false ) {
                imgSelectOptions.maxHeight = yInit;
            }
            if (flexWidth === false ) {
                imgSelectOptions.maxWidth = xInit;
            }

            return imgSelectOptions;
        },*/

        onSelect: function() {
            var attachment = this.frame.state().get('selection').first().toJSON();
            var url = attachment.url,
                w = attachment.width,
                h = attachment.height;
            this.setImageFromURL(url, attachment.id, w, h);
            // console.log(this.frame.states.models);
            // this.frame.setState('cropper');
        },

        onCropped: function(croppedImage) {
            // console.log(croppedImage);
            /* var url = croppedImage.url,
                attachmentId = croppedImage.attachment_id,
                w = croppedImage.width,
                h = croppedImage.height; */
            //this.setImageFromURL(url, attachmentId, w, h);
        },

        /* onSkippedCrop: function(selection) {
            var url = selection.get('url'),
                w = selection.get('width'),
                h = selection.get('height');
            this.setImageFromURL(url, selection.id, w, h);
        }, */

        setImageFromURL: function(url, attachmentId, width, height) {
            if ( $(this.uploadBtn).hasClass('woofreendor-upload-banner') ) {
                var wrap = $(this.uploadBtn).closest('.dokan-banner');
                wrap.find('input.dokan-file-field').val(attachmentId);
                wrap.find('img.dokan-banner-img').attr('src', url);
                $(this.uploadBtn).parent().siblings('.image-wrap', wrap).removeClass('dokan-hide');
                $(this.uploadBtn).parent('.button-area').addClass('dokan-hide');
            } else if ( $(this.uploadBtn).hasClass('woofreendor-upload-photo') ) {
                var wrap = $(this.uploadBtn).closest('.dokan-gravatar');
                wrap.find('input.dokan-file-field').val(attachmentId);
                wrap.find('img.dokan-gravatar-img').attr('src', url);
                $(this.uploadBtn).parent().siblings('.gravatar-wrap', wrap).removeClass('dokan-hide');
                $(this.uploadBtn).parent('.gravatar-button-area').addClass('dokan-hide');
            }
        },

        /* removeImage: function() {
            api.HeaderTool.currentHeader.trigger('hide');
            api.HeaderTool.CombinedList.trigger('control:removeImage');
        }, */

        imageUpload: function(e) {
            e.preventDefault();

            var file_frame,
                settings = Woofreendor_Settings;

            settings.uploadBtn = this;

            settings.frame = wp.media({
                multiple: false,
                button: {
                    text: 'Select Banner',//dokan.selectAndCrop,
                    close: true//false
                },
                title: 'Select Banner'
                /* states: [
                    new wp.media.controller.Library({
                        title:     dokan.chooseImage,
                        library:   wp.media.query({ type: 'image' }),
                        multiple:  false,
                        date:      false,
                        priority:  20,
                        suggestedWidth: dokan.store_banner_dimension.width,
                        suggestedHeight: dokan.store_banner_dimension.height
                    }),
                    new wp.media.controller.Cropper({
                        suggestedWidth: 5000,
                        imgSelectOptions: settings.calculateImageSelectOptions
                    })
                ] */
            });

            settings.frame.on('select', settings.onSelect, settings);
            /* settings.frame.on('cropped', settings.onCropped, settings);
            settings.frame.on('skippedcrop', settings.onSkippedCrop, settings); */

            settings.frame.open();

        },

        calculateImageSelectOptionsProfile: function(attachment, controller) {
            var xInit = 150,
                yInit = 150,
                flexWidth = !! parseInt(dokan.store_banner_dimension['flex-width'], 10),
                flexHeight = !! parseInt(dokan.store_banner_dimension['flex-height'], 10),
                ratio, xImg, yImg, realHeight, realWidth,
                imgSelectOptions;

            realWidth = attachment.get('width');
            realHeight = attachment.get('height');

            this.headerImage = new api.HeaderTool.ImageModel();
            this.headerImage.set({
                themeWidth: xInit,
                themeHeight: yInit,
                themeFlexWidth: flexWidth,
                themeFlexHeight: flexHeight,
                imageWidth: realWidth,
                imageHeight: realHeight
            });

            controller.set( 'canSkipCrop', ! this.headerImage.shouldBeCropped() );
            // console.log(this.headerImage);
            ratio = xInit / yInit;
            xImg = realWidth;
            yImg = realHeight;

            if ( xImg / yImg > ratio ) {
                yInit = yImg;
                xInit = yInit * ratio;
            } else {
                xInit = xImg;
                yInit = xInit / ratio;
            }

            imgSelectOptions = {
                handles: true,
                keys: true,
                instance: true,
                persistent: true,
                imageWidth: realWidth,
                imageHeight: realHeight,
                x1: 0,
                y1: 0,
                x2: xInit,
                y2: yInit
            };

            if (flexHeight === false && flexWidth === false) {
                imgSelectOptions.aspectRatio = xInit + ':' + yInit;
            }
            if (flexHeight === false ) {
                imgSelectOptions.maxHeight = yInit;
            }
            if (flexWidth === false ) {
                imgSelectOptions.maxWidth = xInit;
            }

            return imgSelectOptions;
        },

        /* simpleImageUpload : function(e) {
            e.preventDefault();
                var file_frame,
                self = $(this);

            // If the media frame already exists, reopen it.
            if ( file_frame ) {
                file_frame.open();
                return;
            }

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                title: jQuery( this ).data( 'uploader_title' ),
                button: {
                    text: jQuery( this ).data( 'uploader_button_text' )
                },
                multiple: false
            });

            // When an image is selected, run a callback.
            file_frame.on( 'select', function() {
                var attachment = file_frame.state().get('selection').first().toJSON();

                var wrap = self.closest('.dokan-gravatar');
                wrap.find('input.dokan-file-field').val(attachment.id);
                wrap.find('img.dokan-gravatar-img').attr('src', attachment.url);
                self.parent().siblings('.gravatar-wrap', wrap).removeClass('dokan-hide');
                self.parent('.gravatar-button-area').addClass('dokan-hide');

            });

            // Finally, open the modal
            file_frame.open();
        }, */

        gragatarImageUpload: function(e) {
            e.preventDefault();

            var file_frame,
                settings = Woofreendor_Settings;

            settings.uploadBtn = this;

            settings.frame = wp.media({
                multiple: false,
                button: {
                    text: 'Select',//dokan.selectAndCrop,
                    close: true//false
                },
                title: 'Select Photo'
                /* states: [
                    new wp.media.controller.Library({
                        title:     'Select Photo',
                        library:   wp.media.query({ type: 'image' }),
                        multiple:  false,
                        date:      false,
                        priority:  20,
                        suggestedWidth: 150,
                        suggestedHeight: 150
                    }),
                    new wp.media.controller.Cropper({
                        imgSelectOptions: settings.calculateImageSelectOptionsProfile,
                    })
                ] */
            });

            settings.frame.on('select', settings.onSelect, settings);
            // settings.frame.on('cropped', settings.onCropped, settings);
            // settings.frame.on('skippedcrop', settings.onSkippedCrop, settings);
            // console.log(settings.frame);
            settings.frame.open();

        },
        
        submitSettings: function(form_id) {

            if ( typeof tinyMCE != 'undefined' ) {
                tinyMCE.triggerSave();
            }

            var self = $( "form#" + form_id ),
                form_data = self.serialize() + '&action=woofreendor_settings&form_id=' + form_id;

            self.find('.ajax_prev').append('<span class="dokan-loading"> </span>');
            $.post(woofreendor.ajaxurl, form_data, function(resp) {

                self.find('span.dokan-loading').remove();
                $('html,body').animate({scrollTop:100});

                if ( resp.success ) {
                    // Harcoded Customization for template-settings function
                        $('.dokan-ajax-response').html( $('<div/>', {
                        'class': 'dokan-alert dokan-alert-success',
                        'html': '<p>' + resp.data.msg + '</p>',
                    }) );

                    $('.dokan-ajax-response').append(resp.data.progress);

                }else {
                    $('.dokan-ajax-response').html( $('<div/>', {
                        'class': 'dokan-alert dokan-alert-danger',
                        'html': '<p>' + resp.data + '</p>'
                    }) );
                }
            });
        },

        validateForm: function(self) {

            $("form#tenant-form").validate({
                //errorLabelContainer: '#errors'
                submitHandler: function(form) {
                    self.submitSettings( form.getAttribute('id') );
                },
                errorElement: 'span',
                errorClass: 'error',
                errorPlacement: validatorError,
                success: validatorSuccess
            });

        }//,

        /* removeBanner: function(e) {
            e.preventDefault();

            var self = $(this);
            var wrap = self.closest('.image-wrap');
            var instruction = wrap.siblings('.button-area');

            wrap.find('input.dokan-file-field').val('0');
            wrap.addClass('dokan-hide');
            instruction.removeClass('dokan-hide');
        }, */

        /* removeGravatar: function(e) {
            e.preventDefault();

            var self = $(this);
            var wrap = self.closest('.gravatar-wrap');
            var instruction = wrap.siblings('.gravatar-button-area');

            wrap.find('input.dokan-file-field').val('0');
            wrap.addClass('dokan-hide');
            instruction.removeClass('dokan-hide');
        }, */
    };

    $(function() {
        Woofreendor_Settings.init();

        $('.dokan-form-horizontal').on('change', 'input[type=checkbox]#lbl_setting_minimum_quantity', function(){
            var showSWDiscount =  $( '.show_if_needs_sw_discount' );
            if ( $( this ).is(':checked') ) {
                showSWDiscount.find('input[type="number"]').val('');
                showSWDiscount.slideDown('slow');
            } else {
                showSWDiscount.slideUp('slow');
            }
        } );
    });
    
})(jQuery);