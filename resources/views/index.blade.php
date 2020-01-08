@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Dashboard</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="metric">
                            <span class="icon"><i class="fa fa-credit-card-alt"></i></span>
                            <p>
                                <span class="number">{{ $paymentCount ?? 0 }}</span>
                                <span class="title">All payment</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="metric">
                            <span class="icon"><i class="fa fa-users"></i></span>
                            <p>
                                <span class="number">{{ $clientCount ?? 0 }}</span>
                                <span class="title">All Clients</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="metric">
                            <span class="icon"><i class="fa fa-user"></i></span>
                            <p>
                                <span class="number">{{ $userCount ?? 0 }}</span>
                                <span class="title">All users</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div id="all_order_with_age_betwen"></div>
                    </div>
                    <div class="col-md-6">
                        <div id="gender_count"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div id="week_chart"></div>
                    </div>
                    <div class="col-md-6">
                        <div id="month_chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
