@extends('layouts.basic', ['body_class' => 'page--dashboard'])

@section('title', 'Admin')

@section('body')

    <header>
      <main-navigation />
    </header>

    <div class="container-fluid">
      <div class="row">
        <conversation-nav></conversation-nav>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
          <chat-window></chat-window>
        </main>
      </div>
    </div>

@endsection