<aside class="sidebar">
    <form method="get" action="{{ url('event/search') }}">
        <div class="input-group input-group-lg">
            <input class="form-control" placeholder="Cari Event" name="query" id="s" type="text">
            <span class="input-group-btn">
										<button type="submit" class="btn btn-primary btn-lg"><i
                                                class="fa fa-search"></i></button>
									</span>
        </div>
    </form>

    <hr>

    <div class="tabs mb-xlg">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#eventPosts" data-toggle="tab">Event Lainnya</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="eventPosts">
                <ul class="simple-post-list">
                    @foreach(App\Http\Controllers\EventController::eventPost('6', '0', Request::segment(2) ) as $eventside)
                        <li>
                            @if($eventside->event_gambar != '')
                                <div class="post-image">
                                    <div class="img-thumbnail">
                                        <a href="{{ url('/detail-event/'.$eventside->event_seo) }}">
                                            <img src="{{ berkas($eventside->event_gambar) }}" width="50"
                                                 alt="">
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <div class="post-info">
                                <a href="{{ url('/detail-event/'.$eventside->event_seo) }}">{{ $eventside->event_nama }}</a>
                                <div
                                    class="post-meta">{{ date('d-m-Y', strtotime($events->event_tanggalmulai)).' s.d. '.date('d-m-Y', strtotime($events->event_tanggalselesai)) }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

</aside>
