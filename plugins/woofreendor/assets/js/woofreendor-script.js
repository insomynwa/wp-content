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
            //console.log(data);

            $.post( woofreendor.ajaxurl, data, function( resp ) {
                
                if ( resp.success ) {
                    Woofreendor_Editor.reloadBatchRow(data.product);
                } else {
                    elem_parent.find( 'span.woofreendor-add-new-batch-spinner' ).css( 'display', 'none' );
                    elem_parent.find( 'span.woofreendor-show-add-batch-error' ).html(resp.data);
                }
                
            });
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
        },

        inputValidate: function( e ) {
            e.preventDefault();

            if ( $( '#post_title' ).val().trim() == '' ) {
                $( '#post_title' ).focus();
                $( 'div.dokan-product-title-alert' ).removeClass('dokan-hide');
                return;
            }else{
                $( 'div.dokan-product-title-alert' ).hide();
            }

            if ( $( 'select.product_cat' ).val() == -1 ) {
                $( 'select.product_cat' ).focus();
                $( 'div.dokan-product-cat-alert' ).removeClass('dokan-hide');
                return;
            }else{
                $( 'div.dokan-product-cat-alert' ).hide();
            }
            $( 'input[type=submit]' ).attr( 'disabled', 'disabled' );
            this.submit();
        }
    };

    // On DOM ready
    $(function() {
        Woofreendor_Editor.init();
    });

})(jQuery);
