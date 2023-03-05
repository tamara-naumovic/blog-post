@extends('layouts.blog')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 text-center pt-5">
                <h1 class="display-one mt-5">{{config('app.name')}}</h1>
                <p>Moja prva Laravel aplikacija. Prikazacemo blogove.</p>
                <br>
                <a href="/blog" class="btn btn-outline-primary">Prikazi sve blogove</a>
                <a href="/blog/my" class="btn btn-outline-primary">Prikazi moje blogove</a>
            </div>
        </div>
    </div>

@endsection