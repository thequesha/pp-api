@extends('app')
@section('content')
    <div class="py-4 h1">
        STATISTICS
    </div>

    <div class="">
        <div class="row row-cols-xl-4 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1">
            <div class="col">
                @include('sections.marks_card')
            </div>
            <div class="col">
                @include('sections.vehicles_card')
            </div>
            <div class="col">
                @include('sections.parameters_card')
            </div>
            <div class="col">
                @include('sections.options_card')
            </div>
            <div class="col">
                @include('sections.part_categories_card')

            </div>
            <div class="col">
                @include('sections.parts_card')

            </div>

        </div>
    </div>
@endsection
