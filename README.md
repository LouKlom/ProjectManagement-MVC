# ProjectManagement-MVC
A simple project management developped without framework or other tools, just native PHP.


## Installation
Launch it with a simple apache server and a MariaDB BDD, but you can adapt as you want.

You need to create a database and configure the following file: app/config/database.php

The data structure is on the DataStructure folder

You need to Create an administrator account first, no matter what username you choose, the role column must be equal to 'ADMIN' in capital letters



## Ongoing developments
- Comments under Tasks
    - No project sharring for the moment, so it's useless
- Error / Actions Log
    - Currently just for LOGIN
    - Need to be implemented everywhere
    - Log Overload:
        - Need to implement a solution to archive logs and be able to download them on the fly
        - Or just delete LOGS after X days (7 days by default)
- Make clear comments on files

## Upcoming developments
- Sharing Projects
- Administration Pannel
- Images integration
- Working on security
- Notifications
- Assign Tasks
- Invite User
- Mailling
- Easy Installation (automated admin creation)


## Why not developments
- Private message / Chat  system


## Ended developments
- Login and Register form
- Tasks listing
- Admin pannel:
    - User Management: Editing and deleting users
- Limiting user access on project
- Logo creation 
  
