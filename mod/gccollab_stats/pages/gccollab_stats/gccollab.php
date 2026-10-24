<?php

    $title = elgg_echo("gccollab_stats:title");

    $body = elgg_view_layout('one_column', array(
        'content' => get_stats(),
        'title' => $title,
    ));

    echo elgg_view_page($title, $body);

    function get_stats(){

        ob_start(); ?>

        <script src="//code.highcharts.com/6.1.0/highcharts.js"></script>
        <script src="//code.highcharts.com/modules/exporting.js"></script>
        <script src="//code.highcharts.com/modules/data.js"></script>
        <script src="//code.highcharts.com/modules/drilldown.js"></script>
        <script src="//highcharts.github.io/export-csv/export-csv.js"></script>
        <script>var lang = '<?php echo get_current_language(); ?>';</script>
        <script>var siteUrl = '<?php echo elgg_get_site_url(); ?>';</script>
        <script>
            Date.prototype.niceDate = function() {
                if(lang == "fr"){
                    var months = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
                    var mm = this.getMonth();
                    var dd = this.getDate();
                    var yy = this.getFullYear();
                    return dd + ' ' + months[mm] + ' ' + yy;
                } else {
                    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                    var mm = this.getMonth();
                    var dd = this.getDate();
                    var yy = this.getFullYear();
                    return months[mm] + ' ' + dd + ', ' + yy;
                }
            };

            String.prototype.capitalizeFirstLetter = function() {
                return this.charAt(0).toUpperCase() + this.slice(1);
            }

            function SortRegistrations(a, b){
                return (a[0] - b[0]);
            }

            function SortByCount(a, b){
                return (b[1] - a[1]);
            }

            function SortByName(a, b){
                var one = (a.name != null) ? a.name.toLowerCase().replace(/é/g, 'e').replace(/è/g, 'e').replace(/î/g, 'i') : "";
                var two = (b.name != null) ? b.name.toLowerCase().replace(/é/g, 'e').replace(/è/g, 'e').replace(/î/g, 'i') : "";
                if(one < two) return -1;
                if(one > two) return 1;
                return 0;
            }

            function SortInstitutionByName(a, b){
                var one = (a[0] != null) ? a[0].toLowerCase().replace(/é/g, 'e').replace(/è/g, 'e').replace(/î/g, 'i') : "";
                var two = (b[0] != null) ? b[0].toLowerCase().replace(/é/g, 'e').replace(/è/g, 'e').replace(/î/g, 'i') : "";
                if(one < two) return -1;
                if(one > two) return 1;
                return 0;
            }
        </script>
    <?php if(get_current_language() == "fr"): ?>
        <script>
            Highcharts.setOptions({
                lang: {
                    months: ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'],
                    weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                    shortMonths: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aout', 'Sept', 'Oct', 'Nov', 'Déc'],
                    decimalPoint: ',',
                    downloadPNG: 'Télécharger en image PNG',
                    downloadJPEG: 'Télécharger en image JPEG',
                    downloadPDF: 'Télécharger en document PDF',
                    downloadSVG: 'Télécharger en document Vectoriel',
                    exportButtonTitle: 'Export du graphique',
                    loading: 'Chargement en cours...',
                    printButtonTitle: 'Imprimer le graphique',
                    resetZoom: 'Réinitialiser le zoom',
                    resetZoomTitle: 'Réinitialiser le zoom au niveau 1:1',
                    thousandsSep: ' ',
                    decimalPoint: ',',
                    printChart: 'Imprimer le graphique',
                    downloadCSV: 'Télécharger en CSV',
                    downloadXLS: 'Télécharger en XLS',
                    viewData: 'Afficher la table des données'
                }
            });
        </script>
    <?php endif; ?>
        <style>
        .chart {
            width: 100%;
            min-width: 100%; 
            max-width: 100%; 
            margin: 0 auto;
        }
        .chart .loading {
            padding-top: 10%;
            display: block;
            font-size: 2em;
            text-align: center;
        }
        @media (max-width: 480px) { 
            .nav-tabs > li {
                float:none;
            }
        }
        </style>
    
        <div class="chart" id="registrations" style="min-height: 400px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                var registrations = [];
                var registrationsCount = 0;
                var groups = [];
                var groupsCount = 0;
                var opportunities = [];
                var opportunitiesCount = 0;

                var date = new Date();
                var userTimezoneOffset = date.getTimezoneOffset() * 60000;

                $.when(
                    $.getJSON(siteUrl + 'services/api/rest/json/?method=time.stats&type=members&lang=' + lang, function (data) {
                        $.each(data.result, function(key, value) {
                            registrationsCount += parseInt(value.count);
                            registrations.push([(parseInt(value.time) * 1000) + userTimezoneOffset, registrationsCount, parseInt(value.count)]);
                        });
                        registrations.sort(SortRegistrations);
                    }),
                    $.getJSON(siteUrl + 'services/api/rest/json/?method=time.stats&type=groups&lang=' + lang, function (data) {
                        $.each(data.result, function(key, value) {
                            groupsCount += parseInt(value.count);
                            groups.push([(parseInt(value.time) * 1000) + userTimezoneOffset, groupsCount, parseInt(value.count)]);
                        });
                        groups.sort(SortRegistrations);
                    }),
                    $.getJSON(siteUrl + 'services/api/rest/json/?method=time.stats&type=opportunities&lang=' + lang, function (data) {
                        $.each(data.result, function(key, value) {
                            opportunitiesCount += parseInt(value.count);
                            opportunities.push([(parseInt(value.time) * 1000) + userTimezoneOffset, opportunitiesCount, parseInt(value.count)]);
                        });
                        opportunities.sort(SortRegistrations);
                    })
                ).then(function() {
                    Highcharts.chart('registrations', {
                        chart: {
                            zoomType: 'x',
                            resetZoomButton: {
                                position: {
                                    align: 'left',
                                    x: 10,
                                },
                                relativeTo: 'chart'
                            }
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:time:title"); ?>'
                        },
                        subtitle: {
                            text: document.ontouchstart === undefined ? '<?php echo elgg_echo("gccollab_stats:zoommessage"); ?>' : '<?php echo elgg_echo("gccollab_stats:pinchmessage"); ?>'
                        },
                        xAxis: {
                            type: 'datetime'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:amount"); ?>'
                            },
                            min: 0
                        },
                        legend: {
                            enabled: true
                        },
                        plotOptions: {
                            area: {
                                fillColor: {
                                    linearGradient: {
                                        x1: 0,
                                        y1: 0,
                                        x2: 0,
                                        y2: 1
                                    },
                                    stops: [
                                        [0, Highcharts.getOptions().colors[0]],
                                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                                    ]
                                },
                                marker: {
                                    radius: 2
                                },
                                lineWidth: 1,
                                states: {
                                    hover: {
                                        lineWidth: 1
                                    }
                                },
                                threshold: null
                            }
                        },
                        tooltip: {
                            formatter: function() {
                                var text = "";
                                if(this.series.userOptions.id == 'opportunities') {
                                    text = '<b><?php echo elgg_echo("gccollab_stats:date"); ?></b> ' + new Date(opportunities[this.series.data.indexOf(this.point)][0]).niceDate()
                                    + '<br /><b><?php echo elgg_echo("gccollab_stats:onthisday"); ?></b> ' + opportunities[this.series.data.indexOf(this.point)][2]
                                    + '<br /><b><?php echo elgg_echo("gccollab_stats:total"); ?></b> ' + opportunities[this.series.data.indexOf(this.point)][1];
                                } else if(this.series.userOptions.id == 'groups') {
                                    text = '<b><?php echo elgg_echo("gccollab_stats:date"); ?></b> ' + new Date(groups[this.series.data.indexOf(this.point)][0]).niceDate()
                                    + '<br /><b><?php echo elgg_echo("gccollab_stats:onthisday"); ?></b> ' + groups[this.series.data.indexOf(this.point)][2]
                                    + '<br /><b><?php echo elgg_echo("gccollab_stats:total"); ?></b> ' + groups[this.series.data.indexOf(this.point)][1];
                                } else if(this.series.userOptions.id == 'members') {
                                    text = '<b><?php echo elgg_echo("gccollab_stats:date"); ?></b> ' + new Date(registrations[this.series.data.indexOf(this.point)][0]).niceDate()
                                	+ '<br /><b><?php echo elgg_echo("gccollab_stats:onthisday"); ?></b> ' + registrations[this.series.data.indexOf(this.point)][2]
                                	+ '<br /><b><?php echo elgg_echo("gccollab_stats:total"); ?></b> ' + registrations[this.series.data.indexOf(this.point)][1];
                                }
                                return text;
                            }
                        },
                        series: [{
                            type: 'area',
                            id: 'members',
                            name: '<?php echo elgg_echo("gccollab_stats:membercount"); ?> (' + registrationsCount + ')',
                            data: registrations
                        }, {
                            type: 'area',
                            id: 'groups',
                            name: '<?php echo elgg_echo("gccollab_stats:groupcount"); ?> (' + groupsCount + ')',
                            data: groups,
                            visible: false
                        }, {
                            type: 'area',
                            id: 'opportunities',
                            name: '<?php echo elgg_echo("gccollab_stats:opportunitycount"); ?> (' + opportunitiesCount + ')',
                            data: opportunities,
                            visible: false
                        }]
                    });
                });
            });
        </script>

        <hr />
    <div class="form-group">
        <label for="user-stats"><?php echo elgg_echo("gccollab_stats:types:select"); ?></label>
        <select id="user-stats" class="form-control user-select">
            <option value="all"><?php echo elgg_echo("gccollab_stats:types:title"); ?></option>
            <option value="academic"><?php echo elgg_echo("gccollab_stats:academic:title"); ?></option>
            <option value="student"><?php echo elgg_echo("gccollab_stats:student:title"); ?></option>
            <option value="federal"><?php echo elgg_echo("gccollab_stats:federal:title"); ?></option>
            <option value="provincial"><?php echo elgg_echo("gccollab_stats:provincial:title"); ?></option>
            <option value="municipal"><?php echo elgg_echo("gccollab_stats:municipal:title"); ?></option>
            <option value="international"><?php echo elgg_echo("gccollab_stats:international:title"); ?></option>
            <option value="ngo"><?php echo elgg_echo("gccollab_stats:ngo:title"); ?></option>
            <option value="community"><?php echo elgg_echo("gccollab_stats:community:title"); ?></option>
            <option value="business"><?php echo elgg_echo("gccollab_stats:business:title"); ?></option>
            <option value="media"><?php echo elgg_echo("gccollab_stats:media:title"); ?></option>
            <option value="retired"><?php echo elgg_echo("gccollab_stats:retired:title"); ?></option>
            <option value="other"><?php echo elgg_echo("gccollab_stats:other:title"); ?></option>
        </select>
    </div>

    <div class="user-stats" id="all">

        <div class="chart" id="allMembers" style="min-height: 350px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=member.stats&type=all&lang=' + lang, function (data) {
                    var allMembers = [];
                    var allMembersCount = 0, unknownCount = 0;
                    $.each(data.result, function(key, value) {
                        if(key == 'total') { return; }
                        if(key != 'public_servant' && key != ''){
                            allMembers.push([key.capitalizeFirstLetter(), value]);
                        } else {
                            unknownCount += value;
                        }
                        allMembersCount += value;
                    });
                    if(unknownCount > 0){ allMembers.push(['<?php echo elgg_echo('gccollab_stats:unknown'); ?>', unknownCount]); }
                    allMembers.sort(SortByCount);

                    Highcharts.chart('allMembers', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:types:title"); ?>'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:membercount"); ?>'
                            }

                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style=\"font-size:11px\">{series.name}</span><br>',
                            pointFormat: '<span style=\"color:{point.color}\">{point.name}</span>: <b>{point.y}</b> <?php echo elgg_echo("gccollab_stats:users"); ?><br/>'
                        },
                        series: [{
                            name: '<?php echo elgg_echo("gccollab_stats:membertype"); ?>',
                            colorByPoint: true,
                            data: allMembers
                        }]
                    });
                });
            });
        </script>
    </div>

    <div class="user-stats" id="academic">

        <div class="chart" id="academicMembers" style="min-height: 800px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=member.stats&type=academic&lang=' + lang, function (data) {
                    var academicMembers = [];
                    var academicMembersDrilldown = [];
                    var academicMembersCount = 0;
                    var institutionName = (lang == "fr") ? {"college": "Collège", "university": "Université"} : {"college": "College", "university": "University"};
                    $.each(data.result, function(key, value) {
                        if(key == 'college' || key == 'university'){
                            academicMembers.push({'name': institutionName[key], 'y': value['total'], 'drilldown': institutionName[key]});
                            academicMembersCount += value['total'];
                        }

                        var institutionData = [];
                        $.each(value, function(school, count){
                            if(school != 'total') institutionData.push([school, count]);
                        });
                        institutionData.sort(SortInstitutionByName);

                        if(key == 'college' || key == 'university'){
                            academicMembersDrilldown.push({'name': institutionName[key], 'id': institutionName[key], 'data': institutionData});
                        }
                    });
                    academicMembers.sort(SortByName);
                    academicMembersDrilldown.sort(SortByName);

                    Highcharts.chart('academicMembers', {
                        chart: {
                            type: 'bar',
                            events: {
                                drilldown: function (e) {
                                    if(e.seriesOptions.id == "College" || e.seriesOptions.id == "Collège"){
                                        this.xAxis[0].update({
                                            max: academicMembersDrilldown[0].data.length - 1
                                        });
                                    } else if(e.seriesOptions.id == "University" || e.seriesOptions.id == "Université"){
                                        this.xAxis[0].update({
                                            max: academicMembersDrilldown[1].data.length - 1
                                        });
                                    }
                                },
                                drillup: function () {
                                    this.xAxis[0].update({
                                        max: academicMembers.length - 1
                                    });
                                }
                            }
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:academic:title"); ?> (' + academicMembersCount + ')'
                        },
                        subtitle: {
                            text: '<?php echo elgg_echo("gccollab_stats:schoolmessage"); ?>'
                        },
                        xAxis: {
                            type: 'category',
                            startOnTick: true,
                            endOnTick: true,
                            max: academicMembers.length - 1
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:membercount"); ?>'
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style=\"font-size:11px\">{series.name}</span><br>',
                            pointFormat: '<span style=\"color:{point.color}\">{point.name}</span>: <b>{point.y}</b> <?php echo elgg_echo("gccollab_stats:users"); ?><br/>'
                        },
                        series: [{
                            name: 'Institution',
                            colorByPoint: true,
                            data: academicMembers
                        }],
                        drilldown: {
                            series: academicMembersDrilldown
                        },
                        colors: ['#7cb5ec', '#f45b5b']
                    });
                });
            });
        </script>
    </div>

    <div class="user-stats" id="student">

        <div class="chart" id="studentMembers" style="min-height: 800px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=member.stats&type=student&lang=' + lang, function (data) {
                    var studentMembers = [];
                    var studentMembersDrilldown = [];
                    var studentMembersCount = 0;
                    var institutionName = (lang == "fr") ? {"college": "Collège", "university": "Université", "highschool": "École secondaire"} : {"college": "College", "university": "University", "highschool": "High School"};
                    $.each(data.result, function(key, value) {
                        if(key == 'college' || key == 'university' || key == 'highschool'){
                            studentMembers.push({'name': institutionName[key], 'y': value['total'], 'drilldown': institutionName[key]});
                            studentMembersCount += value['total'];
                        }

                        var institutionData = [];
                        $.each(value, function(school, count){
                            if(school != 'total') institutionData.push([school, count]);
                        });
                        institutionData.sort(SortInstitutionByName);
                        
                        if(key == 'college' || key == 'university' || key == 'highschool'){
                            studentMembersDrilldown.push({'name': institutionName[key], 'id': institutionName[key], 'data': institutionData});
                        }
                    });
                    studentMembers.sort(SortByName);
                    studentMembersDrilldown.sort(SortByName);

                    Highcharts.chart('studentMembers', {
                        chart: {
                            type: 'bar',
                            events: {
                                drilldown: function (e) {
                                    if(e.seriesOptions.id == "College" || e.seriesOptions.id == "Collège"){
                                        this.xAxis[0].update({
                                            max: studentMembersDrilldown[0].data.length - 1
                                        });
                                    } else if(e.seriesOptions.id == "High School" || e.seriesOptions.id == "École secondaire"){
                                        this.xAxis[0].update({
                                            max: studentMembersDrilldown[1].data.length - 1
                                        });
                                    } else if(e.seriesOptions.id == "University" || e.seriesOptions.id == "Université"){
                                        this.xAxis[0].update({
                                            max: studentMembersDrilldown[2].data.length - 1
                                        });
                                    }
                                },
                                drillup: function () {
                                    this.xAxis[0].update({
                                        max: studentMembers.length - 1
                                    });
                                }
                            }
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:student:title"); ?> (' + studentMembersCount + ')'
                        },
                        subtitle: {
                            text: '<?php echo elgg_echo("gccollab_stats:schoolmessage"); ?>'
                        },
                        xAxis: {
                            type: 'category',
                            startOnTick: true,
                            endOnTick: true,
                            max: studentMembers.length - 1
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:membercount"); ?>'
                            }

                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style=\"font-size:11px\">{series.name}</span><br>',
                            pointFormat: '<span style=\"color:{point.color}\">{point.name}</span>: <b>{point.y}</b> <?php echo elgg_echo("gccollab_stats:users"); ?><br/>'
                        },
                        series: [{
                            name: 'Institution',
                            colorByPoint: true,
                            data: studentMembers
                        }],
                        drilldown: {
                            series: studentMembersDrilldown
                        },
                        colors: ['#7cb5ec', '#f45b5b']
                    });
                });
            });
        </script>
    </div>

    <div class="user-stats" id="federal">

        <div class="chart" id="federalMembers" style="min-height: 1200px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=member.stats&type=federal&lang=' + lang, function (data) {
                    var federalMembers = [];
                    var federalMembersCount = 0;
                    var unknownCount = 0
                    $.each(data.result, function(key, value) {
                        if(key != 'default_invalid_value' && key != ''){
                            federalMembers.push([key.capitalizeFirstLetter(), value]);
                        } else {
                            unknownCount += value;
                        }
                        federalMembersCount += value;
                    });
                    if(unknownCount > 0){ federalMembers.push(['<?php echo elgg_echo('gccollab_stats:unknown'); ?>', unknownCount]); }
                    federalMembers.sort(SortInstitutionByName);

                    Highcharts.chart('federalMembers', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:federal:title"); ?> (' + federalMembersCount + ')'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:membercount"); ?>'
                            }

                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style=\"font-size:11px\">{series.name}</span><br>',
                            pointFormat: '<span style=\"color:{point.color}\">{point.name}</span>: <b>{point.y}</b> <?php echo elgg_echo("gccollab_stats:users"); ?><br/>'
                        },
                        series: [{
                            name: '<?php echo elgg_echo("gccollab_stats:department"); ?>',
                            colorByPoint: true,
                            data: federalMembers
                        }]
                    });
                });
            });
        </script>
    </div>

    <div class="user-stats" id="provincial">

        <div class="chart" id="provincialMembers" style="min-height: 800px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=member.stats&type=provincial&lang=' + lang, function (data) {
                    var provincialMembers = [];
                    var provincialMembersDrilldown = [];
                    var provincialMembersCount = 0;
                    $.each(data.result, function(key, value) {
                        provincialMembers.push({'name': key, 'y': value['total'], 'drilldown': key});
                        provincialMembersCount += value['total'];

                        var provinceData = [];
                        var unknownCount = 0;
                        $.each(value, function(ministry, count){
                            if(ministry != 'total' && ministry != 'default_invalid_value' && ministry != ''){
                                provinceData.push([ministry, count]);
                            } else if(ministry === 'default_invalid_value' || ministry === ''){
                                unknownCount += count;
                            }
                        });
                        if(unknownCount > 0){ provinceData.push(['<?php echo elgg_echo('gccollab_stats:unknown'); ?>', unknownCount]); }
                        provinceData.sort();
                        provincialMembersDrilldown.push({'name': key, 'id': key, 'data': provinceData});
                    });
                    provincialMembers.sort(SortByName);
                    provincialMembersDrilldown.sort(SortByName);

                    Highcharts.chart('provincialMembers', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:provincial:title"); ?> (' + provincialMembersCount + ')'
                        },
                        subtitle: {
                            text: '<?php echo elgg_echo("gccollab_stats:ministrymessage"); ?>'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:membercount"); ?>'
                            }

                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style=\"font-size:11px\">{series.name}</span><br>',
                            pointFormat: '<span style=\"color:{point.color}\">{point.name}</span>: <b>{point.y}</b> <?php echo elgg_echo("gccollab_stats:users"); ?><br/>'
                        },
                        series: [{
                            name: '<?php echo elgg_echo("gccollab_stats:department"); ?>',
                            colorByPoint: true,
                            data: provincialMembers
                        }],
                        drilldown: {
                            series: provincialMembersDrilldown
                        }
                    });
                });
            });
        </script>
    </div>

    <div class="user-stats" id="municipal">
        <div class="chart" id="municipalMembers" style="min-height: 800px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=member.stats&type=municipal&lang=' + lang, function (data) {
                    var municipalMembers = [];
                    var municipalMembersCount = 0
                    $.each(data.result, function(key, value) {
                        if(key != 'total'){
                            municipalMembers.push([key.capitalizeFirstLetter(), value]);
                            municipalMembersCount += value;
                        }
                    });
                    municipalMembers.sort();

                    Highcharts.chart('municipalMembers', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:municipal:title"); ?> (' + municipalMembersCount + ')'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:membercount"); ?>'
                            }

                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style=\"font-size:11px\">{series.name}</span><br>',
                            pointFormat: '<span style=\"color:{point.color}\">{point.name}</span>: <b>{point.y}</b> <?php echo elgg_echo("gccollab_stats:users"); ?><br/>'
                        },
                        series: [{
                            name: '<?php echo elgg_echo("gccollab_stats:organization"); ?>',
                            colorByPoint: true,
                            data: municipalMembers
                        }]
                    });
                });
            });
        </script>
    </div>

    <div class="user-stats" id="international">
        <div class="chart" id="internationalMembers" style="min-height: 800px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=member.stats&type=international&lang=' + lang, function (data) {
                    var internationalMembers = [];
                    var internationalMembersCount = 0
                    $.each(data.result, function(key, value) {
                        if(key != 'total'){
                            internationalMembers.push([key.capitalizeFirstLetter(), value]);
                            internationalMembersCount += value;
                        }
                    });
                    internationalMembers.sort();

                    Highcharts.chart('internationalMembers', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:international:title"); ?> (' + internationalMembersCount + ')'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:membercount"); ?>'
                            }

                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style=\"font-size:11px\">{series.name}</span><br>',
                            pointFormat: '<span style=\"color:{point.color}\">{point.name}</span>: <b>{point.y}</b> <?php echo elgg_echo("gccollab_stats:users"); ?><br/>'
                        },
                        series: [{
                            name: '<?php echo elgg_echo("gccollab_stats:organization"); ?>',
                            colorByPoint: true,
                            data: internationalMembers
                        }]
                    });
                });
            });
        </script>
    </div>

    <div class="user-stats" id="ngo">
        <div class="chart" id="ngoMembers" style="min-height: 800px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=member.stats&type=ngo&lang=' + lang, function (data) {
                    var ngoMembers = [];
                    var ngoMembersCount = 0
                    $.each(data.result, function(key, value) {
                        if(key != 'total'){
                            ngoMembers.push([key.capitalizeFirstLetter(), value]);
                            ngoMembersCount += value;
                        }
                    });
                    ngoMembers.sort();

                    Highcharts.chart('ngoMembers', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:ngo:title"); ?> (' + ngoMembersCount + ')'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:membercount"); ?>'
                            }

                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style=\"font-size:11px\">{series.name}</span><br>',
                            pointFormat: '<span style=\"color:{point.color}\">{point.name}</span>: <b>{point.y}</b> <?php echo elgg_echo("gccollab_stats:users"); ?><br/>'
                        },
                        series: [{
                            name: '<?php echo elgg_echo("gccollab_stats:organization"); ?>',
                            colorByPoint: true,
                            data: ngoMembers
                        }]
                    });
                });
            });
        </script>
    </div>

    <div class="user-stats" id="community">
        <div class="chart" id="communityMembers" style="min-height: 800px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=member.stats&type=community&lang=' + lang, function (data) {
                    var communityMembers = [];
                    var communityMembersCount = 0
                    $.each(data.result, function(key, value) {
                        if(key != 'total'){
                            communityMembers.push([key.capitalizeFirstLetter(), value]);
                            communityMembersCount += value;
                        }
                    });
                    communityMembers.sort();

                    Highcharts.chart('communityMembers', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:community:title"); ?> (' + communityMembersCount + ')'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:membercount"); ?>'
                            }

                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style=\"font-size:11px\">{series.name}</span><br>',
                            pointFormat: '<span style=\"color:{point.color}\">{point.name}</span>: <b>{point.y}</b> <?php echo elgg_echo("gccollab_stats:users"); ?><br/>'
                        },
                        series: [{
                            name: '<?php echo elgg_echo("gccollab_stats:organization"); ?>',
                            colorByPoint: true,
                            data: communityMembers
                        }]
                    });
                });
            });
        </script>
    </div>

    <div class="user-stats" id="business">
        <div class="chart" id="businessMembers" style="min-height: 800px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=member.stats&type=business&lang=' + lang, function (data) {
                    var businessMembers = [];
                    var businessMembersCount = 0
                    $.each(data.result, function(key, value) {
                        if(key != 'total'){
                            businessMembers.push([key.capitalizeFirstLetter(), value]);
                            businessMembersCount += value;
                        }
                    });
                    businessMembers.sort();

                    Highcharts.chart('businessMembers', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:business:title"); ?> (' + businessMembersCount + ')'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:membercount"); ?>'
                            }

                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style=\"font-size:11px\">{series.name}</span><br>',
                            pointFormat: '<span style=\"color:{point.color}\">{point.name}</span>: <b>{point.y}</b> <?php echo elgg_echo("gccollab_stats:users"); ?><br/>'
                        },
                        series: [{
                            name: '<?php echo elgg_echo("gccollab_stats:organization"); ?>',
                            colorByPoint: true,
                            data: businessMembers
                        }]
                    });
                });
            });
        </script>
    </div>

    <div class="user-stats" id="media">
        <div class="chart" id="mediaMembers" style="min-height: 300px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=member.stats&type=media&lang=' + lang, function (data) {
                    var mediaMembers = [];
                    var mediaMembersCount = 0
                    $.each(data.result, function(key, value) {
                        if(key != 'total'){
                            mediaMembers.push([key.capitalizeFirstLetter(), value]);
                            mediaMembersCount += value;
                        }
                    });
                    mediaMembers.sort();

                    Highcharts.chart('mediaMembers', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:media:title"); ?> (' + mediaMembersCount + ')'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:membercount"); ?>'
                            }

                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style=\"font-size:11px\">{series.name}</span><br>',
                            pointFormat: '<span style=\"color:{point.color}\">{point.name}</span>: <b>{point.y}</b> <?php echo elgg_echo("gccollab_stats:users"); ?><br/>'
                        },
                        series: [{
                            name: '<?php echo elgg_echo("gccollab_stats:organization"); ?>',
                            colorByPoint: true,
                            data: mediaMembers
                        }]
                    });
                });
            });
        </script>
    </div>

    <div class="user-stats" id="retired">
        <div class="chart" id="retiredMembers" style="min-height: 1000px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=member.stats&type=retired&lang=' + lang, function (data) {
                    var retiredMembers = [];
                    var retiredMembersCount = 0
                    $.each(data.result, function(key, value) {
                        if(key != 'total'){
                            retiredMembers.push([key.capitalizeFirstLetter(), value]);
                            retiredMembersCount += value;
                        }
                    });
                    retiredMembers.sort();

                    Highcharts.chart('retiredMembers', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:retired:title"); ?> (' + retiredMembersCount + ')'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:membercount"); ?>'
                            }

                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style=\"font-size:11px\">{series.name}</span><br>',
                            pointFormat: '<span style=\"color:{point.color}\">{point.name}</span>: <b>{point.y}</b> <?php echo elgg_echo("gccollab_stats:users"); ?><br/>'
                        },
                        series: [{
                            name: '<?php echo elgg_echo("gccollab_stats:organization"); ?>',
                            colorByPoint: true,
                            data: retiredMembers
                        }]
                    });
                });
            });
        </script>
    </div>

    <div class="user-stats" id="other">

        <div class="chart" id="otherMembers" style="min-height: 1000px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=member.stats&type=other&lang=' + lang, function (data) {
                    var otherMembers = [];
                    var otherMembersCount = 0
                    $.each(data.result, function(key, value) {
                        if(key != 'total'){
                            otherMembers.push([key.capitalizeFirstLetter(), value]);
                            otherMembersCount += value;
                        }
                    });
                    otherMembers.sort();

                    Highcharts.chart('otherMembers', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:other:title"); ?> (' + otherMembersCount + ')'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:membercount"); ?>'
                            }

                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style=\"font-size:11px\">{series.name}</span><br>',
                            pointFormat: '<span style=\"color:{point.color}\">{point.name}</span>: <b>{point.y}</b> <?php echo elgg_echo("gccollab_stats:users"); ?><br/>'
                        },
                        series: [{
                            name: '<?php echo elgg_echo("gccollab_stats:organization"); ?>',
                            colorByPoint: true,
                            data: otherMembers
                        }]
                    });
                });
            });
        </script>
    </div>

    <script>
        $(function () {
            $(".user-stats").not(':eq(0)').hide();

            $(".user-select").change(function(){
                var type = $(this).val();
                $(".user-stats").hide();
                $(".user-stats#" + type).fadeIn();

                setTimeout(function(){
                    $("#registrations").highcharts().reflow();
                    $("#allMembers").highcharts().reflow();
                    $("#federalMembers").highcharts().reflow();
                    $("#studentMembers").highcharts().reflow();
                    $("#academicMembers").highcharts().reflow();
                    $("#provincialMembers").highcharts().reflow();
                    $("#municipalMembers").highcharts().reflow();
                    $("#internationalMembers").highcharts().reflow();
                    $("#ngoMembers").highcharts().reflow();
                    $("#communityMembers").highcharts().reflow();
                    $("#businessMembers").highcharts().reflow();
                    $("#mediaMembers").highcharts().reflow();
                    $("#retiredMembers").highcharts().reflow();
                    $("#otherMembers").highcharts().reflow();
                }, 5);
            });
        });
    </script>

<?php //if( elgg_is_admin_logged_in() ): ?>
    
    <hr />

    <ul id="site-stats-nav" class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#wireposts" aria-controls="wireposts" role="tab" data-toggle="tab"><?php echo elgg_echo("gccollab_stats:wireposts:title"); ?></a></li>
        <li role="presentation"><a href="#blogposts" aria-controls="blogposts" role="tab" data-toggle="tab"><?php echo elgg_echo("gccollab_stats:blogposts:title"); ?></a></li>
        <li role="presentation"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab"><?php echo elgg_echo("gccollab_stats:comments:title"); ?></a></li>
        <li role="presentation"><a href="#groupscreated" aria-controls="groupscreated" role="tab" data-toggle="tab"><?php echo elgg_echo("gccollab_stats:groupscreated:title"); ?></a></li>
        <li role="presentation"><a href="#groupsjoined" aria-controls="groupsjoined" role="tab" data-toggle="tab"><?php echo elgg_echo("gccollab_stats:groupsjoined:title"); ?></a></li>
        <li role="presentation"><a href="#likes" aria-controls="likes" role="tab" data-toggle="tab"><?php echo elgg_echo("gccollab_stats:likes:title"); ?></a></li>
        <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><?php echo elgg_echo("gccollab_stats:messages:title"); ?></a></li>
        <li role="presentation"><a href="#optins" aria-controls="optins" role="tab" data-toggle="tab"><?php echo elgg_echo("gccollab_stats:optins:title"); ?></a></li>
    </ul>

    <div class="tab-content" style="width: 100%; max-width:100%;">
        <div role="tabpanel" class="tab-pane active" id="wireposts">

        <div class="chart" id="wirepostsChart" style="min-height: 350px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=site.stats&type=wireposts&lang=' + lang, function (data) {
                    var dates = {};
                    var wireposts = [];
                    $.each(data.result, function(key, value){
                        var date = new Date(value[0] * 1000);
                        date.setHours(0, 0, 0, 0);
                        var dateString = date.getTime();
                        dates[dateString] = (dates[dateString] ? dates[dateString] + 1 : 1);
                    });
                    $.each(dates, function(key, value){
                        key = parseInt(key);
                        wireposts.push([key, value, new Date(key).niceDate()]);
                    });
                    wireposts.sort();

                    Highcharts.chart('wirepostsChart', {
                        chart: {
                            zoomType: 'x'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:wireposts:title"); ?>'
                        },
                        subtitle: {
                            text: document.ontouchstart === undefined ? '<?php echo elgg_echo("gccollab_stats:zoommessage"); ?>' : '<?php echo elgg_echo("gccollab_stats:pinchmessage"); ?>'
                        },
                        xAxis: {
                            type: 'datetime'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:wireposts:amount"); ?>'
                            },
                            min: 0
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            area: {
                                fillColor: {
                                    linearGradient: {
                                        x1: 0,
                                        y1: 0,
                                        x2: 0,
                                        y2: 1
                                    },
                                    stops: [
                                        [0, Highcharts.getOptions().colors[0]],
                                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                                    ]
                                },
                                marker: {
                                    radius: 2
                                },
                                lineWidth: 1,
                                states: {
                                    hover: {
                                        lineWidth: 1
                                    }
                                },
                                threshold: null
                            }
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b><?php echo elgg_echo("gccollab_stats:date"); ?></b> ' + wireposts[this.series.data.indexOf(this.point)][2] + '<br /><b><?php echo elgg_echo("gccollab_stats:total"); ?></b> ' + wireposts[this.series.data.indexOf(this.point)][1];
                            }
                        },
                        series: [{
                            type: 'area',
                            name: '<?php echo elgg_echo("gccollab_stats:wireposts:title"); ?>',
                            data: wireposts
                        }]
                    });
                });
            });
        </script>
        </div>

        <div role="tabpanel" class="tab-pane" id="blogposts">
        
        <div class="chart" id="blogpostsChart" style="min-height: 350px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=site.stats&type=blogposts&lang=' + lang, function (data) {
                    var dates = {};
                    var blogposts = [];
                    $.each(data.result, function(key, value){
                        var date = new Date(value[0] * 1000);
                        date.setHours(0, 0, 0, 0);
                        var dateString = date.getTime();
                        dates[dateString] = (dates[dateString] ? dates[dateString] + 1 : 1);
                    });
                    $.each(dates, function(key, value){
                        key = parseInt(key);
                        blogposts.push([key, value, new Date(key).niceDate()]);
                    });
                    blogposts.sort();

                    Highcharts.chart('blogpostsChart', {
                        chart: {
                            zoomType: 'x'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:blogposts:title"); ?>'
                        },
                        subtitle: {
                            text: document.ontouchstart === undefined ? '<?php echo elgg_echo("gccollab_stats:zoommessage"); ?>' : '<?php echo elgg_echo("gccollab_stats:pinchmessage"); ?>'
                        },
                        xAxis: {
                            type: 'datetime'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:blogposts:amount"); ?>'
                            },
                            min: 0
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            area: {
                                fillColor: {
                                    linearGradient: {
                                        x1: 0,
                                        y1: 0,
                                        x2: 0,
                                        y2: 1
                                    },
                                    stops: [
                                        [0, Highcharts.getOptions().colors[0]],
                                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                                    ]
                                },
                                marker: {
                                    radius: 2
                                },
                                lineWidth: 1,
                                states: {
                                    hover: {
                                        lineWidth: 1
                                    }
                                },
                                threshold: null
                            }
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b><?php echo elgg_echo("gccollab_stats:date"); ?></b> ' + blogposts[this.series.data.indexOf(this.point)][2] + '<br /><b><?php echo elgg_echo("gccollab_stats:total"); ?></b> ' + blogposts[this.series.data.indexOf(this.point)][1];
                            }
                        },
                        series: [{
                            type: 'area',
                            name: '<?php echo elgg_echo("gccollab_stats:blogposts:title"); ?>',
                            data: blogposts
                        }]
                    });
                });
            });
        </script>
        </div>

        <div role="tabpanel" class="tab-pane" id="comments">

        <div class="chart" id="commentsChart" style="min-height: 350px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=site.stats&type=comments&lang=' + lang, function (data) {
                    var dates = {};
                    var comments = [];
                    $.each(data.result, function(key, value){
                        var date = new Date(value[0] * 1000);
                        date.setHours(0, 0, 0, 0);
                        var dateString = date.getTime();
                        dates[dateString] = (dates[dateString] ? dates[dateString] + 1 : 1);
                    });
                    $.each(dates, function(key, value){
                        key = parseInt(key);
                        comments.push([key, value, new Date(key).niceDate()]);
                    });
                    comments.sort();

                    Highcharts.chart('commentsChart', {
                        chart: {
                            zoomType: 'x'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:comments:title"); ?>'
                        },
                        subtitle: {
                            text: document.ontouchstart === undefined ? '<?php echo elgg_echo("gccollab_stats:zoommessage"); ?>' : '<?php echo elgg_echo("gccollab_stats:pinchmessage"); ?>'
                        },
                        xAxis: {
                            type: 'datetime'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:comments:amount"); ?>'
                            },
                            min: 0
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            area: {
                                fillColor: {
                                    linearGradient: {
                                        x1: 0,
                                        y1: 0,
                                        x2: 0,
                                        y2: 1
                                    },
                                    stops: [
                                        [0, Highcharts.getOptions().colors[0]],
                                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                                    ]
                                },
                                marker: {
                                    radius: 2
                                },
                                lineWidth: 1,
                                states: {
                                    hover: {
                                        lineWidth: 1
                                    }
                                },
                                threshold: null
                            }
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b><?php echo elgg_echo("gccollab_stats:date"); ?></b> ' + comments[this.series.data.indexOf(this.point)][2] + '<br /><b><?php echo elgg_echo("gccollab_stats:total"); ?></b> ' + comments[this.series.data.indexOf(this.point)][1];
                            }
                        },
                        series: [{
                            type: 'area',
                            name: '<?php echo elgg_echo("gccollab_stats:comments:title"); ?>',
                            data: comments
                        }]
                    });
                });
            });
        </script>
        </div>

        <div role="tabpanel" class="tab-pane" id="groupscreated">

        <div class="chart" id="groupscreatedChart" style="min-height: 350px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=site.stats&type=groupscreated&lang=' + lang, function (data) {
                    var dates = {};
                    var groupscreated = [];
                    $.each(data.result, function(key, value){
                        var date = new Date(value[0] * 1000);
                        date.setHours(0, 0, 0, 0);
                        var dateString = date.getTime();
                        if(!dates[dateString]){ dates[dateString] = {}; }
                        dates[dateString].count = (dates[dateString].count ? dates[dateString].count + 1 : 1);
                    });
                    $.each(dates, function(key, value){
                        key = parseInt(key);
                        groupscreated.push([key, value.count, new Date(key).niceDate()]);
                    });
                    groupscreated.sort();

                    Highcharts.chart('groupscreatedChart', {
                        chart: {
                            zoomType: 'x'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:groupscreated:title"); ?>'
                        },
                        subtitle: {
                            text: document.ontouchstart === undefined ? '<?php echo elgg_echo("gccollab_stats:zoommessage"); ?>' : '<?php echo elgg_echo("gccollab_stats:pinchmessage"); ?>'
                        },
                        xAxis: {
                            type: 'datetime'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:groupscreated:amount"); ?>'
                            },
                            min: 0
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            area: {
                                fillColor: {
                                    linearGradient: {
                                        x1: 0,
                                        y1: 0,
                                        x2: 0,
                                        y2: 1
                                    },
                                    stops: [
                                        [0, Highcharts.getOptions().colors[0]],
                                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                                    ]
                                },
                                marker: {
                                    radius: 2
                                },
                                lineWidth: 1,
                                states: {
                                    hover: {
                                        lineWidth: 1
                                    }
                                },
                                threshold: null
                            }
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b><?php echo elgg_echo("gccollab_stats:date"); ?></b> ' + groupscreated[this.series.data.indexOf(this.point)][2] + '<br /><b><?php echo elgg_echo("gccollab_stats:total"); ?></b> ' + groupscreated[this.series.data.indexOf(this.point)][1];
                            }
                        },
                        series: [{
                            type: 'area',
                            name: '<?php echo elgg_echo("gccollab_stats:groupscreated:title"); ?>',
                            data: groupscreated
                        }]
                    });
                });
            });
        </script>
        </div>

        <div role="tabpanel" class="tab-pane" id="groupsjoined">

        <div class="chart" id="groupsjoinedChart" style="min-height: 350px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=site.stats&type=groupsjoined&lang=' + lang, function (data) {
                    var dates = {};
                    var groupsjoined = [];
                    $.each(data.result, function(key, value){
                        var date = new Date(value[0] * 1000);
                        date.setHours(0, 0, 0, 0);
                        var dateString = date.getTime();
                        dates[dateString] = (dates[dateString] ? dates[dateString] + 1 : 1);
                    });
                    $.each(dates, function(key, value){
                        key = parseInt(key);
                        groupsjoined.push([key, value, new Date(key).niceDate()]);
                    });
                    groupsjoined.sort();

                    Highcharts.chart('groupsjoinedChart', {
                        chart: {
                            zoomType: 'x'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:groupsjoined:title"); ?>'
                        },
                        subtitle: {
                            text: document.ontouchstart === undefined ? '<?php echo elgg_echo("gccollab_stats:zoommessage"); ?>' : '<?php echo elgg_echo("gccollab_stats:pinchmessage"); ?>'
                        },
                        xAxis: {
                            type: 'datetime'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:groupsjoined:amount"); ?>'
                            },
                            min: 0
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            area: {
                                fillColor: {
                                    linearGradient: {
                                        x1: 0,
                                        y1: 0,
                                        x2: 0,
                                        y2: 1
                                    },
                                    stops: [
                                        [0, Highcharts.getOptions().colors[0]],
                                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                                    ]
                                },
                                marker: {
                                    radius: 2
                                },
                                lineWidth: 1,
                                states: {
                                    hover: {
                                        lineWidth: 1
                                    }
                                },
                                threshold: null
                            }
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b><?php echo elgg_echo("gccollab_stats:date"); ?></b> ' + groupsjoined[this.series.data.indexOf(this.point)][2] + '<br /><b><?php echo elgg_echo("gccollab_stats:total"); ?></b> ' + groupsjoined[this.series.data.indexOf(this.point)][1];
                            }
                        },
                        series: [{
                            type: 'area',
                            name: '<?php echo elgg_echo("gccollab_stats:groupsjoined:title"); ?>',
                            data: groupsjoined
                        }]
                    });
                });
            });
        </script>
        </div>

        <div role="tabpanel" class="tab-pane" id="likes">

        <div class="chart" id="likesChart" style="min-height: 350px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=site.stats&type=likes&lang=' + lang, function (data) {
                    var dates = {};
                    var likes = [];
                    $.each(data.result, function(key, value){
                        var date = new Date(value[0] * 1000);
                        date.setHours(0, 0, 0, 0);
                        var dateString = date.getTime();
                        dates[dateString] = (dates[dateString] ? dates[dateString] + 1 : 1);
                    });
                    $.each(dates, function(key, value){
                        key = parseInt(key);
                        likes.push([key, value, new Date(key).niceDate()]);
                    });
                    likes.sort();

                    Highcharts.chart('likesChart', {
                        chart: {
                            zoomType: 'x'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:likes:title"); ?>'
                        },
                        subtitle: {
                            text: document.ontouchstart === undefined ? '<?php echo elgg_echo("gccollab_stats:zoommessage"); ?>' : '<?php echo elgg_echo("gccollab_stats:pinchmessage"); ?>'
                        },
                        xAxis: {
                            type: 'datetime'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:likes:amount"); ?>'
                            },
                            min: 0
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            area: {
                                fillColor: {
                                    linearGradient: {
                                        x1: 0,
                                        y1: 0,
                                        x2: 0,
                                        y2: 1
                                    },
                                    stops: [
                                        [0, Highcharts.getOptions().colors[0]],
                                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                                    ]
                                },
                                marker: {
                                    radius: 2
                                },
                                lineWidth: 1,
                                states: {
                                    hover: {
                                        lineWidth: 1
                                    }
                                },
                                threshold: null
                            }
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b><?php echo elgg_echo("gccollab_stats:date"); ?></b> ' + likes[this.series.data.indexOf(this.point)][2] + '<br /><b><?php echo elgg_echo("gccollab_stats:total"); ?></b> ' + likes[this.series.data.indexOf(this.point)][1];
                            }
                        },
                        series: [{
                            type: 'area',
                            name: '<?php echo elgg_echo("gccollab_stats:likes:title"); ?>',
                            data: likes
                        }]
                    });
                });
            });
        </script>
        </div>

        <div role="tabpanel" class="tab-pane" id="messages">

        <div class="chart" id="messagesChart" style="min-height: 350px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=site.stats&type=messages&lang=' + lang, function (data) {
                    var dates = {};
                    var messages = [];
                    $.each(data.result, function(key, value){
                        var date = new Date(value[0] * 1000);
                        date.setHours(0, 0, 0, 0);
                        var dateString = date.getTime();
                        dates[dateString] = (dates[dateString] ? dates[dateString] + 1 : 1);
                    });
                    $.each(dates, function(key, value){
                        key = parseInt(key);
                        messages.push([key, value, new Date(key).niceDate()]);
                    });
                    messages.sort();

                    Highcharts.chart('messagesChart', {
                        chart: {
                            zoomType: 'x'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:messages:title"); ?>'
                        },
                        subtitle: {
                            text: document.ontouchstart === undefined ? '<?php echo elgg_echo("gccollab_stats:zoommessage"); ?>' : '<?php echo elgg_echo("gccollab_stats:pinchmessage"); ?>'
                        },
                        xAxis: {
                            type: 'datetime'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:messages:amount"); ?>'
                            },
                            min: 0
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            area: {
                                fillColor: {
                                    linearGradient: {
                                        x1: 0,
                                        y1: 0,
                                        x2: 0,
                                        y2: 1
                                    },
                                    stops: [
                                        [0, Highcharts.getOptions().colors[0]],
                                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                                    ]
                                },
                                marker: {
                                    radius: 2
                                },
                                lineWidth: 1,
                                states: {
                                    hover: {
                                        lineWidth: 1
                                    }
                                },
                                threshold: null
                            }
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b><?php echo elgg_echo("gccollab_stats:date"); ?></b> ' + messages[this.series.data.indexOf(this.point)][2] + '<br /><b><?php echo elgg_echo("gccollab_stats:total"); ?></b> ' + messages[this.series.data.indexOf(this.point)][1];
                            }
                        },
                        series: [{
                            type: 'area',
                            name: '<?php echo elgg_echo("gccollab_stats:messages:title"); ?>',
                            data: messages
                        }]
                    });
                });
            });
        </script>
        </div>

        <div role="tabpanel" class="tab-pane" id="optins">

        <div class="chart" id="optinsChart" style="min-height: 350px;"><span class="loading"><?php echo elgg_echo("gccollab_stats:loading"); ?></span></div>

        <script>
            $(function () {
                $.getJSON(siteUrl + 'services/api/rest/json/?method=site.stats&type=optins&lang=' + lang, function (data) {
                    var optins = [];
                    $.each(data.result, function(key, value){
                        optins.push([key, value]);
                    });
                    optins.sort();

                    Highcharts.chart('optinsChart', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: '<?php echo elgg_echo("gccollab_stats:optins:title"); ?>'
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: '<?php echo elgg_echo("gccollab_stats:optins:amount"); ?>'
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}'
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style=\"font-size:11px\">{series.name}</span><br>',
                            pointFormat: '<span style=\"color:{point.color}\">{point.name}</span>: <b>{point.y}</b> <?php echo elgg_echo("gccollab_stats:users"); ?><br/>'
                        },
                        series: [{
                            name: '<?php echo elgg_echo("gccollab_stats:optins:title"); ?>',
                            colorByPoint: true,
                            data: optins
                        }]
                    });
                });
            });
        </script>
        </div>

    </div>

    <script>
        $(function () {
            $("#site-stats-nav li a").click(function() {
                setTimeout(function(){
                    $("#wirepostsChart").highcharts().reflow();
                    $("#blogpostsChart").highcharts().reflow();
                    $("#commentsChart").highcharts().reflow();
                    $("#groupscreatedChart").highcharts().reflow();
                    $("#groupsjoinedChart").highcharts().reflow();
                    $("#likesChart").highcharts().reflow();
                    $("#messagesChart").highcharts().reflow();
                    $("#optinsChart").highcharts().reflow();
                }, 5);
            });
        });
    </script>

<?php //endif; ?>

    <?php

        $display = ob_get_clean();

        return $display;
    }
