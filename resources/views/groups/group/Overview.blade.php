<div class="col-lg-9">
    <div class="card m-b-30">
        <div class="card-header">
            Members Information
        </div>
        <div class="card-body">
            <div class="col-12">
                <div class="row">
                        <div class="tab-content" id="v-pills-tabContent">


                                <div class="row">
                                        <div class="col-sm-6">
                                          <div class="card">
                                            <div class="card-body">
                                                    <div class="col-md-12 text-left py-md-0" style="padding-top:0 !important; font-weight:600">{{ucwords($groupDetails->name)}} Health Stats</div>

                                                    <div class="col-md-12 " style="padding-left:3rem">
                                                        <div class="col-md-12 py-md-2 verticle-center">
                                                            <span class="chart-container__stat-value">{{$overview['member_count']}}</span>
                                                            <span class="chart-container__stat-separator">–</span>
                                                            <span class="chart-container__stat-details">Member</span>
                                                        </div>
                                                        <div class="col-md-12 py-md-2 verticle-center">
                                                                <span class="chart-container__stat-value">{{$overview['event_count']}}</span>
                                                                <span class="chart-container__stat-separator">–</span>
                                                                <span class="chart-container__stat-details">Average meetings  per month</span>
                                                            </div>

                                                            <div class="col-md-12 py-md-2 verticle-center">
                                                                    <span class="chart-container__stat-value">{{$overview['turn_over']}}</span>
                                                                    <span class="chart-container__stat-separator">%</span>
                                                                    <span class="chart-container__stat-details">90 day turnover</span>
                                                                </div>


                                                    </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-6">
                                          <div class="card">
                                            <div class="card-body">
                                                    <div class="col-md-12 text-left py-md-0" style="padding-top:0 !important; font-weight:600">Other {{ucwords($groupDetails->group_type_name)}}</div>

                                                    <div class="col-md-12 " style="padding-left:3rem">
                                                        <div class="col-md-12 py-md-2 verticle-center">
                                                            <span class="chart-container__stat-value">{{$overview['other_group_member_count']}}</span>
                                                            <span class="chart-container__stat-separator">–</span>
                                                            <span class="chart-container__stat-details">Member</span>
                                                        </div>
                                                        <div class="col-md-12 py-md-2 verticle-center">
                                                                <span class="chart-container__stat-value">{{$overview['other_group_event_count']}}</span>
                                                                <span class="chart-container__stat-separator">–</span>
                                                                <span class="chart-container__stat-details">Average meetings  per month</span>
                                                            </div>

                                                            <div class="col-md-12 py-md-2 verticle-center">
                                                                    <span class="chart-container__stat-value">{{$overview['other_turn_over']}}</span>
                                                                    <span class="chart-container__stat-separator">%</span>
                                                                    <span class="chart-container__stat-details">90 day turnover</span>
                                                                </div>


                                                    </div>
                                            </div>
                                          </div>
                                        </div>



                        </div>
                </div>
            </div>
        </div>

    </div>
</div>
