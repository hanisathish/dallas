<div class="row">
    <div class="col-md-12 pb-0" style="background-color:#4d5467">
        <div class="card-body pb-0">
            <h4 class="text-white mb-5">Organizations</h4>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <strong><a class="nav-link {{request()->routeIs('organization.list') ? 'active' : 'text-white'}}" href='{{URL::asset("/settings/organization")}}'>Organization List</a></strong>
                </li>                
            </ul>
        </div>
    </div>
</div>