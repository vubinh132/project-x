<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('emails.style')
</head>

<body style="font-family:Helvetica Neue, Helvetica, Arial, sans-serif;">
<div style="overflow: auto; width: 100%; max-width: 698px;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="100%">
                @include('emails.header')
            </td>
        </tr>
        <tr>
            <td colspan="100%" style="padding:0 15px; font-size: 16px; line-height: 20px;">
                @yield('content')
            </td>
        </tr>
        <tr>
            <td colspan="100%" style="padding: 20px 15px 10px; font-size: 16px; line-height: 20px;">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="footer">
                            @include('emails.footer_vi')
                        </td>
                    </tr>
                    <tr>
                        <td class="reason">
                            @yield('reason')
                            <div style="width: 100%" class="m-text-center">
                                <small>
                                    &copy;<?php echo date("Y"); ?> {{ config('app.name') }}.
                                </small>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>