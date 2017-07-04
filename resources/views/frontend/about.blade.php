@extends('frontend.layouts.main')

@section('page_title')
<title>About TBA</title>
@endsection

@section('container')
    <main>
        <div class="tba-logo">
            <img src="{{ asset('frontend/assets/img/about/logo.png') }}" class="center-block">
        </div>

        <section>
            <div class="container">
                <div class="header-title">
                    <h2 class="header-title__tag">Mission and Vision</h2>
                </div>

                <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rerum consectetur magni neque? Ullam natus consequuntur facere tenetur provident, reprehenderit inventore, unde dolorem incidunt libero, id error. Dolores aperiam id eius. Vestibulum in nunc eros. Nam tempor, mi quis efficitur condimentum, ex sem aliquam sem, id congue augue nulla eu mauris. Nullam dapibus vulputate turpis a imperdiet. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In eros velit, fermentum ut erat id, cursus volutpat mauris. Nam viverra eleifend tempus. Duis in lacus a lorem tincidunt tincidunt. Cras pretium magna at mi eleifend, a eleifend diam finibus. Curabitur quis tellus non quam euismod commodo et at nunc. Curabitur euismod porta lobortis. Nulla facilisi. Aliquam fermentum tellus eget augue viverra, eu eleifend justo eleifend. Nulla non diam leo. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Ut efficitur bibendum libero, quis mattis elit tempus at. Vestibulum purus sapien, dapibus at tortor quis, blandit porttitor dui.</p>
                <p class="text-justify">Nam a dolor pellentesque, volutpat eros maximus, elementum nunc. Cras tincidunt, mi non aliquet lacinia, neque libero bibendum augue, ut semper erat est eu sapien. Nulla sit amet convallis sem, quis venenatis purus. Vivamus facilisis hendrerit pulvinar. In lacus libero, viverra eget ex quis, tempor mattis orci. Morbi sem quam, auctor in viverra at, interdum sagittis tortor. Aliquam consequat eleifend auctor. Pellentesque diam purus, pretium id leo in, placerat consectetur metus. Maecenas ex dolor, commodo in imperdiet mollis, tincidunt eu sapien. Phasellus nibh elit, ornare cursus efficitur vitae, blandit vitae dui. Aliquam ac orci consequat, tincidunt tortor a, varius tellus. Etiam consequat ipsum metus. Duis sit amet luctus ex.</p>

                <div class="header-title">
                    <h2 class="header-title__tag">Company Background</h2>
                </div>
                <p class="text-justify">TBA Studios (Tuko Film Productions, Buchi Boy Entertainment, and Artikulo Uno Productions) is an independent film production company dedicated to making high quality films and promoting Filipino filmmakers worldwide. The company is spearheaded by Fernando Ortigas and Eduardo Rocha as Executive Producers and Vincent Nebrida as President. TBA has made a mark in the local industry for producing the award winning, critically–acclaimed, and box office hit, “Heneral Luna”. The historical epic directed by Jerrold Tarog is currently the highest grossing independent and historical film in the Philippines.</p>
                <div class="media-block">
                    <div class="media">
                        <div class="media-left media-middle p-r-5">
                            <img class="media-object" src="{{ asset('frontend/assets/img/about/tuko.png') }}">
                        </div>
                        <div class="media-body">
                            <blockquote class="text-justify p-r-0 m-b-0">In 2013, Fernando Ortigas started Tuko Film Productions, Inc. to jumpstart his career as a film producer. Along with his producing partner E. A. Rocha’s Buchi Boy Entertainment, Tuko has produced several films including Bonifacio: Ang Unang Pangulo (The First President), K’na The Dreamweaver, Tandem, Patintero: Ang Alamat Ni Meng Patalo (The Legend of Meng Patalo), Water Lemon, Iisa (As One), Matangubig (Town In A Lake) and Gayuma (Allure).</blockquote>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-left media-middle p-r-5">
                            <img class="media-object" src="{{ asset('frontend/assets/img/about/buchi-boy-logo.png') }}">
                        </div>
                        <div class="media-body">
                            <blockquote class="text-justify p-r-0 m-b-0">In 2013, Fernando Ortigas started Tuko Film Productions, Inc. to jumpstart his career as a film producer. Along with his producing partner E. A. Rocha’s Buchi Boy Entertainment, Tuko has produced several films including Bonifacio: Ang Unang Pangulo (The First President), K’na The Dreamweaver, Tandem, Patintero: Ang Alamat Ni Meng Patalo (The Legend of Meng Patalo), Water Lemon, Iisa (As One), Matangubig (Town In A Lake) and Gayuma (Allure).</blockquote>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-left media-middle p-r-5">
                            <img class="media-object" src="{{ asset('frontend/assets/img/about/aup-logo.png') }}">
                        </div>
                        <div class="media-body">
                            <blockquote class="text-justify p-r-0 m-b-0">Founded in 2013, Artikulo Uno Productions is an independent film production company that works with inspired minds and fresh talent. Its first offering, Heneral Luna, is the highest grossing Filipino independent film of all time, spending nine weeks in the cinemas. The name “Artikulo Uno” is inspired by the famous threat uttered by General Antonio Luna who demanded his forces to be in the best shape or be penalized by death.</blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="header-title">
                <h2 class="header-title__tag">The Founders</h2>
            </div>
            <img src="{{ asset('frontend/assets/img/about/founders.png') }}" class="w-100">
        </section>
    </main>
@endsection