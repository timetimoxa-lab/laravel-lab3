@extends('layouts.app')

@section('title', $film->title)

@section('content')
    <main class="container pb-5">
        <div class="film-header mb-4"
             style="--theme-main: {{ $film->accent_color }}; --theme-contrast: {{ $film->accent_text_color }}">
            <h1 class="h3 mb-0">{{ $film->title }} ({{ $film->release_year }})</h1>
        </div>

        <div class="row g-4">
            <div class="col-8 col-sm-6 col-md-4 mx-auto mx-md-0">
                {{-- Tooltip с названием при наведении --}}
                <img src="{{ $film->poster_url }}" class="img-fluid rounded poster-img"
                     alt="Постер фильма «{{ $film->title }}»"
                     data-bs-toggle="tooltip" data-bs-title="{{ $film->title }}">
            </div>

            <div class="col-12 col-md-8">
                <dl class="facts row mb-3">
                    <dt class="col-sm-4">Оригинал</dt><dd class="col-sm-8">{{ $film->original_title ?? '—' }}</dd>
                    <dt class="col-sm-4">Дата выхода</dt><dd class="col-sm-8">{{ $film->released_at->format('d.m.Y') }}</dd>
                    <dt class="col-sm-4">Роль</dt><dd class="col-sm-8">{{ $film->role }}</dd>
                    <dt class="col-sm-4">Жанр</dt><dd class="col-sm-8">{{ $film->genre }}</dd>
                </dl>

                <p>{{ $film->description }}</p>

                <h2 class="h6 mt-4">Номинации и премии</h2>
                @if ($film->awards->isEmpty())
                    <p class="text-secondary">Данных о наградах нет.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead>
                                <tr><th>Год</th><th>Фильм</th><th>Премия</th><th>Статус</th></tr>
                            </thead>
                            <tbody>
                                @foreach ($film->awards as $award)
                                    <tr>
                                        <td>{{ $award->award_year }}</td>
                                        <td>{{ $film->title }}</td>
                                        <td>{{ $award->award_name }}: {{ $award->category }}</td>
                                        <td>
                                            @if ($award->is_winner)
                                                <span class="badge text-bg-success">Победа</span>
                                            @else
                                                <span class="badge text-bg-secondary">Номинация</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <a href="{{ route('films.index') }}" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i>Назад
                    </a>
                    <a href="{{ route('films.edit', $film) }}" class="btn btn-primary">
                        <i class="fa-solid fa-pen me-1"></i>Редактировать
                    </a>
                    <form action="{{ route('films.destroy', $film) }}" method="POST"
                          onsubmit="return confirm('Удалить фильм «{{ $film->title }}»?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fa-solid fa-trash me-1"></i>Удалить
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
