<html>
    <head>
        <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-8TZW208949"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-8TZW208949');
</script>
        @php
            $setting = setting();
        @endphp
        <title>{{ $setting->title }}</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
            @vite(['resources/js/app.tsx', 'resources/css/app.css'])
      
    </head>
    <body>
        <div id="app"></div>
                  

        <style>
            #st-1 .st-total{
                display:none
            }
        </style>
    </body>
</html>
