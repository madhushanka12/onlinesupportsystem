<!DOCTYPE html>
<html lang="en">

<head>
    <title>PVCU</title>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js">
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/lightbox.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />

</head>

<body>

    @includeIf('front.components.menus.header')

    @yield('content')

    @includeIf('front.components.menus.footer')

    @includeIf('front.components.widgets.confirm')


    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets/js/swiper.js') }}"></script>
    <script src="{{ asset('assets/js/lightbox.js') }}"></script>


    <script>
        let swiper5 = new Swiper(".mySwiper5", {
            slidesPerView: 4,
            spaceBetween: 40,
            navigation: {
                nextEl: ".sn5",
                prevEl: ".sp5",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                1440: {
                    slidesPerView: 4,
                    spaceBetween: 40,
                },
            },
            keyboard: true,
        });
    </script>



<script>
    document.getElementById('our-vision-visit').addEventListener('click', function() {
        window.location.href = "{{ route('front.vision') }}";
    });
</script>

</body>

</html>

