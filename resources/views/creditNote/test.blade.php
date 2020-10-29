@extends('layouts.admin')

@section('page-title')
    Create Credit-Note
@endsection

@section('content')

<div class="section">

    <!-- Header of Section -->
    <div class="section-header">
        <h1>Create Credit-Note</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{route('credit.note')}}">Credit-Note</a></div>
            <div class="breadcrumb-item active">Create</div>
        </div>
    </div>

    <!-- Body of Section -->
    <div class="section-body">
        <form action="" method="GET">

            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

            <div class="form-group row col-md-3">
                <label for="invoice" style="margin-bottom:10px;font-size:13pt;">Invoice #</label>
                <select name="invoice" id="" class="form-control">
                    <option value="">Hello</option>
                </select>
                <div style="width:100%;padding:10px;background-color:#d6d6d3;margin-top:10px;">
                    <p>DUMMY INFO</p>
                    <p>DUMMY INFO</p>
                    <p>DUMMY INFO</p>
                </div>
            </div>

        </form>
    </div>

</div>






@endsection
