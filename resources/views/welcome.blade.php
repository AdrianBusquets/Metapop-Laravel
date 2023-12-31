<x-layout>
    <x-slot name='title'></x-slot>
    <div class="container">
        <div class="row">
            <div class="col-6 col-sm-12">
                <h1>{{__('Estas son las diferentes categorías:') }}</h1>
            </div>
            <div class="col-12">
                <div class="row">
                    @foreach ($categories as $category)
                        <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                            <div class="card lista_categorias">
                                <div class="card-body">
                                    <h5 class="card-title text-center text-uppercase">{{ $category->name }}</h5>
                                    <i></i>
                                    <a class="categoriaShow" style="text-decoration:none" href="{{ route('category.ads', $category) }}" class="btn btn-primary">{{ __('Ver anuncios') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
        </div>




        <div class="row">
            <div class="col-6 col-sm-12">
                <h1>{{__('Estas son las últimas novedades:') }}</h1>
            </div>
        </div>
        <div class="row">
            @forelse ($ads as $ad)
            <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
                <div class="card mb-5 anuncios">
                    @if ($ad->images()->count() > 0)
                        <img src="{{ $ad->images()->first()->getUrl(400,300) }}" class="card-img-top" alt="...">
                    @else
                        <img src="https://via.placeholder.com/150" alt="..." class="card-img-top">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $ad->title }}</h5>
                        <h6 class="card-subtitle mb-2">{{ is_float($ad->price) ? number_format($ad->price, 2) : number_format($ad->price) }}€</h6>
                        <div class="card-subtitle mb-2">
                            <strong><a class="categoriaShow" style="text-decoration:none" href="{{ route('category.ads', $ad->category) }}">{{ __($ad->category->name) }}</a></strong>
                        </div>
                        <a href="{{ route('ads.show', $ad) }}" class="btn btn-primary mostrarMas">{{__('Mostrar Más') }}</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <h2>{{__('Parece que no hay ningun anuncio') }}</h2>
                <a href="{{ route('ads.create') }}" class="btn primerObjeto">{{__('Vende tu primer objeto') }}</a>
            
            @endforelse
        </div>
    </div>
    @includeIf('components.footer')
</x-layout>