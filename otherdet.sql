

SELECT id,users.first_name, organization.orgName ,(select master_lookup_data.mldValue from master_lookup_data WHERE master_lookup_data.mldKey='name_prefix' and users.name_prefix=master_lookup_data.mldId)  FROM `users` 
LEFT join organization on organization.orgId=users.orgId
WHERE 1


SELECT id,users.first_name, organization.orgName ,(select master_lookup_data.mldValue from master_lookup_data WHERE master_lookup_data.mldKey='name_prefix' and users.name_prefix=master_lookup_data.mldId),
CASE WHEN master_lookup_data.mldKey='name_prefix' THEN master_lookup_data.mldValue ELSE 'NONED' END AS newcreatedname
FROM `users` 
LEFT join organization on organization.orgId=users.orgId
LEFT JOIN master_lookup_data on (master_lookup_data.mldId=users.name_prefix OR master_lookup_data.mldId=users.name_suffix OR master_lookup_data.mldId=users.school_name or master_lookup_data.mldId=users.grade_id)
WHERE 1
GROUP BY users.id


SELECT id,users.first_name, organization.orgName ,
IFNULL(users.name_prefix,'NOTUPDATED') , users.name_prefix,master_lookup_data.mldId,
CASE WHEN (users.name_prefix=master_lookup_data.mldId and master_lookup_data.mldKey='name_prefix') THEN master_lookup_data.mldValue ELSE 'GT' END AS deded
FROM `users` 
LEFT join organization on organization.orgId=users.orgId
LEFT JOIN master_lookup_data on (master_lookup_data.mldId=users.name_prefix OR master_lookup_data.mldId=users.name_suffix OR master_lookup_data.mldId=users.school_name or master_lookup_data.mldId=users.grade_id)
WHERE 1
GROUP BY users.id

-------------

1. Member Directory (Fellowship)
2. User Management
3. Nextgen Check-in
4. Communication

5. Event Management 
6. Scheduling (Serve) 
7. Forms Designer 
8. Small Groups (Discipleship) 
9. Reports 
10. Pastor's Board (Classifieds) 
11. Asset Management


12. Giving (Seeding)
13. Accounting
14. Serve Team Chat Board (Band)
15. Attendance
16. Insights


https://colorlib.com/preview/#digilab

https://themesdesign.in/upcube/layouts/horizontal/index.html

https://jp1icp.axshare.com

https://planning.center/

ALTER TABLE `checkins` ADD `createdBy` TEXT NULL DEFAULT NULL AFTER `chKind`, ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `createdBy`, ADD `updatedBy` TEXT NULL DEFAULT NULL AFTER `created_at`, ADD `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL AFTER `updatedBy`, ADD `deletedBy` TEXT NULL DEFAULT NULL AFTER `updated_at`, ADD `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `deletedBy`; 

Dummy emails :
raghunaath221@gmail.com
Diya@123



dsammy799@gmail.com Diya@123

1. On signup send email to admin with welcome message


git add .
git commit -m 'your msg'
git pull
git fetch
git push origin 'branch name'


--------------
permissions-----
$user = $request->user();
        $roles = $user->roles;
        //dd($roles);
        //dd($user->hasPermissionTo('Event management'));
            $permissions = $user->permissions;
            $permissions = $user->getAllPermissions();
  $checkPermissionTo = $user->checkPermissionTo(12,null);
//dd("checkPermissionTo=",$checkPermissionTo);
  $perArray = array_column($permissions->toArray(),'id');
  
  array_push($perArray, 9);

  
//$hasAllPermissions = $user->hasAllPermissions(array_column($permissions->toArray(),'name'));
  $hasAllPermissions = $user->hasAllPermissions($perArray);
dd($hasAllPermissions,array_column($permissions->toArray(),'name'));

        dd($permissions); //will return true, if user has role

        dd($user);

SET FOREIGN_KEY_CHECKS = 0; 
truncate permissions;
SET FOREIGN_KEY_CHECKS = 1; 

