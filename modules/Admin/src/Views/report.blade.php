@extends('Admin::layouts.app')
@section('content')

<section class="content">

    <h1>Reports</h1>

    <section class="container">
        <form role="form" id="downloadReportForm" name="downloadReportForm" autocomplete="off" action="{{url('/admin/report-sample')}}" method="GET">
            <div class="form-group">
                <h4><label>Select Date Range:</label></h4>

                <div class="input-group col-lg-3">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="date" value='' class="form-control pull-right" id="reservation">
                </div>
            </div>

            <div class="form-group">
                <input type="checkbox" name="logo" checked=""><span class="text-bold">&nbsp;Show Logo</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="total" checked=""><span class="text-bold">&nbsp;Show Total</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="pie" checked=""><span class="text-bold">&nbsp;Show Pie Chart</span>
            </div>

            <div class="form-group">
                <a id="downloadReport" href="#" class="btn btn-danger"><i class="fa fa-download"></i> Download Report</a>
            </div>

        </form>
    </section>
</section>
@endsection