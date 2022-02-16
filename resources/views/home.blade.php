@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(!Auth::user()->isadmin)
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">customer name</th>
                                        <th scope="col">month</th>
                                        <th scope="col">year</th>
                                        <th scope="col">amount</th>
                                        <th scope="col">status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($customers as $key => $c)
                                        @php($monthName = date('F', mktime(0, 0, 0, $c->month, 10)))
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{Auth::user()->name}}</td>
                                            <td>{{$monthName}}</td>
                                            <td>{{ $c->year }}</td>
                                            <td>{{ $c->amount }}</td>
                                            <td>{{ $c->status }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
