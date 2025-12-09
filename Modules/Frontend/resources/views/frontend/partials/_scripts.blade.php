<script src="{{ asset('frontend-section/js/jquery.min.js') }}"></script>
<script src="{{ asset('frontend-section/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend-section/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('frontend-section/js/owl.carousel.js') }}"></script>
<script src="{{ asset('frontend-section/js/sweetalert2.all.min.js') }}"></script>

@if (in_array('animation',$assets ?? []))
    <script src="{{ asset('frontend-section/js/aos.js') }}"></script>
@endif

@if(in_array('videojs',$assets ?? []))
    <script src="{{ asset('frontend-section/js/video.min.js') }}"></script>
    <script src="{{ asset('frontend-section/js/youtube.min.js') }}"></script>
    <script src="{{ asset('frontend-section/js/hls.js') }}"></script>
    <script src="{{ asset('frontend-section/js/videojs.hotkeys.min.js') }}"></script>
@endif

@if(in_array('firebase',$assets ?? []))
    <script src="{{ asset('frontend-section/js/firebase-app.js') }}"></script>
    <script src="{{ asset('frontend-section/js/firebase-auth.js') }}"></script>
    <script src="{{ asset('frontend-section/js/firebase-firestore.js') }}"></script>    
@endif

@if(in_array('phone',$assets ?? []))
    <script src="{{ asset('vendor/intlTelInput/js/intlTelInput-jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/intlTelInput/js/intlTelInput.min.js') }}"></script>
@endif

@if (in_array('chart',$assets ?? []))
    <script src="{{ asset('frontend-section/js/apexcharts.min.js') }}"></script>
@endif


@yield('bottom_script')

<script>
    $(document).ready(function() {

        /*----------Sticky-Header-----------*/
        $(window).scroll(function () {
            var sticky = $('.main-nav, .user-header'),
            scroll = $(window).scrollTop();

            if (scroll >= 10) {
                sticky.addClass('fixed');
            } else {
                sticky.removeClass('fixed');
            }
        });

        // START LAZY LOAD MORE  
        
        let page = 1;
        
        function initLoadMore(sectionId) {
            const loadMoreButton = $(sectionId).find('.load-more-btn');
            loadMoreButton.on('click', function() {
                page++;
                loadMoreContent(sectionId, page);
            });

        }

        function loadMoreContent(sectionId, page) {
            const loadMoreButton = $(sectionId).find('.load-more-btn');
            const currentRoute = $(sectionId).find('[data-route]').data('route');

            if (!currentRoute) {
                return;
            }

            $.ajax({
                url: currentRoute + "?page=" + page,
                dataType: 'json',
                type: "GET",
            })
            .done(function(response) {
                
                if (response.html) {
                    $(sectionId).find('#load_more').append(response.html);
                }

                // if (response.pagination.currentPage >= response.pagination.totalPages) {
                //     loadMoreButton.hide(); // Hide the button when all data is loaded
                // }

                if (!response.html || response.pagination.currentPage >= response.pagination.totalPages) {
                    loadMoreButton.hide();
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.log('Server error occurred:', errorThrown);
            });
        }

        const sections = [
            '#bodypart-exercise-section',
            '#equipment-exercise-section',
            '#workout-level-section',
            '#diet-categories-section',
            '#dietary-section',
            '#product-categories-section',
            '#product-accessories-section',
            '#recent-blog-section',
            '#trending-blog-section'
        ];

        sections.forEach(sectionId => {
            initLoadMore(sectionId);
        });

        // END LAZY LOAD MORE 
    
        // START PRIMARY COLOR OPACITY 

        var siteColor = $(':root').css('--site-color').trim();
        var rgbaSiteColor = siteColor + '33'; 

        $('.related-blogs').css({
            'background-color': rgbaSiteColor,
            'border-left-color': siteColor
        });

        
        $('.price-subcard, .tips, .ingredients-data').css({
            'background-color': rgbaSiteColor
        });

        $('.sidebar-content .nav-link.active').css({
            'background-color': rgbaSiteColor
        });


        let hexColor = siteColor;
        let rgbColor = hexToRgb(hexColor);

        ['.related-blogs', '.price-subcard', '.tips','.ingredients-data','sidebar-content .nav-link.active'].forEach(function(selector) {
        if ($(selector).length) {
                hexColor;
            }
        });

        // END PRIMARY COLOR OPACITY 

        // START PRODUCTS SECTION

        if ($('.blockquote-card').length) {
                
            $('.blockquote-card').first().addClass('selected');
            $('.blockquote-card').on('click', function() {
                exercisesCard('blockquote', this, hexColor)
            });
        }
        if ($('.fitness-product-card').length) {
            $('.fitness-product-card').first().addClass('selected');
            $('.fitness-product-card').on('click', function() {
                exercisesCard('fitness-product', this, hexColor);
            });
            $('.fitness-product-card').first().trigger('click');
        }
        
        // END PRODUCTS SECTION

        // START OWL CAROUSEL SECTION

        $("#client-slider").owlCarousel({
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },                
                980: {
                    items: 2
                },
                1199: {
                    items: 2
                },
            },
            dots: false,
            navigation: false,
            pagination: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            rtl: $("html").attr("dir") === "rtl" ? true : false
        });

        $("#diet-slider").owlCarousel({
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                700: {
                    items: 4
                },                
                980: {
                    items: 5
                },
                1199: {
                    items: 7
                },
            },
            dots: false,
            navigation: false,
            pagination: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            rtl: $("html").attr("dir") === "rtl" ? true : false
        });

        $("#blog-slider").owlCarousel({
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },                
                980: {
                    items: 1
                },
                1199: {
                    items: 1
                },
            },
            dots: true,
            pagination: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            rtl: $("html").attr("dir") === "rtl" ? true : false
        });

        $("#body-part-slider").owlCarousel({
            responsive: {
                0: {
                    items: 2
                },
                400: {
                    items: 3
                },
                600: {
                    items: 4
                },
                980: {
                    items: 5
                },
                1199: {
                    items: 7
                },
                1400: {
                    items: 10
                }
            },
            dots: false,
            navigation: false,
            pagination: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            rtl: $("html").attr("dir") === "rtl" ? true : false
        });

        $("#equipment-slider").owlCarousel({
            responsive: {
                0: {
                    items: 2
                },
                500: {
                    items: 3
                },
                600: {
                    items: 3
                },
                980: {
                    items: 5
                },
                1199: {
                    items: 7
                },
            },
            dots: false,
            navigation: false,
            pagination: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            rtl: $("html").attr("dir") === "rtl" ? true : false
        });

        $("#workout-slider").owlCarousel({
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                980: {
                    items: 3
                },
                1199: {
                    items: 4
                },
                1400: {
                    items: 5
                }
            },
            dots: false,
            navigation: false,
            pagination: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            rtl: $("html").attr("dir") === "rtl" ? true : false
        });

        $("#product-slider").owlCarousel({
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                980: {
                    items: 5
                },
                1199: {
                    items: 7
                },
            },
            dots: false,
            navigation: false,
            pagination: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            rtl: $("html").attr("dir") === "rtl" ? true : false
        });

        // END OWL CAROUSEL SECTION

        //LOADER
        $("#loader").hide();
        //END LOADER

        // START BACK TO TOP 
        if ($('.back-to-top').length) {
            $('.back-to-top').css('visibility', 'hidden').hide();

            $(window).on('scroll', function() {
                const scrollTop = $(this).scrollTop();
                const scrollHeight = $(document).height() - $(window).height();
                const scrollPercentage = (scrollTop / scrollHeight) * 100;

                if (scrollTop > 100) {
                    $('.back-to-top').fadeIn().css('visibility', 'visible');
                } else {
                    $('.back-to-top').fadeOut();
                }

                if ($('#scrollProgressBar').length) {
                    $('#scrollProgressBar').css('width', scrollPercentage + '%');
                }
            });

            $('.back-to-top').click(function() {
                $('html, body').animate({ scrollTop: 0 }, 100, 'swing');
                return false;
            });
        }
        // END BACK TO TOP


        // START INDEX PAGE SEARCH TOGGLE 

        $('#search-toggle').click(function(e) {
            e.preventDefault();
            $('#search-bar-container').toggleClass('active');
        });
        // END INDEX PAGE SEARCH TOGGLE

        // Start search 
        $('#search-query').on('input', function () {
            let query = $(this).val();
            let section = $("input[name='section']").val();
            let data_id = $("input[name='section']").attr('data-id') || '';
            
            getSearchQueryText(query);

            if (query.length > 0) {
                $.ajax({
                    url: "{{ route('search.suggestions') }}",
                    type: "GET",
                    data: {
                        query: query,
                        section: section,
                        'slug' : data_id
                    },
                    success: function (data) {
                        let suggestions = $('#suggestions');
                        suggestions.empty();
                        
                        if (data.length > 0) {
                            suggestions.show();
                            $.each(data, function (index, item) {
                                let searchUrl = "{{ route('search') }}?query=" + encodeURIComponent(item) + "&section=" + encodeURIComponent(section);

                                suggestions.append('<li class="list-group-item suggestion-item">' +
                                    '<a class="text-decoration-none text-muted suggestion-data" href="' + searchUrl + '">' + item + '</a>' +
                                    '</li>');
                            });
                            $('.search-data-list').css('z-index','1');
                        } else {
                            suggestions.hide();
                            $('.search-data-list').css('z-index','1');
                        }
                    }
                });
            } else {
                $('.search-data-list').css('z-index','1');
                $('#suggestions').hide();
            }
        });

        $(document).on('click', '.suggestion-item', function () {
            $('#search-query').val($(this).text());
            $('#suggestions').hide();
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest('.search-group').length) {
                $('.search-data-list').css('z-index','1');
                $('#suggestions').hide();
            }
        });
         // End search 

         function getSearchQueryText(q){
            let filter_type = $('.filter-btn.active').attr('filter-type');
            let data_key = $('#get-dynamic-data-list').attr('data-type-key');
            getWorkoutList(filter_type,'',data_key,q);
        }

         // START WORKOUT
        let data_key = $('#get-dynamic-data-list').attr('data-type-key');
        @if(in_array('dynamic_list',$assets ?? []))
            getWorkoutList('all','',data_key);
        @endif

        $(document).on('click', '.filter-btn', function () {
            let filter_type = $(this).attr('filter-type');
            let data_key = $('#get-dynamic-data-list').attr('data-type-key');
            page = 1;
            getWorkoutList(filter_type,'',data_key);
        });

        $(document).on('click', '#dynamic-workout-data-load-btn', function () {
            let filter_type = $('.filter-btn.active').attr('filter-type');
            let data_key = $(this).attr('data-keys');
            let selected_type = $('.select-clear-all-btn').attr('selected-type');
            page++;
            getWorkoutList(filter_type,selected_type,data_key,'',page);
        });

        function getWorkoutList(filter_type,selected_type,data_type_key,q,page = 1) {
            var q = $('#search-query').val();            
            let dynamic_ids_name = filter_type + '_ids';            
            let selected_container = getSelectedCheckboxValues(filter_type +'_container');
            
            if (filter_type) {
                $.ajax({
                    url: "{{ route('get.all.workouts.list') }}",
                    type: 'get',
                    data: {
                        'filter_type': filter_type,
                        [dynamic_ids_name]: selected_container,
                        'selected_type': selected_type,
                        'data_key': data_type_key,
                        'q' : q,
                        'page' : page,
                    },
                    dataType: 'json',
                    success: function (response) {

                        if (response.append_status) {
                            $(response.data_id).append(response.data);
                        }else{
                            $(response.data_id).html(response.data);

                            if ( response.pagination.total_items == 0 ) {
                                $('.dynamic-no-data-fount').removeClass('d-none');
                            }

                        }
                        if (!response.data || response.pagination.currentPage >= response.pagination.totalPages) {
                            $('#dynamic-workout-data-load-btn').hide();
                        }

                    }
                });
            }
        }

        function getSelectedCheckboxValues(containerId) {
            let selectedValues = [];
            $('#' + containerId + ' input:checked').each(function () {
                selectedValues.push($(this).attr('id'));
            });
            return selectedValues;
        }
        
        $(document).on('change', '.tab_dynamic_container input', function () {
            let filter_type = $('.filter-btn.active').attr('filter-type') || 'all';
            let data_key = $('#get-dynamic-data-list').attr('data-type-key');

            // $('.tab_dynamic_container input:not(:checked)').length === 0
            let checked_status = $('#' + filter_type + '_container input[type="checkbox"]').length == $('#' + filter_type + '_container input[type="checkbox"]:checked').length;
            let selected_type = 'select_all';

            if ( checked_status ) {
                selected_type = 'clear_all';
            }
            page = 1;
            getWorkoutList(filter_type,selected_type,data_key);
        });

        function getSelectedCheckboxValues(containerId) {
            let selectedValues = [];
            $('#' + containerId + ' input:checked').each(function () {
                selectedValues.push($(this).attr('id'));
            });

            return selectedValues;
        }

        $(document).on('click', '.select-clear-all-btn', function () {
            let filter_checked_type = $(this).attr('filter-checked-type');
            let selected_type = $(this).attr('selected-type');

            if (selected_type === 'select_all') {
                $('#' + filter_checked_type + '_container input').prop('checked', true);
                selected_type = 'clear_all';
            } else {
                $('#' + filter_checked_type + '_container input').prop('checked', false);
                selected_type = 'select_all';
            }
            let data_key = $('#get-dynamic-data-list').attr('data-type-key');
            page = 1;                 
            getWorkoutList(filter_checked_type,selected_type,data_key);
        });

        // END WORKOUT

        // START LIGHT & DARK 

        const darkModeBtn = $('.sit_darkcolor_theam');
        const lightModeBtn = $('.sit_lightcolor_theam');
        const userIsLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
        const appstoreImage = $('#appstoreImage');
        const playstoreImage = $('#playstoreImage');
        const trustpilotImage = $('#trustpilotImage');
        const bannerImage = $('#bannerImage');
        const phoneImage = $('#phoneImage');
        const googleImage = $('#googleImage');
        const videoNotsupported = $('#video-notsupported');

        function updateImages(theme) {
            if (theme === 'dark') {
                appstoreImage.attr('src', '{{ asset('frontend-section/images/app-store-dark.png') }}');
                playstoreImage.attr('src', '{{ asset('frontend-section/images/play-store-dark.png') }}');
                trustpilotImage.attr('src', '{{ asset('frontend-section/images/trust-dark.png') }}');
                bannerImage.attr('src', '{{ asset('frontend-section/images/banner-dark.png') }}');
                phoneImage.attr('src', '{{ asset('frontend-section/images/phone-dark.png') }}');
                googleImage.attr('src', '{{ asset('frontend-section/images/google-dark.png') }}');
                videoNotsupported.attr('src', '{{ asset('frontend-section/images/no-support-dark.png') }}');
            } else {
                appstoreImage.attr('src', '{{ asset('frontend-section/images/app-store-light.png') }}');
                playstoreImage.attr('src', '{{ asset('frontend-section/images/play-store-light.png') }}');
                trustpilotImage.attr('src', '{{ asset('frontend-section/images/trust.png') }}');
                bannerImage.attr('src', '{{ asset('frontend-section/images/banner-frame.png') }}');
                phoneImage.attr('src', '{{ asset('frontend-section/images/phone-light.png') }}');
                googleImage.attr('src', '{{ asset('frontend-section/images/google-light.png') }}');
                videoNotsupported.attr('src', '{{ asset('frontend-section/images/no-support-light.png') }}');
            }
        }

        function setTheme(theme, savePreference = true) {
            $('body').removeClass('light-mode dark-mode').addClass(`${theme}-mode`);
            updateImages(theme);
            
            if (theme === 'dark') {
                darkModeBtn.hide();
                lightModeBtn.show();
            } else {
                darkModeBtn.show();
                lightModeBtn.hide();
            }

            if (userIsLoggedIn) {
                if (savePreference) {
                    $.ajax({
                        url: '{{ route("setTheme") }}',
                        method: 'POST',
                        data: {
                            theme: theme,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                }
            } else {                
                if (savePreference) {
                    localStorage.setItem('theme', theme);
                }
            }
        }

        $(function () {
            let savedTheme = userIsLoggedIn ? null : localStorage.getItem('theme');
            let initialTheme = $('body').hasClass('dark-mode') ? 'dark' : 'light';

            if (savedTheme) {
                setTheme(savedTheme, false);
            } else {
                setTheme(initialTheme, false);
            }
        });

        darkModeBtn.on('click', function () {
            setTheme('dark');
        });

        lightModeBtn.on('click', function () {
            setTheme('light');
        });
        // END LIGHT & DARK
    });

    function hexToRgb(hex) {
        // Remove the hash at the start if it's there
        hex = hex.replace(/^#/, '');

        // Parse r, g, b values
        let r = parseInt(hex.substring(0, 2), 16);
        let g = parseInt(hex.substring(2, 4), 16);
        let b = parseInt(hex.substring(4, 6), 16);

        let rgbColor = `rgba(${r}, ${g}, ${b}, ${0.2} )`;
        
        // Apply the RGB color using jQuery
        $('.blockquote-card.selected .blockquote-card-inner').css('background-color', rgbColor);
        $('.fitness-product-card.selected .fitness-product-card-inner').css('background-color', rgbColor);
        $('.diet-details').css('background-color', rgbColor);
    }

    function exercisesCard(className, thisCard, hexColor)
    {
        $('.'+className+'-card').removeClass('selected');
        $(thisCard).addClass('selected');
        var index = $(thisCard).data('index');
        $('.'+className+'-image').addClass('d-none');
        $('#'+className+'-image-' + index).removeClass('d-none');

        $('.'+className+'-card').removeClass('selected');

        $('.'+className+'-card-inner').removeAttr('style')
        $(thisCard).addClass('selected');

        hexToRgb(hexColor)
    }

    $('#join_for_free').click(function(e) {
        e.preventDefault();
        $('#show').toggleClass('d-none');
    });

    // END INDEX PAGE SEARCH TOGGLE

    // START PASSWORD TOGGLE
    const togglePasswords = document.querySelectorAll('.togglePassword');
    const passwords = document.querySelectorAll('.password');

    togglePasswords.forEach((toggle, index) => {
        toggle.addEventListener('click', function() {
            const type = passwords[index].getAttribute('type') === 'password' ? 'text' : 'password';
            passwords[index].setAttribute('type', type);

            const eyeIcon = toggle.querySelector('.icon-hide');
            const eyeSlashIcon = toggle.querySelector('.icon-show');
            
            if (type === 'password') {

                eyeIcon.style.display = 'block';
                eyeSlashIcon.style.display = 'none';
   
            } else {
                eyeIcon.style.display = 'none';
                eyeSlashIcon.style.display = 'block';
            }
        });
    });
    // END PASSWORD TOGGLE


    // START CONVERT WEIGHT

    $('input[name="weight_unit"]').change(function() {
        var weight = parseFloat($('#weight-input').val());
        var unit = $(this).val();
        var convertedWeight;

        if (unit === 'lbs') {
            convertedWeight = (weight * 2.20462).toFixed(2); // Convert kg to lbs
        } else if (unit === 'kg') {
            convertedWeight = (weight / 2.20462).toFixed(2); // Convert lbs to kg
        }

        $('#weight-input').val(convertedWeight);
    });

    // END CONVERT WEIGHT

    // SATRT CONVERT HEIGHT

    $('input[name="height_unit"]').change(function() {
        var height = parseFloat($('#height-input').val());
        var unit = $(this).val();
        var convertedHeight;

        if (unit === 'feet') {
            convertedHeight = (height / 30.48).toFixed(2); // Convert cm to feet
        } else if (unit === 'cm') {
            convertedHeight = (height * 30.48).toFixed(2); // Convert feet to cm
        }

        $('#height-input').val(convertedHeight);
    });

    // END CONVERT HEIGHT

    // START FAVORITE

    $(document).on('click', '.toggle-favorite', function(e) {
        e.preventDefault();

        var button = $(this);
        var id = button.data('id');
        var type = button.data('type');
        var subtype = button.data('subtype');
        
        $.ajax({
            url: '{{ route('toggle.favorite') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                type: type
            },
            success: function(response) {                                
                if (response.success) {
                    if (subtype == 'diet-detail' || subtype == 'workout-detail') {
                        if (response.isFavorite) {
                            button.find('.favorite-icon').html(response.filledHeartSvg);

                        } else {
                            button.find('.favorite-icon').html(response.blankHeartSvg);
                        }
                        button.find('.favorite-text').text('{{ __("frontend::message.favorite") }}');
                    } else {
                        if (response.isFavorite) {
                            button.html(response.filledHeartSvg);

                        } else {
                            button.html(response.blankHeartSvg);
                        }
                    }
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                } else if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Failed to update favorite status.'
                    });
                }
            },
        });
    });

    // END FAVORITE

    // Change Status ajax
    $(document).ready(function(){
        $(document).on('change','.change_checked_status', function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var key_name = $(this).attr('data-name');
            var user_id = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route('change.setting.status') }}",
                data: { 'status': status, 'user_id': user_id ,'key_name': key_name },
                success: function(data){
                    if(data.status == false){
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        });
                    }else{
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        });
                    }
                }
            });
        });
    });
    
    // Start Phone authentication
    @if(in_array('firebase',$assets ?? []))
        const firebaseConfig = {
            apiKey: "{{ env('FIREBASE_API_KEY') }}",
            authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
            projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
            storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
            messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
            appId: "{{ env('FIREBASE_APP_ID') }}",
            measurementId: "{{ env('FIREBASE_MEASUREMENT_ID') }}"
        };

        
        firebase.initializeApp(firebaseConfig);
    @endif

    // END phone authentication

     //PHONE 
     var input = document.querySelector("#number");
        errorMsg = document.querySelector("#error-msg");
        validMsg = document.querySelector("#valid-msg");

        if (input) {
            var iti = window.intlTelInput(input, {
                hiddenInput: "contact_number",
                separateDialCode: true,
                utilsScript: "{{ asset('vendor/intlTelInput/js/utils.js') }}"
            });

            input.addEventListener("countrychange", function() {
                validate();
            });

            // // here, the index maps to the error code returned from getValidationError - see readme
            var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long",
                "Invalid number"
            ];
            //
            // // initialise plugin
            const phone = $('#number');
            const err = $('#error-msg');
            const succ = $('#valid-msg');
            var reset = function() {
                err.addClass('d-none');
                succ.addClass('d-none');
                validate();
            };

            // on blur: validate
            $(document).on('blur, keyup', '#number', function() {
                reset();
                var val = $(this).val();
                if (val.match(/[^0-9\.\+.\s.]/g)) {
                    $(this).val(val.replace(/[^0-9\.\+.\s.]/g, ''));
                }
                if (val === '') {
                    $('[type="submit"]').removeClass('disabled').prop('disabled', false);
                }
            });

            // on keyup / change flag: reset
            input.addEventListener('change', reset);
            input.addEventListener('keyup', reset);

            var errorCode = '';

            function validate() {
                if (input.value.trim()) {
                    if (iti.isValidNumber()) {
                        succ.removeClass('d-none');
                        err.html('');
                        err.addClass('d-none');
                        $('[type="submit"]').removeClass('disabled').prop('disabled', false);
                    } else {
                        errorCode = iti.getValidationError();
                        err.html(errorMap[errorCode]);
                        err.removeClass('d-none');
                        phone.closest('.form-group').addClass('has-danger');
                        $('[type="submit"]').addClass('disabled').prop('disabled', true);
                    }
                }
            }

            $('form').on('submit', function() {
                var fullNumber = iti.getNumber(); // Get full number with country code
                $('input[name="phone_number"]').val(fullNumber);
            });
        }
    @if(in_array('animation',$assets ?? []))
        AOS.init({
            once: true
        });
    @endif
</script>
@include('helper.app_message')
