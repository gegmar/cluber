@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.projects'))

@section('nav-link', route('supervision.dashboard'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active">{{__('ticketshop.dashboard')}}</li>
    </ul>
</div><!-- Dashboard Counts Section-->
<section class="dashboard-counts no-padding-bottom">
    <div class="container-fluid">
        <div class="row bg-white has-shadow">
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="icon bg-violet"><i class="fa fa-calendar"></i></div>
                    <div class="title"><span>@lang('ticketshop.events-total')</span></div>
                    <div class="number"><strong>{{ $totalEvents }}</strong></div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="icon bg-red"><i class="fa fa-bar-chart"></i></div>
                    <div class="title"><span>@lang('ticketshop.load')</span></div>
                    <div class="number"><strong>{{ $load }}%</strong></div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="icon bg-green"><i class="icon-bill"></i></div>
                    <div class="title"><span>@lang('ticketshop.number-sales')</span></div>
                    <div class="number"><strong>{{ $totalSales }}</strong></div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="icon bg-orange"><i class="icon-check"></i></div>
                    <div class="title"><span>@lang('ticketshop.total-turnover')</span>
                    </div>
                    <div class="number"><strong>{{ $turnover }} <i class="fa fa-eur"></i></strong></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Projects Section-->
<section class="projects">
    <div class="container-fluid">
        <!-- Projects-->
        @foreach($projects as $project)
        <div class="project">
            <div class="row bg-white has-shadow">
                <div class="left-col col-lg-6 d-flex align-items-center justify-content-between">
                    <div class="project-title d-flex align-items-center">
                        <div class="text">
                            <h3 class="h4">{{ $project->name }}</h3><small>{{ $project->description }}</small>
                        </div>
                    </div>
                    <div class="project-date"><span class="hidden-sm-down">{{ $project->events->count() }} {{__('ticketshop.events')}} <i class="fa fa-calendar"></i></span></div>
                </div>
                <div class="right-col col-lg-6 d-flex align-items-center">
                    @php
                        $projectSales = 0;
                        $soldTicketsCount = 0;
                        $allTicketsCount = 0;
                        foreach($project->events as $event)
                        {
                            $soldTicketsCount += $event->tickets->count();
                            $allTicketsCount += $event->seatMap->seats;
                            foreach ($event->tickets as $ticket) {
                                $projectSales += $ticket->price();
                            }
                        }
                    @endphp
                    <div class="time"><i class="fa fa-eur"></i>{{ $projectSales }}</div>
                    <div class="comments"><i class="fa fa-ticket"></i>{{ $soldTicketsCount }} / {{ $allTicketsCount }}</div>
                    <hr>
                    <a class="btn btn-info pull-right" href="{{ route('supervision.export-csv', ['project' => $project->id]) }}" target="_blank"><i class="fa fa-table"></i> {{__('ticketshop.csv-export')}}</a>
                    &nbsp;
                    <a class="btn btn-info pull-right" href="{{ route('supervision.export-helga-metrics', ['project' => $project->id]) }}" target="_blank"><i class="fa fa-table"></i> {{__('ticketshop.helga_metrics')}}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
{{-- 
<!-- Dashboard Header Section    -->
<section class="dashboard-header">
    <div class="container-fluid">
        <div class="row">
            <!-- Statistics -->
            <div class="statistics col-lg-3 col-12">
                <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-red"><i class="fa fa-tasks"></i></div>
                    <div class="text"><strong>234</strong><br><small>Applications</small></div>
                </div>
                <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-green"><i class="fa fa-calendar-o"></i></div>
                    <div class="text"><strong>152</strong><br><small>Interviews</small></div>
                </div>
                <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-orange"><i class="fa fa-paper-plane-o"></i></div>
                    <div class="text"><strong>147</strong><br><small>Forwards</small></div>
                </div>
            </div>
            <!-- Line Chart            -->
            <div class="chart col-lg-6 col-12">
                <div class="line-chart bg-white d-flex align-items-center justify-content-center has-shadow">
                    <canvas id="lineCahrt"></canvas>
                </div>
            </div>
            <div class="chart col-lg-3 col-12">
                <!-- Bar Chart   -->
                <div class="bar-chart has-shadow bg-white">
                    <div class="title"><strong class="text-violet">95%</strong><br><small>Current Server Uptime</small></div>
                    <canvas id="barChartHome"></canvas>
                </div>
                <!-- Numbers-->
                <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-green"><i class="fa fa-line-chart"></i></div>
                    <div class="text"><strong>99.9%</strong><br><small>Success Rate</small></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Client Section-->
<section class="client no-padding-top">
    <div class="container-fluid">
        <div class="row">
            <!-- Work Amount  -->
            <div class="col-lg-4">
                <div class="work-amount card">
                    <div class="card-close">
                        <div class="dropdown">
                            <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                            <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow"><a
                                    href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a><a href="#"
                                    class="dropdown-item edit"> <i class="fa fa-gear"></i>Edit</a></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3>Work Hours</h3><small>Lorem ipsum dolor sit amet.</small>
                        <div class="chart text-center">
                            <div class="text"><strong>90</strong><br><span>Hours</span></div>
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Client Profile -->
            <div class="col-lg-4">
                <div class="client card">
                    <div class="card-close">
                        <div class="dropdown">
                            <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                            <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow"><a
                                    href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a><a href="#"
                                    class="dropdown-item edit"> <i class="fa fa-gear"></i>Edit</a></div>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="client-avatar"><img src="img/avatar-2.jpg" alt="..." class="img-fluid rounded-circle">
                            <div class="status bg-green"></div>
                        </div>
                        <div class="client-title">
                            <h3>Jason Doe</h3><span>Web Developer</span><a href="#">Follow</a>
                        </div>
                        <div class="client-info">
                            <div class="row">
                                <div class="col-4"><strong>20</strong><br><small>Photos</small></div>
                                <div class="col-4"><strong>54</strong><br><small>Videos</small></div>
                                <div class="col-4"><strong>235</strong><br><small>Tasks</small></div>
                            </div>
                        </div>
                        <div class="client-social d-flex justify-content-between"><a href="#" target="_blank"><i class="fa fa-facebook"></i></a><a
                                href="#" target="_blank"><i class="fa fa-twitter"></i></a><a href="#" target="_blank"><i
                                    class="fa fa-google-plus"></i></a><a href="#" target="_blank"><i class="fa fa-instagram"></i></a><a
                                href="#" target="_blank"><i class="fa fa-linkedin"></i></a></div>
                    </div>
                </div>
            </div>
            <!-- Total Overdue             -->
            <div class="col-lg-4">
                <div class="overdue card">
                    <div class="card-close">
                        <div class="dropdown">
                            <button type="button" id="closeCard3" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                            <div aria-labelledby="closeCard3" class="dropdown-menu dropdown-menu-right has-shadow"><a
                                    href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a><a href="#"
                                    class="dropdown-item edit"> <i class="fa fa-gear"></i>Edit</a></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3>Total Overdue</h3><small>Lorem ipsum dolor sit amet.</small>
                        <div class="number text-center">$20,000</div>
                        <div class="chart">
                            <canvas id="lineChart1"> </canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
--}}
@endsection

@section('custom-js')
<script type="text/javascript">
$(document).ready(function() {

});
</script>
@endsection