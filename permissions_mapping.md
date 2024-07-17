## Permissions Mapping

### Overview
Users can be assigned permissions to access different parts of the system. Roles and permissions are managed using Spatie Laravel Permissions package.

#### Laravel Nova
Nova is used to manage roles and permissions. The permission required to access nova in a non local environment is `nova.view`

## Schools, Campuses and Users
A school can have multiple campuses. A user can be associated to a school, or a campus, or both.

Job Seeker - Access only to their user portal

School Administrator - admin access to one or more schools
School Assistant - assistant access to one school
Campus Administrator - admin access to one or more campuses under the same school
Campus Assistant - assistant access to one campus


Super Administrator - This role is for the super admin user who has access to all the schools and campuses.



school.view-dashboard - View the admin dashboard for a school - 
This permissions is tested in the EnsureCampusIsSetInSession middleware and should always be set 
for a user who has school level access 

campus.view-dashboard - View the admin dashboard for a campus
This permissions is tested in the EnsureCampusIsSetInSession middleware and should always be set
for a user who has campus level access

user.manage-profile

school.create-campus
school.update-campus
school.delete-campus
school.view-campus

school.manage-user-roles

school.create-user
school.create-administrator
school.update-user
school.update-administrator
school.delete-user
school.delete-administrator
school.view-user
school.view-administrator

school.view-taxonomy-items
school.create-taxonomy-item
school.update-taxonomy-item
school.delete-taxonomy-item

school.view-dashboard





