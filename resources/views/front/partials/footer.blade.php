<!----------------------------Footer Start--------------------------->
<div class="sub-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-7">
                <p>Academy of Mass Communication &copy;2025 All Right Reserved.</p>
            </div>
            <div class="col-lg-6 col-sm-5">
                <div class="company-logo">
                    <img src="{{ asset('images/sonyinfocom.png') }}" class="img-responsive">
                </div>
            </div>
        </div>
    </div>
</div>
<!----------------------------Footer End----------------------------->

{{-- Owl Carousel --}}
<script src="{{ asset('owl-carousel/owl.carousel.js') }}"></script>

<style>
#owl-demo .item, #owl-demo1 .item, #owl-demo2 .item {
    display: block;
    margin: 0px 10px;
    color: #FFF;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    text-align: center;
}

.owl-theme .owl-controls .owl-buttons div {
    padding: 10px 11px;
}

.owl-theme .owl-buttons i {
    margin-top: 2px;
}

.owl-theme .owl-controls .owl-buttons div {
    position: absolute;
}

.owl-theme .owl-controls .owl-buttons .owl-prev {
    left: 0;
    top: 50%;
}

.owl-theme .owl-controls .owl-buttons .owl-next {
    right: 0px;
    top: 50%;
}

.owl-pagination {
    display: none;
}
</style>

<script>
$(document).ready(function () {

    function random(owlSelector) {
        owlSelector.children().sort(function () {
            return Math.round(Math.random()) - 0.5;
        }).each(function () {
            $(this).appendTo(owlSelector);
        });
    }

    $("#owl-demo").owlCarousel({
        navigation: true,
        navigationText: [
            "<i class='icon-chevron-left icon-white'></i>",
            "<i class='icon-chevron-right icon-white'></i>"
        ],
        beforeInit: function (elem) {
            random(elem);
        }
    });

    $("#owl-demo1").owlCarousel({
        navigation: true,
        navigationText: [
            "<i class='icon-chevron-left icon-white'></i>",
            "<i class='icon-chevron-right icon-white'></i>"
        ],
        beforeInit: function (elem) {
            random(elem);
        }
    });

    $("#owl-demo2").owlCarousel({
        navigation: true,
        navigationText: [
            "<i class='icon-chevron-left icon-white'></i>",
            "<i class='icon-chevron-right icon-white'></i>"
        ],
        beforeInit: function (elem) {
            random(elem);
        }
    });
});
</script>

<script>
$(window).scroll(function () {
    var height = $(window).scrollTop();
    if (height > 150) {
        $(".sub-header").addClass("pwdFxd");
    }
    if (height < 150) {
        $(".sub-header").removeClass("pwdFxd");
    }
});
</script>

</body>
</html>
