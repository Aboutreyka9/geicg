
(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
   function backToTop() {
         // Back to top button
    $(window).scroll(function () {
        // if ($(this).scrollTop() > 300) {
            if ($(this).scrollTop() > 50) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });
    }


    sidebarToggler();
    function sidebarToggler() {
        // Sidebar Toggler
alert('sidebarToggler');
        $('.sidebar-toggler').click(function () {
            $('.sidebar, .content').toggleClass("open");
            return false;
        });

        $('.sidebar-toggler').on('click', function () {
            $('body').toggleClass('sidebar-expanded');
            $('.sidebar-toggler i').toggleClass('fa-times fa-bars');
        }
        );
    }


 
    function progressBar() {
        // Progress Bar
        $('.pg-bar').waypoint(function () {
            $('.progress .progress-bar').each(function () {
                $(this).css("width", $(this).attr("aria-valuenow") + '%');
            });
        }, {offset: '80%'});
        // Initialize progress bars
        // Set progress bar width from data attribute
        // $('.progress .progress-bar').each(function () {
        //     var width = $(this).data('width');
        //     $(this).css('width', width + '%');
        // });
    }


    function calendar() {
        // Calender
        $('#calender').datetimepicker({
            inline: true,
            format: 'L'
        });
        // Initialize fullCalendar if the element exists
        // if ($('#calendar').length) {
        //     $('#calendar').fullCalendar({
        //         header: {
        //             left: 'prev,next today',
        //             center: 'title',
        //             right: 'month,agendaWeek,agendaDay'
        //         },
        //         defaultDate: '2023-10-01',
        //         editable: true,
        //         events: [
        //             {
        //                 title: 'All Day Event',
        //                 start: '2023-10-01'
        //             },
        //             {
        //                 title: 'Long Event',
        //                 start: '2023-10-07',
        //                 end: '2023-10-10'
        //             }
        //         ]
        //     });
        // }
    }


    function testimonialsCarousel() {
        // Testimonials Carousel
        $(".testimonial-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 1000,
            items: 1,
            dots: true,
            loop: true,
            nav : false
        });
        // Initialize the testimonials carousel if the element exists
    
        // if ($('.testimonials-carousel').length) {
        //     $('.testimonials-carousel').owlCarousel({
        //         loop: true,
        //         margin: 30,
        //         nav: true,
        //         autoplay: true,
        //         autoplayTimeout: 5000,
        //         autoplayHoverPause: true,
        //         responsive: {
        //             0: {
        //                 items: 1
        //             },
        //             768: {
        //                 items: 2
        //             },
        //             992: {
        //                 items: 3
        //             }
        //         }
        //     });
        // }
    }


    // Worldwide Sales Chart
    function worldwideSalesChart() {
    var ctx1 = $("#worldwide-sales").get(0).getContext("2d");
    var myChart1 = new Chart(ctx1, {
        type: "bar",
        data: {
            labels: ["2016", "2017", "2018", "2019", "2020", "2021", "2022"],
            datasets: [{
                    label: "USA",
                    data: [15, 30, 55, 65, 60, 80, 95],
                    backgroundColor: "rgba(0, 156, 255, .7)"
                },
                {
                    label: "UK",
                    data: [8, 35, 40, 60, 70, 55, 75],
                    backgroundColor: "rgba(0, 156, 255, .5)"
                },
                {
                    label: "AU",
                    data: [12, 25, 45, 55, 65, 70, 60],
                    backgroundColor: "rgba(0, 156, 255, .3)"
                }
            ]
            },
        options: {
            responsive: true
        }
    });
    }


    // Sales and Revenue Chart
    function getRandomData() {
        var data = [];
        for (var i = 0; i < 12; i++) {
            data.push(Math.floor(Math.random() * 100) + 1);
        }
        return data;
    }

    function salesAndRevenueChart() {
        // Sales and Revenue Chart
        var ctx = $("#sales-revenue").get(0).getContext("2d");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Sales",
                    fill: false,
                    backgroundColor: "rgba(0, 156, 255, .3)",
                    data: getRandomData()
                }, {
                    label: "Revenue",
                    fill: false,
                    backgroundColor: "rgba(0, 156, 255, .7)",
                    data: getRandomData()
                }]
            },
            options: {
                responsive: true
            }
        });
    }

    function initCharts() {
    var ctx2 = $("#salse-revenue").get(0).getContext("2d");
    var myChart2 = new Chart(ctx2, {
        type: "line",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Salse",
                fill: false,
                backgroundColor: "rgba(0, 156, 255, .3)",
                data: getRandomData()
            }, {
                label: "Revenue",
                fill: false,
                backgroundColor: "rgba(0, 156, 255, .7)",
                data: getRandomData()
            }]
        },
        options: {
            responsive: true
        }
    });
    }

    function salseRevenue(){
        var ctx2 = $("#salse-revenue").get(0).getContext("2d");
    var myChart2 = new Chart(ctx2, {
        type: "line",
        data: {
            labels: ["2016", "2017", "2018", "2019", "2020", "2021", "2022"],
            datasets: [{
                    label: "Salse",
                    data: [15, 30, 55, 45, 70, 65, 85],
                    backgroundColor: "rgba(0, 156, 255, .5)",
                    fill: true
                },
                {
                    label: "Revenue",
                    data: [99, 135, 170, 130, 190, 180, 270],
                    backgroundColor: "rgba(0, 156, 255, .3)",
                    fill: true
                }
            ]
            },
        options: {
            responsive: true
        }
    });
    }

    


    // Single Line Chart
    function initSingleLineChart() {
    var ctx3 = $("#line-chart").get(0).getContext("2d");
    var myChart3 = new Chart(ctx3, {
        type: "line",
        data: {
            labels: [50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150],
            datasets: [{
                label: "Salse",
                fill: false,
                backgroundColor: "rgba(0, 156, 255, .3)",
                data: [7, 8, 8, 9, 9, 9, 10, 11, 14, 14, 15]
            }]
        },
        options: {
            responsive: true
        }
    });
    }


    // Single Bar Chart
    function initSingleBarChart() {
    var ctx4 = $("#bar-chart").get(0).getContext("2d");
    var myChart4 = new Chart(ctx4, {
        type: "bar",
        data: {
            labels: ["Italy", "France", "Spain", "USA", "Argentina"],
            datasets: [{
                backgroundColor: [
                    "rgba(0, 156, 255, .7)",
                    "rgba(0, 156, 255, .6)",
                    "rgba(0, 156, 255, .5)",
                    "rgba(0, 156, 255, .4)",
                    "rgba(0, 156, 255, .3)"
                ],
                data: [55, 49, 44, 24, 15]
            }]
        },
        options: {
            responsive: true
        }
    });
    }


    // Pie Chart
    function initPieChart() {
    var ctx5 = $("#pie-chart").get(0).getContext("2d");
    var myChart5 = new Chart(ctx5, {
        type: "pie",
        data: {
            labels: ["Italy", "France", "Spain", "USA", "Argentina"],
            datasets: [{
                backgroundColor: [
                    "rgba(0, 156, 255, .7)",
                    "rgba(0, 156, 255, .6)",
                    "rgba(0, 156, 255, .5)",
                    "rgba(0, 156, 255, .4)",
                    "rgba(0, 156, 255, .3)"
                ],
                data: [55, 49, 44, 24, 15]
            }]
        },
        options: {
            responsive: true
        }
    });
    }


    // Doughnut Chart
    function initDoughnutChart() {
    var ctx6 = $("#doughnut-chart").get(0).getContext("2d");
    var myChart6 = new Chart(ctx6, {
        type: "doughnut",
        data: {
            labels: ["Italy", "France", "Spain", "USA", "Argentina"],
            datasets: [{
                backgroundColor: [
                    "rgba(0, 156, 255, .7)",
                    "rgba(0, 156, 255, .6)",
                    "rgba(0, 156, 255, .5)",
                    "rgba(0, 156, 255, .4)",
                    "rgba(0, 156, 255, .3)"
                ],
                data: [55, 49, 44, 24, 15]
            }]
        },
        options: {
            responsive: true
        }
    });
    }

    
})(jQuery);

