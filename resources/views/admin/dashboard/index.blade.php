@extends('admin.default')

@section('content')

    <div class="row gap-20 masonry pos-r">
        <div class="masonry-sizer col-md-6"></div>
        <div class="masonry-item  w-100">
            <div class="row gap-20">
                <!-- #Toatl Visits ==================== -->
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Users</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <span id="sparklinedash"></span>
                                </div>
                                <div class="peer">
                                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500">{{$user}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- #Total Page Views ==================== -->
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Lembaga Survey</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <span id="sparklinedash2"></span>
                                </div>
                                <div class="peer">
                                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-red-50 c-red-500">{{$lembaga}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- #Unique Visitors ==================== -->
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Pemilihan</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <span id="sparklinedash3"></span>
                                </div>
                                <div class="peer">
                                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-purple-50 c-purple-500">{{$pemilihan}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- #Bounce Rate ==================== -->
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">TPS</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <span id="sparklinedash4"></span>
                                </div>
                                <div class="peer">
                                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500">{{$tps}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--<div class="masonry-item col-12">-->
            <!-- #Site Visits ====================
            <div class="bd bgc-white">
                <div class="peers fxw-nw@lg+ ai-s">
                    <div class="peer peer-greed w-70p@lg+ w-100@lg- p-20">
                        <div class="layers">
                            <div class="layer w-100 mB-10">
                                <h6 class="lh-1">Site Visits</h6>
                            </div>
                            <div class="layer w-100">
                                <div id="world-map-marker"></div>
                            </div>
                        </div>
                    </div>
                    <div class="peer bdL p-20 w-30p@lg+ w-100p@lg-">
                        <div class="layers">
                            <div class="layer w-100">
                                <!-- Progress Bars 
                                <div class="layers">
                                    <div class="layer w-100">
                                        <h5 class="mB-5">100k</h5>
                                        <small class="fw-600 c-grey-700">Visitors From USA</small>
                                        <span class="pull-right c-grey-600 fsz-sm">50%</span>
                                        <div class="progress mT-10">
                                            <div class="progress-bar bgc-deep-purple-500" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%;"> <span class="sr-only">50% Complete</span></div>
                                        </div>
                                    </div>
                                    <div class="layer w-100 mT-15">
                                        <h5 class="mB-5">1M</h5>
                                        <small class="fw-600 c-grey-700">Visitors From Europe</small>
                                        <span class="pull-right c-grey-600 fsz-sm">80%</span>
                                        <div class="progress mT-10">
                                            <div class="progress-bar bgc-green-500" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:80%;"> <span class="sr-only">80% Complete</span></div>
                                        </div>
                                    </div>
                                    <div class="layer w-100 mT-15">
                                        <h5 class="mB-5">450k</h5>
                                        <small class="fw-600 c-grey-700">Visitors From Australia</small>
                                        <span class="pull-right c-grey-600 fsz-sm">40%</span>
                                        <div class="progress mT-10">
                                            <div class="progress-bar bgc-light-blue-500" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:40%;"> <span class="sr-only">40% Complete</span></div>
                                        </div>
                                    </div>
                                    <div class="layer w-100 mT-15">
                                        <h5 class="mB-5">1B</h5>
                                        <small class="fw-600 c-grey-700">Visitors From India</small>
                                        <span class="pull-right c-grey-600 fsz-sm">90%</span>
                                        <div class="progress mT-10">
                                            <div class="progress-bar bgc-blue-grey-500" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:90%;"> <span class="sr-only">90% Complete</span></div>
                                        </div>
                                    </div>
                                </div>-->

                                <!-- Pie Charts -->
                                <!--<div class="peers pT-20 mT-20 bdT fxw-nw@lg+ jc-sb ta-c gap-10">
                                    <div class="peer">
                                        <div class="easy-pie-chart" data-size='80' data-percent="75" data-bar-color='#f44336'>
                                            <span></span>
                                        </div>
                                        <h6 class="fsz-sm">New Users</h6>
                                    </div>
                                    <div class="peer">
                                        <div class="easy-pie-chart" data-size='80' data-percent="50" data-bar-color='#2196f3'>
                                            <span></span>
                                        </div>
                                        <h6 class="fsz-sm">New Purchases</h6>
                                    </div>
                                    <div class="peer">
                                        <div class="easy-pie-chart" data-size='80' data-percent="90" data-bar-color='#ff9800'>
                                            <span></span>
                                        </div>
                                        <h6 class="fsz-sm">Bounce Rate</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        
                    <!-- Today Weather Extended -->
                   <!-- <div class="layer w-100 mY-30">
                        <div class="layers bdB">
                            <div class="layer w-100 bdT pY-5">
                                <div class="peers ai-c jc-sb fxw-nw">
                                    <div class="peer">
                                        <span>Wind</span>
                                    </div>
                                    <div class="peer ta-r">
                                        <span class="fw-600 c-grey-800">10km/h</span>
                                    </div>
                                </div>
                            </div>
                            <div class="layer w-100 bdT pY-5">
                                <div class="peers ai-c jc-sb fxw-nw">
                                    <div class="peer">
                                        <span>Sunrise</span>
                                    </div>
                                    <div class="peer ta-r">
                                        <span class="fw-600 c-grey-800">05:00 AM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="layer w-100 bdT pY-5">
                                <div class="peers ai-c jc-sb fxw-nw">
                                    <div class="peer">
                                        <span>Pressure</span>
                                    </div>
                                    <div class="peer ta-r">
                                        <span class="fw-600 c-grey-800">1B</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->

                    <!-- Week Forecast -->
                    <!--<div class="layer w-100">
                        <div class="peers peers-greed ai-fs ta-c">
                            <div class="peer">
                                <h6 class="mB-10">MON</h6>
                                <canvas class="sleet" width="30" height="30"></canvas>
                                <span class="d-b fw-600">32<sup>°F</sup>
                            </div>
                            <div class="peer">
                                <h6 class="mB-10">TUE</h6>
                                <canvas class="clear-day" width="30" height="30"></canvas>
                                <span class="d-b fw-600">30<sup>°F</sup>
                            </div>
                            <div class="peer">
                                <h6 class="mB-10">WED</h6>
                                <canvas class="partly-cloudy-day" width="30" height="30"></canvas>
                                <span class="d-b fw-600">28<sup>°F</sup>
                            </div>
                            <div class="peer">
                                <h6 class="mB-10">THR</h6>
                                <canvas class="cloudy" width="30" height="30"></canvas>
                                <span class="d-b fw-600">32<sup>°F</sup>
                            </div>
                            <div class="peer">
                                <h6 class="mB-10">FRI</h6>
                                <canvas class="snow" width="30" height="30"></canvas>
                                <span class="d-b fw-600">24<sup>°F</sup>
                            </div>
                            <div class="peer">
                                <h6 class="mB-10">SAT</h6>
                                <canvas class="wind" width="30" height="30"></canvas>
                                <span class="d-b fw-600">28<sup>°F</sup>
                            </div>
                            <div class="peer">
                                <h6 class="mB-10">SUN</h6>
                                <canvas class="sleet" width="30" height="30"></canvas>
                                <span class="d-b fw-600">32<sup>°F</sup>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        
                           
                </div>
            </div>
        </div>
    </div>

@endsection