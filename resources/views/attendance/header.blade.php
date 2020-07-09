<div class="row">
    <div class="col-md-12 pb-0" style="background-color:#4d5467">
        <div class="card-body pb-0">
            <h4 class="text-white mb-5">Events Attendance</h4>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <strong><a class="nav-link {{request()->routeIs('attendance.list') ? 'active' : 'text-white'}}" href='{{URL::asset("attendance")}}'>Events Attendance List</a></strong>
                </li>                
            </ul>
        </div>
    </div>
</div>