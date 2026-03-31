@if(app()->environment('production') && env('GA_MEASUREMENT_ID'))
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GA_MEASUREMENT_ID') }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{{ env('GA_MEASUREMENT_ID') }}');
</script>
@endif