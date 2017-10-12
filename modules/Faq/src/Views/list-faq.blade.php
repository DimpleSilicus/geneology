@extends($theme.'.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel-default">
                <div class="panel-body">
                    <div class="center">
                        <h2>FAQs</h2>
                    </div>
                    <div class="row">
                        @foreach ($faq as $item)
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h2 class="panel-title">{{$item->question}}</h2>
                                    <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
                                </div>
                                <div class="panel-body">
                                    <p class="lead">{{$item->answer}}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="clearfix">
                        </div>
                    </div>
                    <div class="row center">
                        <div class="col-xs-9">
                            {{ $faq->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

