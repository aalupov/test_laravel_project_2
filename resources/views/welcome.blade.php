@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Weather in Bryansk</div>
                    @include('includes.error')
                    @include('includes.success')
                    <img src='https://yastatic.net/weather/i/icons/blueye/color/svg/{{ $weather['icon'] }}'/ width='50'><br>
                    <p>Temperatura: {{ $weather['temp'] }} C</p>
                    <p>Pressure: {{ $weather['pressure'] }}</p>
                    <p>Wind Speed: {{ $weather['wind_speed'] }} M\c</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection