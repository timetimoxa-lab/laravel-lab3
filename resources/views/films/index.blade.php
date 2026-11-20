@extends('layouts.app')

@section('content')
    <header class="hero container d-flex flex-wrap align-items-end justify-content-between gap-3">
        <div>
            <h1>Фильмография Джека Николсона</h1>
            <p class="lead mb-0">Справочник для киноакадемиков: ключевые роли, жанры, номинации и награды.</p>
        </div>
        <a href="{{ route('films.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i>Добавить
        </a>
    </header>

    <main class="container pb-5 mt-3">
        @if ($films->isEmpty())
            <div class="alert alert-info">Фильмов пока нет. Нажмите «Добавить», чтобы создать первый.</div>
        @else
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xxxl-5 g-4 justify-content-start">
                @foreach ($films as $film)
                    @php($oscar = $film->awards->firstWhere('award_name', 'Оскар'))
                    <div class="col">
                        <article class="card object-card h-100"
                                 style="--theme-main: {{ $film->accent_color }}; --theme-contrast: {{ $film->accent_text_color }}">
                            <div class="card-media position-relative">
                                <img src="{{ $film->poster_url }}" class="card-img-top img-fluid"
                                     alt="Постер фильма «{{ $film->title }}»">
                                <h2 class="card-title card-label h6 mb-0">{{ $film->title }}</h2>
                            </div>
                            <div class="card-body">
                                <p class="mb-1 text-secondary small">{{ $film->release_year }} · {{ $film->genre }}</p>
                                <p class="mb-2 small"><strong>Роль:</strong> {{ $film->role }}</p>
                                <p class="card-text">{{ $film->short_description }}</p>
                                @if ($oscar)
                                    <p class="mb-0">
                                        <span class="me-1">Оскар:</span>
                                        @if ($oscar->is_winner)
                                            <span class="badge text-bg-success">Победа</span>
                                        @else
                                            <span class="badge text-bg-secondary">Номинация</span>
                                        @endif
                                    </p>
                                @endif
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-3 d-flex flex-wrap gap-2">
                                <a href="{{ route('films.show', $film) }}" class="btn btn-details">Подробнее</a>
                                <a href="{{ route('films.edit', $film) }}" class="btn btn-outline-secondary" title="Редактировать">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('films.destroy', $film) }}" method="POST"
                                      onsubmit="return confirm('Удалить фильм «{{ $film->title }}»?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Удалить">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
@endsection
