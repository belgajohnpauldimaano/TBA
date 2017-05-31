@extends('layouts.main')

@section ('title')
    Home Carousel
    <small></small>
@endsection

@section ('styles')

@endsection

@section('content')
    <div class="sortable-container">
        <div>
            <img data-id="4" src="{{ asset('cms/dist/img/avatar04.png') }}" alt="">
        </div>
            <img data-id="3" src="{{ asset('cms/dist/img/avatar3.png') }}" alt="">
        <div>
            <img data-id="2" src="{{ asset('cms/dist/img/avatar.png') }}" alt="">
        </div>
        <div>
            <img data-id="1" src="{{ asset('cms/dist/img/avatar2.png') }}" alt="">
        </div>

        <div><img data-id="5" src="{{ asset('cms/dist/img/avatar5.png') }}" alt=""></div>
    </div>
    <button class="btn btn-flat btn-primary" id="save-sorted">Save</button>
    <button class="btn btn-flat btn-primary" id="append-img">Save</button>
@endsection

@section ('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $('.sortable-container').sortable({ 
            tolerance: 'pointer',
            update : function (event, ui) {
                //console.log(event);
                var order = [];

                $('.sortable-container div img').each( function () {
                    var id = $(this).data('id');
                    order.push(id);
                });
                console.log(order);
                console.log(ui);
            }
        });
        $('body').on('click', '#save-sorted', function () {
            
        });
        $('body').on('click', '#append-img', function () {
            var elem = '<img data-id="5" src="' +"{{asset('cms/dist/img/avatar5.png')}}" + '" alt="">'
            $('.sortable-container').append(elem);
        })
    </script>
@endsection
