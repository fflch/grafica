<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    @yield('styles_head') 
</head>

<body>
    <header id="headerFFLCH">
        @yield('header')
    </header>

    <div class="content"> @yield('content') </div>

    <div id="footer" class="footer"> @yield('footer') </div>

    <script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            if ($PAGE_COUNT > 1) {
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $size = 10;
                $pageText = "Pagina ".$PAGE_NUM . " / " . $PAGE_COUNT;
                $y = $pdf->get_height() - 20;
                $x = $pdf->get_width() - 15 - $fontMetrics->get_text_width($pageText, $font, $size);
                $pdf->text($x, $y, $pageText, $font, $size);
            }
        ');
    }
    </script>
</body>
</html>