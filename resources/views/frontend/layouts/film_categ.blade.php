<section class="film-categ text-center">
    <ul class="film-categ__list list-inline text-uppercase">
        <li class="film-categ__item">
        	<a class="film-categ__item__link {{ Request::is('films') ? 'film-categ__item__link--active' : '' }}" href="{{ route('films') }}">Film List</a>
        </li>
        <li class="film-categ__item">
        	<a class="film-categ__item__link {{ Request::is('trailers') ? 'film-categ__item__link--active' : '' }}" href="{{ route('trailers') }}" href="">Trailers</a>
        </li>
        <li class="film-categ__item">
        	<a class="film-categ__item__link {{ Request::is('on-dvd') ? 'film-categ__item__link--active' : '' }}" href="{{ route('on_dvd') }}">On DVD</a>
        </li>
    </ul>
</section>