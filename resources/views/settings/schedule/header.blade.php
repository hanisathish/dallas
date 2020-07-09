<div class="row">
    <div class="col-md-12 pb-0" style="background-color:#4d5467">
        <div class="card-body pb-0">
            <h4 class="text-white mb-5">Schedules</h4>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <strong><a class="nav-link {{request()->routeIs('schedule.list') ? 'active' : 'text-white'}}" href='{{URL::asset("/settings/schedulling")}}'>Schedules List</a></strong>
                </li>
                <li class="nav-item">
                    <strong><a class="nav-link {{request()->routeIs('schedule.notifications') ? 'active' : 'text-white'}}" href='{{URL::asset("/settings/schedulling/notifications")}}'>Notifications</a></strong>
                </li>
                <li class="nav-item">
                    <strong><a class="nav-link {{request()->routeIs('position.list') ? 'active' : 'text-white'}}" href='{{URL::asset("/settings/position")}}'>Position List</a></strong>
                </li>
            </ul>
        </div>
    </div>
</div>