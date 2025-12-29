@extends('front.partials.app')

@section('content')

<!--------------------------Our Courses Start------------------------------>
<div class="about-banner">
    <img src="{{ asset('images/video-gallery.jpg') }}" class="img-responsive"/>
</div>

<div class="about-title"></div>

<div class="communite-block">
    <div class="container">
        <div class="row">

            @foreach($videos as $video)
                <div class="col-lg-4 col-sm-4">
                    <div class="big-box">
                        <div class="small-box">
                            <iframe
                                class="yt_players"
                                id="player{{ $loop->index }}"
                                width="385"
                                height="230"
                                src="https://www.youtube.com/embed/{{ $video->url }}?rel=0&wmode=Opaque&enablejsapi=1&showinfo=0&controls=0"
                                frameborder="0"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>

<script>
    let players = [];

    function onYouTubeIframeAPIReady() {
        let temp = document.querySelectorAll("iframe.yt_players");

        temp.forEach((iframe) => {
            let player = new YT.Player(iframe.id, {
                events: {
                    onStateChange: onPlayerStateChange
                }
            });
            players.push(player);
        });
    }

    function onPlayerStateChange(event) {
        if (event.data === YT.PlayerState.PLAYING) {
            players.forEach(player => {
                if (player !== event.target) {
                    player.stopVideo();
                }
            });
        }
    }
</script>

<!--------------------------Our Courses End------------------------------>

@endsection
