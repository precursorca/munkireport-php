
<h2><span data-i18n="servermetrics.memory.usage"></span></h2>
<svg id="memory-usage" style="height: 400px"></svg>

<h2 data-i18n="servermetrics.cpu_usage"></h2>
<svg id="cpu-usage" style="height: 400px"></svg>

<h2 data-i18n="servermetrics.network.traffic"></h2>
<svg id="network-traffic" style="height: 400px"></svg>

<h2 data-i18n="servermetrics.memory.pressure"></h2>
<svg id="memory-pressure" style="height: 400px"></svg>

<h2 data-i18n="servermetrics.caching.bytes_served"></h2>
<svg id="caching-bytes-served" style="height: 400px"></svg>

<h2 data-i18n="servermetrics.sharing.connected_users"></h2>
<svg id="sharing-connected-users" style="height: 400px"></svg>

<script src="<?php echo conf('subdirectory'); ?>assets/js/munkireport.serverstats.js"></script>

<script>

$(document).on('appReady', function(e, lang) {
    var hours = 24 * 7; // timespan
    drawServerPlots(hours);
});
    
</script>
