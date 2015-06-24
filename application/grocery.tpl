<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <title>PT Medika Sejahtera</title>

    {css('bootstrap.min.css')}
    {css('londinium-theme.css')}
    {css('styles.css')}
    {css('icons.css')}
    {css('jqClock.css')}
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext"
          rel="stylesheet" type="text/css">

    <script type="text/javascript"
            src="{theme_url()}ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript"
            src="{theme_url()}ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <script type="text/javascript"
            src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>

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
    {block name=head}{/block}
</head>

<body>

<!-- Navbar -->
<div class="navbar navbar-inverse" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="#"><img src="{theme_url('images/logo.png')}" alt="Londinium"></a>
        <a class="sidebar-toggle"><i class="icon-paragraph-justify2"></i></a>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-icons">
            <span class="sr-only">Toggle navbar</span>
            <i class="icon-grid3"></i>
        </button>
        <button type="button" class="navbar-toggle offcanvas">
            <span class="sr-only">Toggle navigation</span>
            <i class="icon-paragraph-justify2"></i>
        </button>
    </div>
    <ul class="nav navbar-nav navbar-right collapse" id="navbar-icons">
        <li>
            <a href="#" id="clock"></a>
        </li>
        <li>
            <a href="#"> <strong>{userdata('name')} / {userdata('name_group')}</strong></a>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle icons-right" data-toggle="dropdown">
                <i class="icon-settings pull-right"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-right icons-right">
                <li><a href="#"><i class="icon-user"></i> Profile</a></li>
                <li><a href="#"><i class="icon-cog"></i> Settings</a></li>
                <li><a href="login/logout"><i class="icon-exit"></i> Logout</a></li>
            </ul>
        </li>
    </ul>
</div>
<!-- /navbar -->


<!-- Page container -->
<div class="page-container">


    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-content">

            <!-- Main navigation -->
            {userdata('menu')}
            <!-- /main navigation -->

        </div>
    </div>
    <!-- /sidebar -->


    <!-- Page content -->
    <div class="page-content">

        {block name=content}{/block}

        <!-- Footer -->
        <div class="footer clearfix">
            <div class="pull-left">&copy; 2015. Copyrights <a href="">Nanomites</a></div>
            <div class="pull-right icons-group">
                <a href="#"><i class="icon-arrow-up5"></i></a>
            </div>
        </div>
        <!-- /footer -->


    </div>
    <!-- /page content -->


</div>
<!-- /content -->

<script type="text/javascript"
        src="{theme_url()}ajax.googleapis.com/ajax/libs/jquery/1.10.1/jqClock.min.js"></script>
{js('form/custom.js')}

<script type="text/javascript">
    $(".insertCategoryPrefixCode").keyup(function() {
        var source = $('.insertCategoryPrefixCode').val();
        if (source.length <= 2) {
            var value = $( this ).val();
            $( 'input[name="prefix_code"]' ).val( value );
            $( 'input[name="disabled_prefix_code"]' ).val( value );
        }
    });

    $(".insertUnitPrefixCode").keyup(function() {
        var source = $('.insertUnitPrefixCode').val();
        if (source.length <= 3) {
            var value = $( this ).val();
            $( 'input[name="prefix_code"]' ).val( value );
            $( 'input[name="disabled_prefix_code"]' ).val( value );
        }
    });
</script>
</body>
</html>