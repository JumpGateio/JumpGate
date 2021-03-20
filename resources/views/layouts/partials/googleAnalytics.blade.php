@if (config('app.debug') == false)
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-9093798-5"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {dataLayer.push(arguments);}

    gtag('js', new Date());

    gtag('config', 'UA-9093798-5');
  </script>
@endif
