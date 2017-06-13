@extends('frontend.layouts.main')

@section('container')
    <main>
        <section>
            <div class="header-title">
                <h2 class="header-title__tag">Contact</h2>
            </div>
            <div class="container">
                <div class="contact-info">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="contact-info-details">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-6">
                                        <h4><strong>Tba Studios</strong></h4>
                                        <p>
                                            160 Luna Mencias St., <br>
                                            Brgy. Addition Hills, <br>
                                            San Juan City 1500, <br>
                                            Metro Manila, Philippines <br>
                                        </p>
                                        <p>
                                          <strong class="clearfix">Phone</strong>
                                          <span class="text-calibri">+632 398 1939</span>
                                        </p>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-6 b-left-3">
                                        <div class="clearfix">
                                            <div class="pull-right">
                                                <h4 class="m-b-0 text-capitalize"><strong>General Inquiries</strong></h4>
                                                <p class="text-calibri m-b-4">info@tba.ph</p>

                                                <h4 class="m-b-0 text-capitalize"><strong>Marketing</strong></h4>
                                                <p class="text-calibri m-b-4">marketing@tba.ph</p>

                                                <h4 class="m-b-0 text-capitalize"><strong>Casting</strong></h4>
                                                <p class="text-calibri m-b-4">thirdeye@tba.ph</p>

                                                <h4 class="m-b-0 text-capitalize"><strong>Cinerma '76</strong></h4>
                                                <p class="text-calibri">cinema76fs@tba.ph</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <form action="">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="NAME">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="EMAIL ADDRESS">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" rows="10" placeholder="MESSAGE"></textarea>
                                </div>
                                <div class="text-center">
                                  <button type="button" class="btn btn-default">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="mapContact"></div>
        </section>
    </main>
@endsection