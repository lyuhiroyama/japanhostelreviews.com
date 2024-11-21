

<head>
    <style>
        .center-panel {
            flex-grow: 1; /* Not exactly sure how this works, but it fills up the centre of viewport dynamically */
            margin-left: 270px;
        }

        .hostel-container {
            height: 130px;
            margin: 20px;
        }

        .hostel {
            display: flex;
        }

        .hostel-info { /* container with info excluding thumbnail */
            padding: 0 20px;
            line-height: 1.5;
        }
        

        .thumbnail {
            width: 200px;
            height: 120px;
            object-fit: contain; /* Fills content box while maintaining aspect ratio */
        }

        h3.hostel-title a:visited {
            color: grey;
        }

        .hostel-voting-container {
            margin: 10px 0;
            width: auto; /* Adjusts width to fit its contents dynamically */
            border-radius: 50px;
            background-color: #e6deca;
            display: inline-flex;
            align-items: center;
        }

        .hostel-voting-container button {
            color: #a3780d;
            font-size: 20px;
            border: none;
            background-color: transparent;
            width: 30px;
            height: 30px;
            cursor: pointer;
        }

        .hostel-voting-container button:hover {
            color: #ff0000;
            background-color: #f3e7ca;
            border-radius: 50px;
        }

        .hostel-voting-container span {
            margin: 0 5px; /* Spacing */
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="center-panel"></div>
    <script>

        $(document).ready(function() {
            fetchHostels(); // Initial fetch

            $('#search-box').on('input', function() {
                const query = $(this).val();
                fetchHostels(query);
            })
        })

        // Fetch & Dipslay hostels
        function fetchHostels(query = '') {
            $.getJSON('get_hostels.php', {q: query}, function(hostels) {
                $('.center-panel').empty(); // Clear previous results
                
                hostels.forEach(hostel => {
                    $('.center-panel').append(`
                        <div class="hostel-container">

                                <div class="hostel">
                                    <a href="hostel_details.php?id=${hostel.id}">
                                        <img src="${hostel.thumbnail}" class="thumbnail">
                                    </a>
                                    <div class="hostel-info">
                                        <h3 class="hostel-title">
                                            <a href="hostel_details.php?id=${hostel.id}">
                                            ${hostel.name}
                                            </a>
                                        </h3>
                                        <p>Location: ${hostel.location}</p>
                                        <p>Price Range: ${hostel.price_range}</p>
                                        <div class="hostel-voting-container">
                                            <button class="upvote" data-id="${hostel.id}">⬆</button>
                                            <span class="vote-count">${hostel.upvote - hostel.downvote}</span>
                                            <button class="downvote" data-id="${hostel.id}">⬇</button>
                                        </div>

                                    </div>
                                </div>

                        </div>
                        <hr>
                    `)
                })
            
                // Handle upvlote/downvote clicks:
                $('.upvote').click( function() {
                    const hostelId = $(this).data('id');
                    let bool = trackHostelVote(hostelId, 'upvote');
                    if (bool) {updateVote(hostelId, 'upvote')};
                });
                $('.downvote').click( function() {
                    const hostelId = $(this).data('id');
                    let bool = trackHostelVote(hostelId, 'downvote');
                    if (bool) {updateVote(hostelId, 'downvote')};
                });
            
            })
        } // endof fetchHostels()

        function updateVote(hostelId, voteType) {
            $.post('update_hostel_votes.php', {id: hostelId, vote: voteType}, () => {
                $('.center-panel').empty();
                fetchHostels();
            })
        } // endof updateVote()

        function trackHostelVote(hostelId, voteType) {
            let voteKey = `hostelVote_${hostelId}`;
            let existingVote = localStorage.getItem(voteKey);
            
            if (!existingVote) {
                localStorage.setItem(voteKey, voteType);
                return true;
            } else {
                return false;
            }
        } // endof trackHostelVote()
        
    </script>
</body>