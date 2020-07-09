<div class="row">
    <div class="col-md-12">
        <div class="text-white card-primary" >
            <div class="card-body" style="padding-bottom:0px;">
                <h3 class="mb-5">{{$form->title ? $form->title : "Title not defined"}}<small><a class="btn btn-light pull-right" href='{{URL::asset("/form/submission/$form->id")}}' target="_blank">View Public Form <i class="fa fa-external-link"></i></a><a href="{{URL::asset('/settings/forms/manage')}}"  class="btn btn-secondary pull-right">New Form</a></small>
                </h3>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <strong><a class="nav-link {{request()->routeIs('form.submissions') ? 'active' : 'text-white'}}" href='{{URL::asset("/settings/forms/$form->id/submissions")}}'>Submissions</a></strong>
                    </li>
                    <li class="nav-item">
                        <strong><a class="nav-link {{request()->routeIs('form.fields') ? 'active' : 'text-white'}}" href='{{URL::asset("/settings/forms/$form->id/fields")}}'>Fields</a></strong>
                    </li>
                    <li class="nav-item">
                        <strong><a class="nav-link {{request()->routeIs('form.settings') ? 'active' : 'text-white'}}" href='{{URL::asset("/settings/forms/$form->id/settings")}}'>Settings</a></strong>
                    </li>
                </ul>    
            </div>
        </div>
    </div>
</div>