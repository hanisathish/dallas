<div class="card m-b-30">
    <div class="card-body">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link {{($activeTab=="members")?"active":""}}" id="v-pills-home-tab" data-toggle1="pill" href="{{url('')}}/groups/details/{{$groupDetails->id}}/members"  role="tab" aria-controls="v-pills-home" aria-selected="true">Members</a>
          <a class="nav-link {{($activeTab=="events")?"active":""}}" id="v-pills-profile-tab" data-toggle1="pill" href="{{url('')}}/groups/details/{{$groupDetails->id}}/events" role="tab" aria-controls="v-pills-profile" aria-selected="false">Events</a>
          <a class="nav-link {{($activeTab=="resources")?"active":""}}" id="v-pills-messages-tab" data-toggle1="pill" href="{{url('')}}/groups/details/{{$groupDetails->id}}/resources" role="tab" aria-controls="v-pills-messages" aria-selected="false">Resources</a>
          <a class="nav-link {{($activeTab=="settings")?"active":""}}" id="v-pills-settings-tab" data-toggle1="pill" href="{{url('')}}/groups/details/{{$groupDetails->id}}/settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
          <!-- <a class="nav-link {{($activeTab=="overview")?"active":""}}" id="v-pills-settings-tab" data-toggle1="pill" href="{{url('')}}/groups/details/{{$groupDetails->id}}/overview" role="tab" aria-controls="v-pills-settings" aria-selected="false">Overview</a>
          <a class="nav-link {{($activeTab=="attendance")?"active":""}}" id="v-pills-settings-tab" data-toggle1="pill" href="{{url('')}}/groups/details/{{$groupDetails->id}}/attendance" role="tab" aria-controls="v-pills-settings" aria-selected="false">Attendance</a> -->
		  
		  <a class="nav-link {{($activeTab=="insights")?"active":""}}" id="v-pills-messages-tab" data-toggle1="pill" href="{{url('')}}/groups/details/{{$groupDetails->id}}/insights" role="tab" aria-controls="v-pills-messages" aria-selected="false">Insights</a>

        </div>

    </div>
</div>
