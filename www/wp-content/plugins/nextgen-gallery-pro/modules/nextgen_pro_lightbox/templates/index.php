<!DOCTYPE html>
<html>
    <head>
        <meta name='viewport' content='width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no'>
        <?php
        wp_print_styles();
        ?>
        <style type='text/css'>
            html, body, div.galleria {
                height: 100%;
                width: 100%;
                margin: 0px;
                padding: 0px;
            }
        </style>
        <script type='text/javascript'>
            function close_lightbox_parent() {
                if (top.nplModalRouted) {
                    top.nplModalRouted.close_modal();
                }
            }
        </script>
    </head>
    <body onUnload="close_lightbox_parent()">
        <?php echo $galleria; ?>
        <?php wp_print_scripts(); ?>
        <script type='text/javascript'>
            // override the dimension set by galleria_parent.js; the lightbox needs full width
            jQuery(document).ready(function($) {
                if (top.nplModalRouted) {
                    $('.galleria iframe').each(function() {
                        $(this).attr({width: '100%', height: '100%'});
                    });
                }
            });

            var display_settings = <?php echo json_encode($display_settings); ?>;
        </script>
    </body>
</html>
