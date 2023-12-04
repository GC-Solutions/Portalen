<!-- This needs to get moved to a CSS folder instead -->
<style>
    .dataTables_filter input{
        display: block;
        width: 100%;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        outline: 0!important;
        box-shadow: none!important;
    }
    .dataTables_wrapper button{
        background-color: #2CA8FF !important;
        border: 1px solid #2CA8FF !important;
        color: #fff !important;
        font-size: 12px;
        transition: box-shadow .28s cubic-bezier(.4, 0, .2, 1);
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        -ms-border-radius: 2px;
        -o-border-radius: 2px;
        border-radius: 2px;
        overflow: hidden;
        position: relative;
        padding: 8px 14px 7px;
        margin: 0px 5px;
    }
    .dataTables_info{
        float: center;
        display: inline-block;
         background-color: #ffffff !important;
        border: 0px solid #2CA8FF !important;
        color: #000000 !important;
        font-size: 12px;
        transition: box-shadow .28s cubic-bezier(.4, 0, .2, 1);
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        -ms-border-radius: 2px;
        -o-border-radius: 2px;
        border-radius: 2px;
        /*overflow: hidden;*/
        position: relative;
        /*padding: 8px 14px 7px;*/
        margin: 0px 5px;

    }
    .dataTables_paginate{
        float: right;
        display: inline-block;
    }
    td a.tableButtons {
        margin: 2px 0px;
    }
    tfoot {
        display: table-header-group;
    }

@media (min-width: 992px){
    .custom-navbar-collapse .custom-navbar-nav{
        display: block;
    }
    .custom-navbar-nav li {
        float: left;
    }
    .custom-navbar-nav .nav-item .nav-link {
        font-size: 14px;
        /*width: 85px;*/
        float: left;
        text-align: center;
    }
    .custom-navbar-nav .dropdown-menu li {
        width: 100%;
    }
}
.dropdown>.dropdown-menu {
  top: 200%;
  transition: 0.3s all ease-in-out;
}
.dropdown:hover>.dropdown-menu {
  display: block;
  top: 100%;
}

.dropdown>.dropdown-toggle:active {
  /*Without this, clicking will make it sticky*/
    pointer-events: none;
}
.dropdown-toggle::after {
    display:none;
}
</style>