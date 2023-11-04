@extends('layouts.appFront')

@section('head')
<style>

    .toggle-header, .toggle-content {

        font-size: 18px;
        line-height: 24px;
        font-weight: 400;
    }

    .toggle-active > .toggle-header{
        color: #fd680e;
    }

    .row.clearfix.btnFix{
        --bs-gutter-x: 0rem!important;
    }

    .button.button-full.button-left{
        background-color: #1ABC9C;
    }

    .button.button-full.button-right{
        background-color: #f9a622;
    }

    .button.button-full.button-left:hover{
        background-color: #2b2b2b;
    }

    .button.button-full.button-right:hover{
        background-color: #2b2b2b;
    }


    #blink {
        font-size: 20px;
        font-weight: bold;
        font-family: sans-serif;
        color: #1c87c9;
        transition: 0.4s;
    }

</style>

@endsection

@section('header')

@endsection
@section('script')

@endsection
