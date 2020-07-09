<div class="card m-b-30">
    <div class="card-body">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ URL::asset('/people/member/'.$user->personal_id)}}"><i class="fa fa-pencil fa-lg"></i>&nbsp;Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ URL::asset('/people/member/'.$user->personal_id.'/messages')}}"><i class="fa fa-commenting fa-lg"></i>&nbsp;Communication</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ URL::asset('/people/position/'.$user->personal_id)}}"><i class="fa fa-commenting fa-lg"></i>&nbsp;Position</a>
            </li>
            
        </ul>
    </div>
</div>