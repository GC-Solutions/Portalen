## APP
```
This folder contain the Main MVC Structure .

Controller 
Model 
View 
```
# Controller
```
This Folder conation the Business Logic  . All the function are performed here .
This Folder conatin so many other Folder according to their Functionality and purpose of Use in System .
The Inner FOlder conatin Php files here .

```
# Model
```
The central component of the pattern.
This Folder contain Files that hold the system's dynamic data structure .
It directly manages the data, logic and rules of the application.
```
# View
```
This folder contain Files that contain UI .
Contain Folder that have template files . 
```

# Controller Folders 
```
Admin
Api
Cron
CsvUpload
DataFormatHelper
DataTableDesign
DataTables
GeneralCalculation
Google
Graphs
Home
LOgin
Maps
Panels
SessionSetter
```

# Admin
```
This Folder Contain Files that has Buisness Logic for admin panels . 
All the Files in the folder peform CURd OPeration and other functionality required at the admin side by the respective Panel.

```
# Admin Folder

## adminAddress 
```
(This Folder conatin File named as Address.php which handle the business logic for all the option for Address Panel at admin Side).
```
## adminCompany 
```
(This Folder conatin File named as Company.php which handle the business logic for all the option for Compaines Panel at admin Side).
```
## adminDatasource 
```
(This Folder contain file Named as DataSource.php which handle all the operation regarding displaying datasource , routing to  create new Datasource and edit it . this file also handle to delet the data source . )
```
## adminDB 
```
(This folder conaton file named as AdminDB.php . this file conatin function that are used to display data , create and edit  data for adminDB  and delete adminDB)
```
## adminGeneral 
```
(This folder contain multiple Genernal Files in it . As the name suggest these file contain fnction that are used by multiple other files . The files in this folder are called by ajax to fetch data e.g to get all the data Source on table place holder , or fetching Column Name in table placeholder etc  )
```
## adminImage 
```
(This Folder conatin File named as Address.php which handle the business logic for all the option for Image Panel at admin Side. Current this Panel is not in Use )
```
## adminPageaccess
```
(This Folder contain file named as PageAccess.php .  ths file conatin all the functions required for adding a page for a user . delete or edit those page . this file has function that are used to add , edit and delete multiple place holder on page .)
```
## adminPagetemplate 
```
(This Folder contain File named as PageTemplate.php . this file handle all CURD operation regarding templates )
```
#adminParameter
``` 
(This Folder Contain File named as parameter.php . this File contain Function that are used to create , edit , delete )
```
## adminPlaceholder
```
(This Folder Contain File  Multiple Files in it . That are used on Placeholder panel to create , edit , edit and show different placholders .) 
```
## adminProduct
```
(This Folder Contain File named as Product .php this file is not being used at the moment )
```
## adminTwotable
```
(this FOlder conatin File named as TwoTable.php . this file conation business logic to create combined table , edit it and delete them . over here you create a entry that actually combin tables and then that entry can be selected at user page to display combined tables )
```
## adminUser
```
(this Folder contain File named as User.php this file is Used to create new user , edit them and delete them .)

```



# Cron

## ImageSync.php
```
 (This file has cron that runs every day for adding the new image info  to DB that have been upload ).
ProductsCron.php (This file contain cron that run every day . this file actuall fetch data from 2 api calls and update products database table )

```
# CsvUpload

## Csvupload.php 
```
(This file contain function that are called by Ajax request in order to upload a csv . The function on this file is also used to edit and delete rows on table).
```
# DataTableHelper

## DataTableHelper.php
```
This folder contain file named as dataTableHeler.php . this file has function that are used by other files for data Formating 
```

# DataTableDesign 
##  DataTableDesign.php
```
This folder contain file named as DataTableDesign.php . this file has function that are used to perform Curd Opertion for adding the Width to the datatable column filters .
```

# DataTables 
## APIDataSourceCallData.php
```
(This File is used to perform Curl preform to fetch Api data )
```
## APIDataSourceCallMultipleNode.php
```
This File is used to fetch data for multi node Api .
```
## APIDataSourceCallSingleNode.php
```
This File is use to fetch data form normal normal single node .
```
## ActionButton.php
```
This File is used to add all the requied link and information for linking  an action button  to each row in datatable .
```
## DBDataSourceCallData.php
```
This File is used to add all the requied link and information for linking  an action button  to each row in datatable .
```
## DBDataSourceCallRowCreation.php
```
This File is used to perform query Call to DB to fetch data .
```
## DataTableColumn.php
```
This File conatin function that are used to generate and apply all the operation /option set on column e.g defining perfefine filters or predefine search on column etc .
```
## DataTableJoinTable.php
```
this Fuction is used to generate data for join Table .
```
## DataTables.php
```
This File is used to generate data for Datatable .
```
## DownloadPDF.php
```
this File contian Function that are used to genreate PDF and download it .
```
## GeneralDataTableFtn.php
```
This file conatin Functions that are used by so many files . 
```
## GoogleCallData.php
```
This  File is used to make Curl request to Google Api and fetch data .
```
## GraphDataHighChart.php
```
This File is used to gernate data that will be used by graph .
 ```
## Product.php
```
This file is used by products to add extra info and showing it .
```
## SendForm.php
```
This file is used to craete , save and display custom form . this file have function that are used to creare form from admin side .
```
## SourceType.php
```
This file conatin function that is used to create Source type used by Api .
```
## SumCalculation.php
```
this file contian function that perform custom sum according to its type .
```
## UpdateForm.php
```
This file is used by Ajax request to update data . it can be from form or perdefine etc .
```
# General Calculation 
```
This Folder contian File Named as Calculation that is used to perform custom sum for graphs , panels etc .
```
# Google 
```
This Folder contain File named as GoogleApi.php  that make  Connection with Goole API to access the data .
```
# Graphs
```
This Folder contain  File Named as  graphs.php that are used to generate data that are ued by garphs .
```
# Home
```
This Folder contain File named as Home.php . this File is called first thing after index.php . this file contain Function That are used to check if used have loged in or not . it has function that Allow used to login and logout .
This File is Also used to perform the Account shift function too .
```
# Login 
```
This FOlder not being Used 
```
# Maps
```
This Folder contain  File Named as  Maps.php that are used to generate data that are used Maps.
```
# Panels
```
This Folder contain  File Named as  Panels.php that are used to generate data that are used Panels .
```
# Session Setter 
```
This Folder contain  File Named as  sessionSetter.php. this file  is  used to maintain session for sort option when row group is enabled on datatable  .
```
## Folder Structure Controller

```
28 directories, 59 files

├── API
│   ├── APIGenerateJoinTableData.php
│   ├── APIGenerateTableData.php
│   ├── APILogin.php
│   ├── AdminApi.php
│   └── Api.php
├── Admin
│   ├── adminAddress
│   │   └── Address.php
│   ├── adminCompany
│   │   └── Company.php
│   ├── adminDB
│   │   └── AdminDB.php
│   ├── adminDatasource
│   │   └── DataSource.php
│   ├── adminGeneral
│   │   ├── FetchDataAdmin.php
│   │   ├── GenerateForm.php
│   │   └── ProductExtraInfoForm.php
│   ├── adminImage
│   │   └── Image.php
│   ├── adminPageaccess
│   │   └── PageAccess.php
│   ├── adminPagetemplate
│   │   └── PageTemplate.php
│   ├── adminParameter
│   │   └── Parameters.php
│   ├── adminPlaceholder
│   │   ├── GraphPlaceholder.php
│   │   ├── MapPlaceholder.php
│   │   ├── PanelPlaceholder.php
│   │   ├── PieChartPlaceholder.php
│   │   ├── Placeholders.php
│   │   └── TablePlaceholder.php
│   ├── adminProduct
│   │   └── Product.php
│   ├── adminTwotable
│   │   └── TwoTable.php
│   └── adminUser
│       └── Users.php
├── Api.php
├── Cron
│   ├── ImageSync.php
│   └── ProductsCron.php
├── CsvUpload
│   └── Csvupload.php
├── DataFormatHelper
│   └── DataTableHelper.php
├── DataTableDesign
│   └── DataTableDesign.php
├── DataTables
│   ├── APIDataSourceCallData.php
│   ├── APIDataSourceCallMultipleNode.php
│   ├── APIDataSourceCallSingleNode.php
│   ├── ActionButton.php
│   ├── DBDataSourceCallData.php
│   ├── DBDataSourceCallRowCreation.php
│   ├── DataTableColumn.php
│   ├── DataTableJoinTable.php
│   ├── DataTables.php
│   ├── DownloadPDF.php
│   ├── GeneralDataTableFtn.php
│   ├── GoogleCallData.php
│   ├── GraphDataHighChart.php
│   ├── JoinTableData.php
│   ├── Product.php
│   ├── SendForm.php
│   ├── SourceType.php
│   ├── SumCalculation.php
│   └── UpdateForm.php
├── GeneralCalculation
│   └── Calculation.php
├── Google
│   └── GoogleAPI.php
├── Graphs
│   └── Graphs.php
├── Home
│   └── Home.php
├── Login
│   └── Login.php
├── Maps
│   └── Maps.php
├── Panels
│   └── Panels.php
├── Readme.md
└── SessionSetter
    └── sessionSetter.php


```
