<!DOCTYPE html>
<html lang="ru">

<head>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">

</head>
<body>


<script src="/assets/985a2e0b/jquery.js"></script>
<script src="/plugins/chartist/chartist.js"></script>


<script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>

<script
    src="/js/chartist-plugin-pointlabels.js"></script>


<!--
<script
    src="/js/all.js"></script>
-->





<div class="ct-chart ct-perfect-fourth" style="width: 100%;height:300px"></div>


11




<script>

    $( document ).ready(function() {
        new Chartist.Line('.ct-chart', {
            labels: ['M', 'T', 'W', 'T', 'F'],
            series: [
                [12, 9, 7, 8, 5]
            ]
        }, {
            plugins: [
                Chartist.plugins.ctPointLabels({
                    textAnchor: 'middle'
                })
            ]
        });

    });
</script>


</body>
</html>

