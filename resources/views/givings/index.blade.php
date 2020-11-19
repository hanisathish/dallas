@extends('layouts.default')

@section('content')
    <!-- <div style="width:100vw"> -->
        @include('givings.header')
        <div class="row m-5 pl-4 pr-4">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h5 class="mt-0">Giving List
                            @if($payment_gateways->count() > 0)
                            <a href="{{ URL:: asset('settings/givings/manage/')}}" class="btn btn-sm btn-success pull-right text-white"><i class="fa fa-plus"></i> Create New</a>
                            @else
                                <span class="error" style="margin-left: 20%;">Kindly setup payment gateway to use "Giving" !</span> <a href="{{ URL:: asset('settings/payment_gateways/')}}" class="btn btn-sm btn-success pull-right text-white"><i class="fa fa-cog"></i> Click here to setup</a>
                            @endif

                        </h5>
                        <hr/>
                        <div class="tab-content">
                            <div class="tab-pane active p-3">
                                <table id="scheduleDatatable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <!-- <th>S.No</th>				 -->
                                            <!-- <th>Org Name</th>				 -->
 											<th>Payment Details</th>
 											<!-- <th>OtherPayment</th> -->
											<th>Amount</th> 
											<!-- <th>PayMode</th>											 -->
											<th>Type</th>											
											<th>Events</th>											
											<th>UserFullName</th>                                                                                    
											<th>Transaction Status</th>                                          
											<!-- <th>Final Status</th>                                          -->
											<th>Transaction Date</th> 
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- </div> -->
    
    
@endsection

@section('js_script')
    <script src="{{ URL:: asset('js/settings/givings/index.js')}}"></script>
@endsection