<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <title>PT Medika Sejahtera</title>

    {css('bootstrap.min.css')}
    {css('londinium-theme.css')}
    {css('styles.css')}
    {css('icons.css')}
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="{theme_url()}ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript" src="{theme_url()}ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

    {js('plugins/charts/sparkline.min.js')}

    {js('plugins/forms/uniform.min.js')}
    {js('plugins/forms/select2.min.js')}
    {js('plugins/forms/inputmask.js')}
    {js('plugins/forms/autosize.js')}
    {js('plugins/forms/inputlimit.min.js')}
    {js('plugins/forms/listbox.js')}
    {js('plugins/forms/multiselect.js')}
    {js('plugins/forms/validate.min.js')}
    {js('plugins/forms/tags.min.js')}
    {js('plugins/forms/switch.min.js')}

    {js('plugins/forms/uploader/plupload.full.min.js')}
    {js('plugins/forms/uploader/plupload.queue.min.js')}

    {js('plugins/forms/wysihtml5/wysihtml5.min.js')}
    {js('plugins/forms/wysihtml5/toolbar.js')}

    {js('plugins/interface/daterangepicker.js')}
    {js('plugins/interface/fancybox.min.js')}
    {js('plugins/interface/moment.js')}
    {js('plugins/interface/jgrowl.min.js')}
    {js('plugins/interface/datatables.min.js')}
    {js('plugins/interface/colorpicker.js')}
    {js('plugins/interface/fullcalendar.min.js')}
    {js('plugins/interface/timepicker.min.js')}

    {js('bootstrap.min.js')}
    {js('application.js')}

</head>


<body class="full-width page-condensed">

<!-- Navbar -->
<div class="navbar navbar-inverse" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="#"><img src="{theme_url('images/logo.png')}" alt="Londinium"></a>
    </div>
</div>
<!-- /navbar -->


<!-- Login wrapper -->
{block name=content}{/block}
<!-- /login wrapper -->


<!-- Footer -->
<div class="footer clearfix">
    <div class="pull-left">&copy; 2015. Copyrights <a href="">Nanomites</a></div>
    <div class="pull-right icons-group">
        <a href="#"><i class="icon-screen2"></i></a>
        <a href="#"><i class="icon-balance"></i></a>
        <a href="#"><i class="icon-cog3"></i></a>
    </div>
</div>
<!-- /footer -->


</body>
</html>