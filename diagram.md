@startuml

actor "User" as user

node "Absensi Karyawan" {
    node "Model" as model
    node "View" as view
    node "Controller" as controller
    node "Repository" as repository
    node "Domain" as domain
    node "Service" as service
}

database "MySQL" as mysql

user --> controller : 1
controller --> model : 2
controller --> service : 3
service --> repository : 4
repository --> domain : 5
repository --> mysql : 6
controller --> view : 7
controller --> user : 8

@enduml