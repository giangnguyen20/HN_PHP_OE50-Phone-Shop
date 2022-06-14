@extends('admin.header.header')

@section('chart')
<div class="market-updates">
    <div class="col-md-3 market-update-gd">
        <div class="market-update-block clr-block-2">
            <div class="col-md-4 market-update-right">
                <i class="fa fa-eye"> </i>
            </div>
            <div class="col-md-8 market-update-left">
                <h4>{{ __('Products') }}</h4>
                <h3>{{ $data['product'] }}</h3>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="col-md-3 market-update-gd">
        <div class="market-update-block clr-block-1">
            <div class="col-md-4 market-update-right">
                <i class="fa fa-users" ></i>
            </div>
            <div class="col-md-8 market-update-left">
                <h4>{{ __('Users') }}</h4>
                <h3>{{ $data['user'] }}</h3>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
    <div class="col-md-3 market-update-gd">
        <div class="market-update-block clr-block-1">
            <div class="col-md-4 market-update-right">
                <i class="fa fa-usd" ></i>
            </div>
            <div class="col-md-8 market-update-left">
                <h4>{{ __('Category') }}</h4>
                <h3>{{ $data['category'] }}</h3>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
    <div class="col-md-3 market-update-gd">
        <div class="market-update-block clr-block-1">
            <div class="col-md-4 market-update-right">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </div>
            <div class="col-md-8 market-update-left">
                <h4>{{ __('Order') }}</h4>
                <h3>{{ $data['order'] }}</h3>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
    <div class="clearfix"> </div>
</div>
<div class="row">
    <div class="panel-body">
        <div class="col-md-12 w3ls-graph">
            <div class="agileinfo-grap">
                <div class="agileits-box">
                    <header class="agileits-box-header clearfix">
                        <h3>{{ __('Revenue statistics chart in :year', ['year' => $year]) }}</h3>
                    </header>
                    <div class="agileits-box-body clearfix">
                        <canvas id="barChart" chart-data="{{ $chartData }}"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="{{ asset('bower_components/js/jquery2.0.3.min.js') }}"></script>
<script src="{{ asset('js/scriptchart.js') }}"></script>
<script src="{{ asset('js/Chart.js') }}"></script>
