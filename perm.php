$permission = Permission::whereName('Accounting')->first();
        dd($permission,auth()->user()->hasPermissionTo($permission));
        dd("dddd");
        if ( $user->can('Accounting'))
    {
        echo '<h2>User Can "Accounting" </h2>';
    }
    else
    {
        echo '<h2>User Cannot "Accounting"</h2>';
    }


    if ( $user->hasPermissionTo('Accounting'))
    {
        echo '<h2>User Has Permission To "Accounting" </h2>';
    }
    else
    {
        echo '<h2>User Does Not have permission to  "Accounting"</h2>';
    }
        dd(Auth::user()->getAllPermissions());
        if (Auth::user()->hasPermissionTo('Accounting')) {
                abort('401');
            } 

        dd("d");
        $user = \App\User::find(1);//->get()
        $arrPerm = $user->getAllPermissions();
        //dd($arrPerm);
        dd($user->hasAnyPermission('Accounting'));
        //dd($user->hasAnyPermission(array_column($user->getAllPermissions()->toArray(),'name')));
        dd(array_column($user->getAllPermissions()->toArray(),'name'));
        dd($user->toArray());










        
        //$user = \App\Models\UserMaster::find(1)->get();
        // $user = \App\User::find(1);//->get()
        // dd($user->getAllPermissions());
        // dd($user->toArray());