@foreach(App\Http\Controllers\HomeController::latestPost('6') as $article)
  <div class="card">
    <div class="img__container">
      <img src="{{ berkas($article->picture) ?: url('berkas/' . $article->picture) }}" alt="">
    </div>
    <div class="content__container">
      <div class="content__topbar">
        <div class="content__date me-3">
          <i class="fa-solid fa-calendar-days"></i>
          <span>{{ $article->updated_at->diffForHumans() }}</span>
        </div>
        <div class="content__cat">
          <i class="fa-solid fa-tag"></i>
          <span>{{ $article->ctitle }}</span>
        </div>
      </div>
      <h2 class="content__title">
        <a href="{{ url('/detail-post/'.$article->seotitle) }}">
          {{ Illuminate\Support\Str::limit($article->title, 60) }}
        </a>
      </h2>
      <p class="content__desc">
        {{ strip_tags(Illuminate\Support\Str::limit($article->content, 120)) }}
      </p>
      <a href="{{ url( '/detail-post/'. $article->seotitle) }}" class="content__button float-end">Selengkapnya...</a>
    </div>
  </div>
@endforeach
