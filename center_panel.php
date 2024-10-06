

<head>
    <style>
        .center-panel {
            flex-grow: 1; /* Not exactly sure how this works, but it fills up the centre of viewport dynamically */
        }

        .hostel-container {
            height: 200px;
            margin: 20px;
            border: black 1px solid;
        }

        .hostel {
            display: flex;
        }

        .thumbnail {
            width: 200px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="center-panel"></div>
    <script>
        // Fetch & Dipslay hostels
        function fetchHostels() {
            $.getJSON('get_hostels.php', function(hostels) {
                $('#hostel-list').empty();
                hostels.forEach(hostel => {
                    $('.center-panel').append(`
                        <div class="hostel-container">
                            <a href="hostel_details.php?id=${hostel.id}">
                                <div class="hostel">
                                    <div class="hostel-info">
                                        <h3>${hostel.name}</h3>
                                        <p>${hostel.description}</p>
                                        <p>Location: ${hostel.location}</p>
                                        <p>Price Range: ${hostel.price_range}</p>
                                        <p>Rating: ${hostel.rating}</p>
                                    </div>
                                    <img src="${hostel.thumbnail}" class="thumbnail">
                                </div>
                            </a>
                        </div>
                    `)
                })
            })
        }

        $(document).ready(fetchHostels);
        
    </script>
</body>