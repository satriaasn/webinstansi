@extends('layouts.backend')
@section('title', 'Dashboard')

@section('content')
    <div class="br-pagetitle">
        <i class="icon ion-ios-home-outline"></i>
        <div>
            <h4>Dashboard</h4>
            <p class="mg-b-0">Welcome to {{ getSetting('web_name') }}</p>
        </div>
    </div>

    <div class="br-pagebody">
        <div class="alert alert-info alert-bordered pd-y-20" role="alert">
            <div class="d-sm-flex align-items-center justify-content-start">
                <i class="icon ion-ios-home alert-icon tx-52 mg-r-20"></i>
                <div class="mg-t-20 mg-sm-t-0">
                    <h5 class="mg-b-2">Hola Welcome!</h5>
                    <p class="mg-b-0 tx-gray">Welcome {{ Auth::user()->name }} to {{ getSetting('web_name') }}, please
                        select menu beside for management your system.</p>
                </div>
            </div>
        </div>

        <div class="row row-sm">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-info rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-ios-bookmarks-outline tx-60 lh-0 tx-white op-7"></i>
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Posts</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">{{ $cposts }}</p>
                            <span class="tx-11 tx-roboto tx-white-8">Total</span>
                        </div>
                    </div>
                    <div id="ch1" class="ht-50 tr-y-1"></div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
                <div class="bg-purple rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-ios-photos-outline tx-60 lh-0 tx-white op-7"></i>
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Pages</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">{{ $cpages }}</p>
                            <span class="tx-11 tx-roboto tx-white-8">Total</span>
                        </div>
                    </div>
                    <div id="ch3" class="ht-50 tr-y-1"></div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                <div class="bg-teal rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-ios-calendar-outline tx-60 lh-0 tx-white op-7"></i>
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Agenda</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">{{ $cagendas }}</p>
                            <span class="tx-11 tx-roboto tx-white-8">Total</span>
                        </div>
                    </div>
                    <div id="ch2" class="ht-50 tr-y-1"></div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                <div class="bg-primary rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-ios-download-outline tx-60 lh-0 tx-white op-7"></i>
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">
                                Download</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">{{ $cdownloads }}</p>
                            <span class="tx-11 tx-roboto tx-white-8">Total</span>
                        </div>
                    </div>
                    <div id="ch4" class="ht-50 tr-y-1"></div>
                </div>
            </div>
        </div>

        <div class="row row-sm mg-t-20">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-purple rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-images tx-60 lh-0 tx-white op-7"></i>
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">
                                Gallery</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">{{ $cgallerys }}</p>
                            <span class="tx-11 tx-roboto tx-white-8">Total</span>
                        </div>
                    </div>
                    <div id="ch5" class="ht-50 tr-y-1"></div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
                <div class="bg-info rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-ios-briefcase-outline tx-60 lh-0 tx-white op-7"></i>
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Album</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">{{ $calbums }}</p>
                            <span class="tx-11 tx-roboto tx-white-8">Total</span>
                        </div>
                    </div>
                    <div id="ch7" class="ht-50 tr-y-1"></div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                <div class="bg-primary rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-ios-play-outline tx-60 lh-0 tx-white op-7"></i>
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Video</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">{{ $cvideos }}</p>
                            <span class="tx-11 tx-roboto tx-white-8">Total</span>
                        </div>
                    </div>
                    <div id="ch6" class="ht-50 tr-y-1"></div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                <div class="bg-teal rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-ios-email-outline tx-60 lh-0 tx-white op-7"></i>
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">
                                Contact</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">{{ $ccontacts }}</p>
                            <span class="tx-11 tx-roboto tx-white-8">Total</span>
                        </div>
                    </div>
                    <div id="ch8" class="ht-50 tr-y-1"></div>
                </div>
            </div>


        </div>
        @if(env('G_ANAL_MEASUREMENT_ID'))
            <div class="row mt-3">
                <div class="col-12">

                    <div class="alert alert-success alert-bordered pd-y-20" role="alert">
                        <div class="d-sm-flex align-items-center justify-content-start">
                            <i class="icon ion-social-google alert-icon tx-52 mg-r-20"></i>
                            <div class="mg-t-20 mg-sm-t-0">
                                <h5 class="mg-b-2">Google Analytics Dashboard</h5>

                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 mb-4">
                        <form id="filter-form" class="d-flex">
                            <input type="date" name="start_date" id="start_date" class="form-control me-2"
                                   value="{{ now()->startOfMonth()->format('Y-m-d') }}">
                            <input type="date" name="end_date" id="end_date" class="form-control me-2"
                                   value="{{ now()->endOfMonth()->format('Y-m-d') }}">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>

                <div class="col-12 text-center">
                    <div id="loading-indicator" class="spinner-border text-primary ms-3" role="status"
                         style="display:none;">
                        <div class="alert alert-primary" role="alert">
                            Loading...
                        </div>
                    </div>

                </div>

                <div class="col-md-6" style="max-height: 500px; overflow-y: auto">
                    <div class="container py-5">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        Total Visitors and Pageviews
                                    </div>
                                    <div class="card-body">
                                        <div id="chart-visitors-pageviews"></div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header">
                                        User Types
                                    </div>
                                    <div class="card-body">
                                        <div id="chart-user-types"></div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header">
                                        Top Browsers
                                    </div>
                                    <div class="card-body">
                                        <div id="chart-top-browsers"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="max-height: 500px; overflow-y: auto">
                    <div class="container py-5">
                        <div class="row">
                            <div class="col-12">
                                <div id="visitors-pageviews-container" class="card mb-3"></div>
                            </div>
                            <div class="col-12">
                                <div id="most-visited-container" class="card mb-3"></div>
                            </div>
                            <div class="col-12">
                                <div id="top-referrers-container" class="card mb-3"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>

@endsection

@push('scripts')
    <script src="{{ callassetspath('backend/lib/d3/d3.js') }}"></script>
    <script src="{{ callassetspath('backend/lib/rickshaw/rickshaw.min.js') }}"></script>
    <script src="{{ callassetspath('backend/js/ResizeSensor.js') }}"></script>
    <script src="{{ callassetspath('backend/js/dashboard.js') }}"></script>
    @if(env('G_ANAL_MEASUREMENT_ID'))
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/data.js"></script>
        <script>
            function formatDate(dateString) {
                const dateObj = new Date(dateString);
                const day = String(dateObj.getDate()).padStart(2, '0');
                const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                const year = dateObj.getFullYear();
                return `${day}-${month}-${year}`;
            }

            function fetchAndRenderCharts(startDate, endDate) {
                const loadingIndicator = document.getElementById('loading-indicator');
                loadingIndicator.style.display = 'block';
                fetch('{{ route('analytics.data') }}?' + new URLSearchParams({
                    start_date: startDate,
                    end_date: endDate
                }))
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const totalVisitorsAndPageViews = data.totalVisitorsAndPageViews;
                        totalVisitorsAndPageViews.sort((a, b) => new Date(a.date) - new Date(b.date));
                        Highcharts.chart('chart-visitors-pageviews', {
                            chart: {type: 'line'},
                            title: {text: 'Visitors and Page Views Over Time'},
                            xAxis: {categories: totalVisitorsAndPageViews.map(item => formatDate(item.date))},
                            yAxis: {title: {text: 'Count'}},
                            series: [{
                                name: 'Visitors',
                                data: totalVisitorsAndPageViews.map(item => item.activeUsers)
                            }, {
                                name: 'Page Views',
                                data: totalVisitorsAndPageViews.map(item => item.screenPageViews)
                            }]
                        });
                        const userTypesData = data.userTypes.map(item => ({
                            name: item.newVsReturning,
                            y: item.activeUsers
                        }));
                        Highcharts.chart('chart-user-types', {
                            chart: {type: 'pie'},
                            title: {text: 'User Types'},
                            series: [{
                                name: 'Active Users',
                                colorByPoint: true,
                                data: userTypesData
                            }]
                        });
                        const topBrowsersData = data.topBrowsers;
                        Highcharts.chart('chart-top-browsers', {
                            chart: {type: 'bar'},
                            title: {text: 'Top Browsers'},
                            xAxis: {
                                categories: topBrowsersData.map(item => item.browser),
                                title: {text: null}
                            },
                            yAxis: {min: 0, title: {text: 'Page Views'}},
                            series: [{
                                name: 'Page Views',
                                data: topBrowsersData.map(item => item.screenPageViews)
                            }]
                        });
                        document.getElementById('visitors-pageviews-container').innerHTML = '';
                        document.getElementById('most-visited-container').innerHTML = '';
                        document.getElementById('top-referrers-container').innerHTML = '';
                        renderTable('visitors-pageviews-container', 'Visitors and Page Views', data.visitorsAndPageViews, [
                            {header: 'No.', key: null, isIndex: true},
                            {header: 'Page', key: 'pageTitle'},
                            {header: 'Active Users', key: 'activeUsers'},
                            {header: 'Page views', key: 'screenPageViews'}
                        ]);
                        renderTable('most-visited-container', 'Most Visited Pages', data.mostVisitedPages, [
                            {header: 'No.', key: null, isIndex: true},
                            {header: 'Page', key: 'pageTitle'},
                            {header: 'URL', key: 'fullPageUrl'},
                            {header: 'Page views', key: 'screenPageViews'}
                        ]);
                        renderTable('top-referrers-container', 'Top Referrers', data.topReferrers, [
                            {header: 'No.', key: null, isIndex: true},
                            {header: 'Page Referrer', key: 'pageReferrer'},
                            {header: 'Page views', key: 'screenPageViews'}
                        ]);
                    })
                    .catch(error => {
                        console.error('Ada kesalahan saat mengambil data:', error);
                    })
                    .finally(() => {
                        loadingIndicator.style.display = 'none';
                    });
            }

            function renderTable(containerId, title, data, columns) {
                const container = document.getElementById(containerId);
                let tableHTML = `
                <div class="card-header">
                    ${title}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    ${columns.map(col => `<th style="width: ${col.isIndex ? '5%' : 'auto'}">${col.header}</th>`).join('')}
                                </tr>
                            </thead>
                            <tbody>
                                ${data.map((row, index) => `
                                    <tr>
                                        <td>${index + 1}</td>
                                        ${columns.map(col => col.key ? `<td>${row[col.key] || ''}</td>` : '').join('')}
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
                container.innerHTML = tableHTML;
            }

            document.addEventListener('DOMContentLoaded', function () {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                fetchAndRenderCharts(startDate, endDate);
            });

            document.getElementById('filter-form').addEventListener('submit', function (event) {
                event.preventDefault();
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                fetchAndRenderCharts(startDate, endDate);
            });
        </script>
    @endif
@endpush
